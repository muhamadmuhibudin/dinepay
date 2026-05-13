<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public const STATUS_PENDING = 'pending';

    public const STATUS_SETTLEMENT = 'settlement';

    public const STATUS_COOKED = 'cooked';

    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_METHOD_CASH = 'cash';

    public const PAYMENT_METHOD_QRIS = 'qris';

    public const PAYMENT_STATUS_PENDING = 'pending';

    public const PAYMENT_STATUS_PAID = 'paid';

    public const PAYMENT_STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_code',
        'user_id',
        'subtotal',
        'tax',
        'grand_total',
        'status',
        'table_number',
        'payment_method',
        'payment_status',
        'note',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'grand_total' => 'integer',
        'table_number' => 'integer',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SETTLEMENT,
            self::STATUS_COOKED,
            self::STATUS_CANCELLED,
        ];
    }

    public static function paymentMethods(): array
    {
        return [
            self::PAYMENT_METHOD_CASH,
            self::PAYMENT_METHOD_QRIS,
        ];
    }

    public static function paymentStatuses(): array
    {
        return [
            self::PAYMENT_STATUS_PENDING,
            self::PAYMENT_STATUS_PAID,
            self::PAYMENT_STATUS_FAILED,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
