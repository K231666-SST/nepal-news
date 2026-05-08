<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','summary','content','category','featured_image','author_id','status','is_featured','is_breaking','views','published_at','language'];
    protected $casts    = ['published_at'=>'datetime','is_featured'=>'boolean','is_breaking'=>'boolean'];

    protected static function booted(): void {
        static::creating(function($a) { $a->slug = static::generateSlug($a->title); });
        static::updating(function($a) {
            if ($a->isDirty('title')) $a->slug = static::generateSlug($a->title);
            if ($a->isDirty('status') && $a->status === 'published' && !$a->published_at) $a->published_at = now();
        });
    }

    public static function generateSlug(string $title): string {
        $slug  = Str::slug($title);
        $count = static::where('slug','LIKE',"{$slug}%")->count();
        return $count > 0 ? "{$slug}-".time() : $slug;
    }

    public function author()   { return $this->belongsTo(User::class,'author_id'); }
    public function tags()     { return $this->belongsToMany(Tag::class); }
    public function comments() { return $this->hasMany(Comment::class); }

    public function scopePublished($q) { return $q->where('status','published'); }
    public function scopeFeatured($q)  { return $q->where('is_featured',true)->published(); }
    public function scopeBreaking($q)  { return $q->where('is_breaking',true)->published(); }
    public function scopeByCategory($q,string $cat) { return $q->where('category',$cat); }
    public function scopeSearch($q,string $t) {
        return $q->where(fn($s) => $s->where('title','LIKE',"%{$t}%")->orWhere('summary','LIKE',"%{$t}%")->orWhere('content','LIKE',"%{$t}%"));
    }

    public function incrementViews(): void { $this->increment('views'); }
    public function getReadingTimeAttribute(): int { return max(1,(int)round(str_word_count(strip_tags($this->content))/200)); }
    public function getTagListAttribute(): string  { return $this->tags->pluck('name')->implode(', '); }
}
