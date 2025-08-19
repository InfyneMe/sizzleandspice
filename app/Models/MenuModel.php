<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory;

    protected $table = 'menu';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'image',
        'status',
        'is_popular',
        'rating',
        'ingredients',
        'dietary_info',
        'preparation_time',
        'is_available',
        'discount_price',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_available' => 'boolean',
        'rating' => 'integer',
        'preparation_time' => 'integer',
        'ingredients' => 'array', // This will automatically handle JSON conversion
    ];

    /**
     * Constants for status values
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_OUT_OF_STOCK = 'out_of_stock';
    const STATUS_LOW_STOCK = 'low_stock';

    /**
     * Constants for dietary info
     */
    const DIETARY_VEG = 'veg';
    const DIETARY_NON_VEG = 'non_veg';
    const DIETARY_VEGAN = 'vegan';
    const DIETARY_GLUTEN_FREE = 'gluten_free';
    const DIETARY_BOTH = 'both';

    /**
     * Constants for categories
     */
    const CATEGORY_INDIAN = 'Indian';
    const CATEGORY_CHINESE = 'Chinese';
    const CATEGORY_HEALTHY = 'Healthy';

    /**
     * Scope for available items
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE)
                    ->where('is_available', true);
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for popular items
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope for items with rating above threshold
     */
    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope for items with discount
     */
    public function scopeOnDiscount($query)
    {
        return $query->whereNotNull('discount_price');
    }

    /**
     * Scope for vegetarian items
     */
    public function scopeVegetarian($query)
    {
        return $query->whereIn('dietary_info', [self::DIETARY_VEG, self::DIETARY_VEGAN, self::DIETARY_BOTH]);
    }

    /**
     * Scope for non-vegetarian items
     */
    public function scopeNonVegetarian($query)
    {
        return $query->whereIn('dietary_info', [self::DIETARY_NON_VEG, self::DIETARY_BOTH]);
    }

    /**
     * Accessor for formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 2);
    }

    /**
     * Accessor for formatted discount price
     */
    public function getFormattedDiscountPriceAttribute()
    {
        return $this->discount_price ? '₹' . number_format($this->discount_price, 2) : null;
    }

    /**
     * Accessor for star rating display
     */
    public function getStarRatingAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }

    /**
     * Accessor for effective price (discount or regular)
     */
    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Accessor for discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if (!$this->discount_price || $this->discount_price >= $this->price) {
            return 0;
        }
        
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    /**
     * Check if item is vegetarian
     */
    public function isVegetarian()
    {
        return in_array($this->dietary_info, [self::DIETARY_VEG, self::DIETARY_VEGAN, self::DIETARY_BOTH]);
    }

    /**
     * Check if item is non-vegetarian
     */
    public function isNonVegetarian()
    {
        return in_array($this->dietary_info, [self::DIETARY_NON_VEG, self::DIETARY_BOTH]);
    }

    /**
     * Check if item is available for order
     */
    public function canOrder()
    {
        return $this->status === self::STATUS_AVAILABLE && $this->is_available;
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'bg-green-100 text-green-700',
            self::STATUS_OUT_OF_STOCK => 'bg-red-100 text-red-700',
            self::STATUS_LOW_STOCK => 'bg-yellow-100 text-yellow-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get category badge class for UI
     */
    public function getCategoryBadgeClassAttribute()
    {
        return match($this->category) {
            self::CATEGORY_INDIAN => 'bg-orange-100 text-orange-700',
            self::CATEGORY_CHINESE => 'bg-red-100 text-red-700',
            self::CATEGORY_HEALTHY => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get dietary info badge class for UI
     */
    public function getDietaryInfoBadgeClassAttribute()
    {
        return match($this->dietary_info) {
            self::DIETARY_VEG => 'bg-green-100 text-green-700',
            self::DIETARY_NON_VEG => 'bg-red-100 text-red-700',
            self::DIETARY_VEGAN => 'bg-green-200 text-green-800',
            self::DIETARY_GLUTEN_FREE => 'bg-yellow-100 text-yellow-700',
            self::DIETARY_BOTH => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get dietary info icon
     */
    public function getDietaryInfoIconAttribute()
    {
        return match($this->dietary_info) {
            self::DIETARY_VEG => '🟢',
            self::DIETARY_NON_VEG => '🔴',
            self::DIETARY_VEGAN => '🌱',
            self::DIETARY_GLUTEN_FREE => '🌾',
            self::DIETARY_BOTH => '🟡',
            default => '⚪',
        };
    }

    /**
     * Get dietary info display name
     */
    public function getDietaryInfoDisplayAttribute()
    {
        return match($this->dietary_info) {
            self::DIETARY_VEG => 'Vegetarian',
            self::DIETARY_NON_VEG => 'Non-Vegetarian',
            self::DIETARY_VEGAN => 'Vegan',
            self::DIETARY_GLUTEN_FREE => 'Gluten-Free',
            self::DIETARY_BOTH => 'Both',
            default => 'Not Specified',
        };
    }

    /**
     * Static method to get all categories
     */
    public static function getCategories()
    {
        return [
            self::CATEGORY_INDIAN,
            self::CATEGORY_CHINESE,
            self::CATEGORY_HEALTHY,
        ];
    }

    /**
     * Static method to get all status options
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
            self::STATUS_LOW_STOCK => 'Low Stock',
        ];
    }

    /**
     * Static method to get all dietary info options
     */
    public static function getDietaryInfoOptions()
    {
        return [
            self::DIETARY_VEG => 'Vegetarian',
            self::DIETARY_NON_VEG => 'Non-Vegetarian',
            self::DIETARY_VEGAN => 'Vegan',
            self::DIETARY_GLUTEN_FREE => 'Gluten-Free',
            self::DIETARY_BOTH => 'Both Veg & Non-Veg',
        ];
    }
}
