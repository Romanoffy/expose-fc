<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Competitions extends Model
{
    use HasFactory;

    protected $table = 'competitions';

    protected $fillable = [
        'name',
        'year',
        'category',
        'event_type',
        'description',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'year' => 'integer',
    ];

    // Event types berdasarkan kategori (fallback jika MenuCategory kosong)
    public static $eventsByCategory = [
        'internal' => ['Liga Expose', 'Festival Expose'],
        'external' => ['BPL', 'LBFF', 'SATURDAY LEAGUE', 'INDIE FOOTBALL'],
        'friendly' => ['Friendly Match', 'Trofeo', 'Fourfeo']
    ];

    /**
     * Get events by category from MenuCategory table (dynamic)
     * Fallback ke static jika kosong
     */
    public static function getEventsByCategory()
    {
        // Try to get from MenuCategory table first
        $dynamicEvents = MenuCategory::getActiveEventsByCategory();

        // If empty, use static fallback
        if (empty($dynamicEvents)) {
            return self::$eventsByCategory;
        }

        return $dynamicEvents;
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search = null)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('event_type', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    /**
     * Scope untuk ordering default
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk filter by year
     */
    public function scopeByYear($query, $year)
    {
        if ($year && $year !== 'all') {
            return $query->where('year', $year);
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
     * Scope untuk filter by event type
     */
    public function scopeByEventType($query, $eventType)
    {
        if ($eventType && $eventType !== 'all') {
            return $query->where('event_type', $eventType);
        }
        return $query;
    }

    /**
     * Scope untuk filter by status
     */
    public function scopeByStatus($query, $status)
    {
        $now = now();

        if ($status === 'upcoming') {
            return $query->where('tanggal_mulai', '>', $now);
        } elseif ($status === 'ongoing') {
            return $query->where('tanggal_mulai', '<=', $now)
                ->where('tanggal_selesai', '>=', $now);
        } elseif ($status === 'finished') {
            return $query->where('tanggal_selesai', '<', $now);
        }

        return $query;
    }

    /**
     * Get category color
     */
    public function getCategoryColorAttribute()
    {
        $colors = [
            'internal' => '#007bff',
            'external' => '#f59e0b',
            'friendly' => '#10b981',
        ];

        return $colors[$this->category] ?? '#6b7280';
    }

    /**
     * Get category badge color (Bootstrap classes)
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
     * Get formatted category name
     */
    public function getCategoryNameAttribute()
    {
        $names = [
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly Match',
        ];

        return $names[$this->category] ?? '-';
    }

    /**
     * Get status of competition
     */
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->tanggal_mulai);
        $end = Carbon::parse($this->tanggal_selesai);

        if ($now->lt($start)) {
            return 'upcoming';
        } elseif ($now->between($start, $end)) {
            return 'ongoing';
        } else {
            return 'finished';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'upcoming' => 'Akan Datang',
            'ongoing' => 'Berlangsung',
            'finished' => 'Selesai',
        ];

        return $statuses[$this->status] ?? '-';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'upcoming' => 'bg-info',
            'ongoing' => 'bg-success',
            'finished' => 'bg-secondary',
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }

    /**
     * Get duration in days
     * FIXED: Ensure Carbon instance before calling diffInDays
     */
    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->tanggal_mulai);
        $end = Carbon::parse($this->tanggal_selesai);

        return $start->diffInDays($end) + 1;
    }

    /**
     * Validate event type untuk kategori
     */
    public static function isValidEventForCategory($category, $eventType)
    {
        $events = self::getEventsByCategory();

        return isset($events[$category]) && in_array($eventType, $events[$category]);
    }

    /**
     * Relationship: Competition has many Matches
     */
    public function matches(): HasMany
    {
        return $this->hasMany(Matches::class, 'competition_id');
    }

    /**
     * Relationship: Competition belongs to many Teams
     * Through TeamsCompetitions pivot table
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Teams::class,
            'teams_competitions',
            'competition_id',
            'team_id'
        )->withTimestamps();
    }

    /**
     * Relationship: Competition has many TeamsCompetitions records
     */
    public function teamCompetitions(): HasMany
    {
        return $this->hasMany(TeamsCompetitions::class, 'competition_id');
    }

    /**
     * Get total matches count
     */
    public function getTotalMatchesAttribute()
    {
        return $this->matches()->count();
    }

    /**
     * Get completed matches count
     */
    public function getCompletedMatchesAttribute()
    {
        return $this->matches()->where('status', Matches::STATUS_FINISHED)->count();
    }

    /**
     * Get upcoming matches count
     */
    public function getUpcomingMatchesAttribute()
    {
        return $this->matches()->where('status', Matches::STATUS_SCHEDULED)->count();
    }

    /**
     * Get live matches count
     */
    public function getLiveMatchesAttribute()
    {
        return $this->matches()->where('status', Matches::STATUS_LIVE)->count();
    }

    /**
     * Get total teams in competition
     */
    public function getTotalTeamsAttribute()
    {
        return $this->teamCompetitions()->count();
    }

    /**
     * Get total goals in competition
     */
    public function getTotalGoalsAttribute()
    {
        return $this->matches()
            ->where('status', Matches::STATUS_FINISHED)
            ->sum(\DB::raw('score_team1 + score_team2'));
    }

    /**
     * Check if competition is active (ongoing)
     */
    public function isActive()
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if competition is finished
     */
    public function isFinished()
    {
        return $this->status === 'finished';
    }

    /**
     * Check if competition is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming';
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        $start = Carbon::parse($this->tanggal_mulai)->format('d M Y');
        $end = Carbon::parse($this->tanggal_selesai)->format('d M Y');

        return "{$start} - {$end}";
    }

    /**
     * Get competition progress percentage
     */
    public function getProgressAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->tanggal_mulai);
        $end = Carbon::parse($this->tanggal_selesai);

        if ($now->lt($start)) {
            return 0; // Belum dimulai
        } elseif ($now->gt($end)) {
            return 100; // Sudah selesai
        } else {
            // Calculate progress
            $totalDays = $start->diffInDays($end);
            $elapsedDays = $start->diffInDays($now);
            return round(($elapsedDays / $totalDays) * 100);
        }
    }

    /**
     * Scope: Only active competitions
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('tanggal_mulai', '<=', $now)
            ->where('tanggal_selesai', '>=', $now);
    }

    /**
     * Scope: Only upcoming competitions
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_mulai', '>', Carbon::now());
    }

    /**
     * Scope: Only finished competitions
     */
    public function scopeFinished($query)
    {
        return $query->where('tanggal_selesai', '<', Carbon::now());
    }

    /**
     * Scope: Competitions with matches
     */
    public function scopeWithMatches($query)
    {
        return $query->has('matches');
    }

    /**
     * Scope: Competitions by current year
     */
    public function scopeCurrentYear($query)
    {
        return $query->where('year', Carbon::now()->year);
    }
}