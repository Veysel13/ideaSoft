<?php


namespace App\Models\Campaign;


use Illuminate\Database\Eloquent\Model;

class CampaignDb extends Model
{
    protected $table='campaigns';

    protected $fillable=[
        'order_id',
        'name',
        'key',
        'total',
    ];

}
