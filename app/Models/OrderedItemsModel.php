<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderedItemsModel extends Model
{
    use HasFactory;
    protected $table = 'ordered_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity'
    ];
    public function order()
    {
        return $this->belongsTo(OrdersModel::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuModel::class, 'item_id'); 
    }
}
