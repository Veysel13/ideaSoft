<?php


namespace App\Http\Resources;


use App\Models\Order\OrderDiscount;
use App\Models\Order\OrderProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customer_id,
            'total' => $this->total,
            'orderProduct' => OrderProduct::where('order_id',$this->id)->get(),
            'orderDiscount' => OrderDiscount::where('order_id',$this->id)->get(),
        ];
    }

}
