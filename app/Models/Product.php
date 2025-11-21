<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discounted_price',
        'category',
        'image_path',
        'preparation_time',
        'is_available',
        'stock'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'is_available' => 'boolean',
        'stock' => 'integer',
        'preparation_time' => 'integer'
    ];
    

    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discounted_price ?? $this->price
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->price, 0, ',', '.')
        );
    }

    protected function formattedDiscountedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discounted_price 
                ? 'Rp ' . number_format($this->discounted_price, 0, ',', '.') 
                : null
        );
    }

    protected function preparationTimeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->preparation_time . ' menit'
        );
    }


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }


    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeInCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeDiscounted($query)
    {
        return $query->whereNotNull('discounted_price');
    }


    public function hasStock(int $quantity): bool
    {
        if (!isset($this->stock)) return true;
        return $this->stock >= $quantity;
    }

    public function reduceStock(int $quantity): void
    {
        if (isset($this->stock)) {
            $this->decrement('stock', $quantity);
        }
    }

    public function getAvailabilityText(): string
    {
        if (!$this->is_available) return 'Habis';
        if (isset($this->stock) && $this->stock <= 0) return 'Pre Order';
        return 'Tersedia';
    }

    public static function categories(): array
    {
        return [
            'makanan' => 'Makanan',
            'minuman' => 'Minuman',
            'snack' => 'Snack'
        ];
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image_path' => 'storage/'.$imagePath
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Produk berhasil ditambahkan!');
    }
}