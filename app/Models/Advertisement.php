<?php
// app/Models/Advertisement.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'title','position','type','image_url','link_url',
        'ad_code','alt_text','is_active','starts_at','ends_at','created_by',
    ];
    protected $casts = [
        'is_active'  => 'boolean',
        'starts_at'  => 'date',
        'ends_at'    => 'date',
    ];

    public function creator() { return $this->belongsTo(User::class,'created_by'); }

    // Get active ad for a position
    public static function getFor(string $position): ?self {
        return static::where('position', $position)
            ->where('is_active', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at','<=',now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at','>=',now()))
            ->inRandomOrder()
            ->first();
    }

    public function incrementImpressions(): void { $this->increment('impressions'); }
    public function incrementClicks(): void      { $this->increment('clicks'); }

    public function getCtrAttribute(): string {
        if (!$this->impressions) return '0%';
        return round(($this->clicks / $this->impressions) * 100, 1) . '%';
    }
}
