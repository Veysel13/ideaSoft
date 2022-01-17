<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Ordered;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Campaign\Campaign;
use App\Models\Order\Order;
use App\Models\Order\OrderDiscount;
use App\Repository\OrderInterface;
use App\Repository\ProductInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $productRepository;
    private $orderRepository;

    public function __construct(ProductInterface $product, OrderInterface $order)
    {
        $this->productRepository = $product;
        $this->orderRepository = $order;
    }

    public function index()
    {

        $orders = Order::get();

        $blade = [];
        foreach ($orders as $order) {
            array_push($blade, new OrderResource($order));
        }

        return response()->json(['status' => 1, 'message' => '', 'data' => ['orders' => $blade]]);
    }

    public function add(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            'customerId'=>'required|numeric',
            'products'=>'required|array',
        ]);

        if($validation->fails()){
            return response()->json(['status' => 0, 'message' => $validation->messages()->first()], 400);
        }

        $products = $request->input('products');

        if (!$products) {
            return response()->json(['status' => 0, 'message' => 'Ürün gereklidir'], 400);
        }

        $cart=[
            'order'=>[
                'customer_id' => $request->input('customerId'),
                'total' => 0
            ],
            'orderProduct'=>[]
        ];

        foreach ($products as $item) {
            $product = $this->productRepository->findById($item['product_id']);

            if (!$product) {
                return response()->json(['status' => 0, 'message' => 'Ürün bulunamadı'], 400);
            }

            $total=$product->price * $item['quantity'];
            $cart['order']['total']+=$total;
            $orderProduct = [
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total' => $total,
            ];

            array_push($cart['orderProduct'],$orderProduct);
        }

        $isOrdered=new Ordered();
        if (!$isOrdered->is($cart)){
            return response()->json(['status' => 0, 'message' => $isOrdered->getErrorMessage()], 400);
        }

        $order = $this->orderRepository->create($cart);

        $result=Campaign::autoSelected($this->orderRepository->findById($order->id));

        $blade['order_id']=$order->id;
        $blade['discounts']=OrderDiscount::where('order_id',$order->id)->get();
        $blade['totalDiscount']=$result['totalDiscount'];
        $blade['discountedTotal']=$result['discountedTotal'];

        return response()->json($blade);
    }

    public function remove($id)
    {
        $order = $this->orderRepository->findById($id);

        if (!$order) {
            return response()->json(['status' => 0, 'message' => 'Sipariş bulunamadı'], 400);
        }

        $this->orderRepository->remove($order->id);

        return response()->json(['status' => 1, 'message' => 'Sipariş silindi']);
    }
}
