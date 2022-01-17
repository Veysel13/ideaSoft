<?php


namespace App\Models\Campaign;


use App\Models\Order\OrderDiscount;
use App\Models\Order\OrderProduct;

class Campaign
{

    public static function allCampaigns()
    {
        return [
            [
                'model' => 'App\Models\Campaign\CategoryDiscount'
            ], [
                'model' => 'App\Models\Campaign\TotalDiscount'
            ]
        ];
    }

    public static function autoSelected($order)
    {

        foreach (self::allCampaigns() as $allCampaign) {
            if (class_exists($allCampaign['model'])) {

                $campaign = new $allCampaign['model']($order);

                if (method_exists($campaign, 'isUses') && $campaign->isUses() === true) {

                    if ($campaign->getAmount()<0){
                        OrderDiscount::create([
                            'order_id'=>$order->id,
                            'name'=>$campaign->getName(),
                            'key'=>$campaign->getKey(),
                            'total'=>$campaign->getAmount(),
                        ]);
                    }
                }
            }
        }

        $orderTotal = OrderProduct::where('order_id', $order->id)->sum('total');
        $orderDiscount = OrderDiscount::where('order_id', $order->id)->sum('total');

        $order->total=$orderTotal+$orderDiscount;
        $order->save();

        return [
            'totalDiscount'=>abs($orderDiscount),
            'discountedTotal'=>abs($order->total),
        ];
    }
}
