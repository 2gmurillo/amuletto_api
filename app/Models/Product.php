<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'photo',
        'price',
        'description',
        'stock',
        'disabled_at',
        'user_id',
        'category_id',
    ];

    /**
     * The attributes that are date type.
     *
     * @var array
     */
    protected $dates = [
        'disabled_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'price' => 'integer',
        'category_id' => 'integer',
    ];

    /**
     * Get the route key for the product.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user that owns the cart.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fields()
    {
        return [
            'name' => $this->name,
            'photo' => $this->photo,
            'price' => (int)$this->price,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'stock' => $this->stock,
        ];
    }

    public function scopeName(Builder $query, $value)
    {
        $query->where('name', 'LIKE', "%{$value}%");
    }

    public function scopeDescription(Builder $query, $value)
    {
        $query->where('description', 'LIKE', "%{$value}%");
    }

    public function scopeYear(Builder $query, $value)
    {
        $query->whereYear('created_at', $value);
    }

    public function scopeMonth(Builder $query, $value)
    {
        $query->whereMonth('created_at', $value);
    }

    public function scopeSearch(Builder $query, $values)
    {
        foreach (Str::of($values)->explode(' ') as $value) {
            $query->orWhere('name', 'LIKE', "%{$value}%")
                ->orWhere('description', 'LIKE', "%{$value}%");
        }
    }
}
