<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role','avatar','bio','is_active'];
    protected $hidden   = ['password','remember_token'];
    protected $casts    = ['email_verified_at'=>'datetime','password'=>'hashed','is_active'=>'boolean'];

    public function articles() { return $this->hasMany(Article::class,'author_id'); }
    public function events()   { return $this->hasMany(Event::class,'created_by'); }

    public function isAdmin():       bool { return $this->role === 'admin'; }
    public function isEditor():      bool { return in_array($this->role,['admin','editor']); }
    public function isContributor(): bool { return in_array($this->role,['admin','editor','contributor']); }
}
