<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model {
    protected $fillable = ['title','description','event_date','end_date','venue','address','city','organiser','category','image','contact_email','is_free','ticket_price','ticket_link','created_by','is_approved'];
    protected $casts    = ['event_date'=>'datetime','end_date'=>'datetime','is_free'=>'boolean','is_approved'=>'boolean'];
    public function creator() { return $this->belongsTo(User::class,'created_by'); }
    public function scopeApproved($q) { return $q->where('is_approved',true); }
    public function scopeUpcoming($q) { return $q->where('event_date','>=',now()); }
}
