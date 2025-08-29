<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'table_id',
        'order_type',
        'customer_phone',
        'status',
        'subtotal',
        'gst',
        'order_date',
        'ready_time',
        'notes',
        'payment_mode',
        'payment_status',
        'transaction_id',
        'payment_date'
    ];
    protected $casts = [
        'order_date' => 'datetime',
        'ready_time' => 'datetime',
        'payment_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'gst' => 'decimal:2'
    ];
    public function table()
    {
        return $this->belongsTo(TableModel::class);
    }
    public function items()
    {
        return $this->hasMany(OrderedItemsModel::class, 'order_id');
    }
    public function orderedItems()
    {
        return $this->hasMany(OrderedItemsModel::class);
    }
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopePreparing($query)
    {
        return $query->where('status', 'preparing');
    }
    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }
    public function scopeServed($query)
    {
        return $query->where('status', 'served');
    }
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
    public function scopeDineIn($query)
    {
        return $query->where('order_type', 'dine-in');
    }
    public function scopeTakeaway($query)
    {
        return $query->where('order_type', 'takeaway');
    }
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'pending');
    }
    public function getOrderNumberAttribute()
    {
        return 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
    public function getTotalAttribute()
    {
        return $this->subtotal + $this->gst;
    }
    public function getFormattedOrderDateAttribute()
    {
        return $this->order_date->format('d M Y, h:i A');
    }
    public function getFormattedPaymentDateAttribute()
    {
        return $this->payment_date ? $this->payment_date->format('d M Y, h:i A') : null;
    }
    public function getStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'preparing' => 'bg-blue-100 text-blue-800',
            'ready' => 'bg-green-100 text-green-800',
            'served' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800'
        ];

        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPaymentStatusBadgeColorAttribute()
    {
        $colors = [
            'pending' => 'bg-orange-100 text-orange-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-gray-100 text-gray-800'
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-100 text-gray-800';
    }
}
