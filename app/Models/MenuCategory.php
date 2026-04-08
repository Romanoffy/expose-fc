<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    protected $table = 'menu_categories';

    protected $fillable = [
        'category',
        'event_name',
        'description',
    ];

    // Category labels
    public static $categoryLabels = [
        'internal' => 'Internal',
        'external' => 'External',
        'friendly' => 'Friendly Match',
    ];

    // Category colors
    public static $categoryColors = [
        'internal' => '#007bff',
        'external' => '#f59e0b',
        'friendly' => '#10b981',
    ];

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search = null)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('event_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Scope untuk filter by category
     */
    public function scopeByCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Scope untuk ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('category', 'asc')->orderBy('event_name', 'asc');
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute()
    {
        return self::$categoryLabels[$this->category] ?? $this->category;
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        return self::$categoryColors[$this->category] ?? '#6b7280';
    }

    /**
     * Get category badge (Bootstrap class)
     */
    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'internal' => 'primary',
            'external' => 'warning',
            'friendly' => 'success',
        ];
        return $badges[$this->category] ?? 'secondary';
    }

    /**
     * Get all active events grouped by category
     * Hasil: ['internal' => ['Liga Expose', 'Festival Expose'], 'external' => [...], ...]
     */
    public static function getActiveEventsByCategory()
    {
        return self::ordered()
            ->get()
            ->groupBy('category')
            ->map(function ($items) {
                return $items->pluck('event_name')->toArray();
            })
            ->toArray();
    }

    /**
     * Get events by specific category
     */
    public static function getEventsByCategory($category = null)
    {
        if (!$category) {
            return self::getActiveEventsByCategory();
        }

        return self::where('category', $category)
            ->ordered()
            ->pluck('event_name')
            ->toArray();
    }

    /**
     * Get all events as flat array
     */
    public static function getAllEvents()
    {
        return self::ordered()
            ->pluck('event_name')
            ->unique()
            ->toArray();
    }

    /**
     * Check if event exists for category
     */
    public static function eventExistsForCategory($category, $eventName)
    {
        return self::where('category', $category)
            ->where('event_name', $eventName)
            ->exists();
    }

    /**
     * Get total events count by category
     */
    public static function getCountByCategory($category)
    {
        return self::where('category', $category)->count();
    }

    /**
     * Get summary of all categories
     */
    public static function getCategorySummary()
    {
        return [
            'internal' => self::getCountByCategory('internal'),
            'external' => self::getCountByCategory('external'),
            'friendly' => self::getCountByCategory('friendly'),
            'total' => self::count()
        ];
    }
}