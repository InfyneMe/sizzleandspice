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
        'quantity',
        'course_type',
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
        'ingredients' => 'array',
        'quantity' => 'string',
        'course_type' => 'string',
    ];

    /**
     * Constants for status values
     */
    const STATUS_AVAILABLE   = 'available';
    const STATUS_OUT_OF_STOCK = 'out_of_stock';
    const STATUS_LOW_STOCK    = 'low_stock';

    /**
     * Constants for dietary info
     */
    const DIETARY_VEG         = 'veg';
    const DIETARY_NON_VEG     = 'non_veg';
    const DIETARY_VEGAN       = 'vegan';
    const DIETARY_GLUTEN_FREE = 'gluten_free';
    const DIETARY_BOTH        = 'both';

    /**
     * Constants for categories
     */
    const CATEGORY_INDIAN  = 'Indian';
    const CATEGORY_CHINESE = 'Chinese';
    const CATEGORY_HEALTHY = 'Healthy';

    /**
     * Constants for quantity
     */
    const QUANTITY_HALF = 'half';
    const QUANTITY_FULL = 'full';

    /**
     * Constants for course types
     */
    const COURSE_STARTER     = 'starter';
    const COURSE_MAIN_COURSE = 'main_course';
    const COURSE_DESSERT     = 'dessert';
    const COURSE_DRINK       = 'drink';

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
     * New scopes: quantity and course_type
     */
    public function scopeQuantity($query, string $quantity)
    {
        return $query->where('quantity', $quantity);
    }

    public function scopeHalf($query)
    {
        return $query->where('quantity', self::QUANTITY_HALF);
    }

    public function scopeFull($query)
    {
        return $query->where('quantity', self::QUANTITY_FULL);
    }

    public function scopeCourse($query, string $course)
    {
        return $query->where('course_type', $course);
    }

    public function scopeStarters($query)
    {
        return $query->where('course_type', self::COURSE_STARTER);
    }

    public function scopeMains($query)
    {
        return $query->where('course_type', self::COURSE_MAIN_COURSE);
    }

    public function scopeDesserts($query)
    {
        return $query->where('course_type', self::COURSE_DESSERT);
    }

    public function scopeDrinks($query)
    {
        return $query->where('course_type', self::COURSE_DRINK);
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
        return str_repeat('⭐', (int) $this->rating);
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

        return (int) round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    /**
     * Check if item is vegetarian
     */
    public function isVegetarian()
    {
        return in_array($this->dietary_info, [self::DIETARY_VEG, self::DIETARY_VEGAN, self::DIETARY_BOTH], true);
    }

    /**
     * Check if item is non-vegetarian
     */
    public function isNonVegetarian()
    {
        return in_array($this->dietary_info, [self::DIETARY_NON_VEG, self::DIETARY_BOTH], true);
    }

    /**
     * Check if item is available for order
     */
    public function canOrder()
    {
        return $this->status === self::STATUS_AVAILABLE && (bool) $this->is_available;
    }

    /**
     * UI helpers
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE   => 'bg-green-100 text-green-700',
            self::STATUS_OUT_OF_STOCK => 'bg-red-100 text-red-700',
            self::STATUS_LOW_STOCK    => 'bg-yellow-100 text-yellow-700',
            default                   => 'bg-gray-100 text-gray-700',
        };
    }

    public function getCategoryBadgeClassAttribute()
    {
        return match ($this->category) {
            self::CATEGORY_INDIAN  => 'bg-orange-100 text-orange-700',
            self::CATEGORY_CHINESE => 'bg-red-100 text-red-700',
            self::CATEGORY_HEALTHY => 'bg-green-100 text-green-700',
            default                => 'bg-gray-100 text-gray-700',
        };
    }

    public function getDietaryInfoBadgeClassAttribute()
    {
        return match ($this->dietary_info) {
            self::DIETARY_VEG         => 'bg-green-100 text-green-700',
            self::DIETARY_NON_VEG     => 'bg-red-100 text-red-700',
            self::DIETARY_VEGAN       => 'bg-green-200 text-green-800',
            self::DIETARY_GLUTEN_FREE => 'bg-yellow-100 text-yellow-700',
            self::DIETARY_BOTH        => 'bg-blue-100 text-blue-700',
            default                   => 'bg-gray-100 text-gray-700',
        };
    }

    public function getDietaryInfoIconAttribute()
    {
        return match ($this->dietary_info) {
            self::DIETARY_VEG         => '🟢',
            self::DIETARY_NON_VEG     => '🔴',
            self::DIETARY_VEGAN       => '🌱',
            self::DIETARY_GLUTEN_FREE => '🌾',
            self::DIETARY_BOTH        => '🟡',
            default                   => '⚪',
        };
    }

    public function getDietaryInfoDisplayAttribute()
    {
        return match ($this->dietary_info) {
            self::DIETARY_VEG         => 'Vegetarian',
            self::DIETARY_NON_VEG     => 'Non-Veg',
            self::DIETARY_VEGAN       => 'Vegan',
            self::DIETARY_GLUTEN_FREE => 'Gluten-Free',
            self::DIETARY_BOTH        => 'Both',
            default                   => 'Not Specified',
        };
    }

    /**
     * New display helpers
     */
    public function getQuantityDisplayAttribute(): string
    {
        return match ($this->quantity) {
            self::QUANTITY_HALF => 'Half',
            self::QUANTITY_FULL => 'Full',
            default             => ucfirst((string) $this->quantity),
        };
    }

    public function getCourseTypeDisplayAttribute(): string
    {
        return match ($this->course_type) {
            self::COURSE_STARTER     => 'Starter',
            self::COURSE_MAIN_COURSE => 'MainCourse',
            self::COURSE_DESSERT     => 'Dessert',
            self::COURSE_DRINK       => 'Drink',
            default                  => ucfirst((string) $this->course_type),
        };
    }

    /**
     * Static option providers (useful for forms/filters)
     */
    public static function getQuantityOptions(): array
    {
        return [
            self::QUANTITY_HALF => 'Half',
            self::QUANTITY_FULL => 'Full',
        ];
    }

    public static function getCourseTypeOptions(): array
    {
        return [
            self::COURSE_STARTER     => 'Starter',
            self::COURSE_MAIN_COURSE => 'Main Course',
            self::COURSE_DESSERT     => 'Dessert',
            self::COURSE_DRINK       => 'Drink',
        ];
    }

    /**
     * Existing static methods
     */
    public static function getCategories()
    {
        return [
            self::CATEGORY_INDIAN,
            self::CATEGORY_CHINESE,
            self::CATEGORY_HEALTHY,
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_AVAILABLE    => 'Available',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
            self::STATUS_LOW_STOCK    => 'Low Stock',
        ];
    }

    public static function getDietaryInfoOptions()
    {
        return [
            self::DIETARY_VEG         => 'Vegetarian',
            self::DIETARY_NON_VEG     => 'Non-Vegetarian',
            self::DIETARY_VEGAN       => 'Vegan',
            self::DIETARY_GLUTEN_FREE => 'Gluten-Free',
            self::DIETARY_BOTH        => 'Both Veg & Non-Veg',
        ];
    }
}
