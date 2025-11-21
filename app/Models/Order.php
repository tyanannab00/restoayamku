<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{

    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_name',
        'email',
        'phone',
        'address',
        'quantity',
        'total_price',
        'notes',
        'status',
        'ip_address'
    ];
    

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'is_processed' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    protected $appends = ['formatted_total_price'];

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $attributes = [
        'status' => self::STATUS_PENDING
    ];

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}