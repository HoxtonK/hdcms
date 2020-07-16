<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Site;
use App\Models\Traits\Favour;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Edu\Entities\Sign;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Favour;

    protected $fillable = ['name', 'email', 'mobile', 'real_name', 'home', 'avatar', 'qq', 'github', 'wakatime', 'group_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->id == 1;
    }

    public function getIconAttribute()
    {
        return $this->avatar ?? url('/images/avatar.jpg');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'admin_site')->withTimestamps();
    }

    public function masterSites()
    {
        return $this->hasMany(Site::class, 'user_id');
    }

    public function getallSitesAttribute()
    {
        return $this->sites->merge($this->masterSites);
    }

    public function scopeSearch($query, $name)
    {
        if (empty($name)) return $query;

        $name = "%{$name}%";
        return $query->orWhere('name', 'like', $name)->orWhere('id', 'like', $name)->orWhere('email', 'like', $name)->orWhere('mobile', 'like', $name);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function fans()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function getIsFollowerAttribute()
    {
        return $this->followers()->where('users.id', Auth::id())->exists();
    }

    public function getIsFansAttribute()
    {
        return $this->fans()->where('users.id', Auth::id())->exists();
    }

    public function signs()
    {
        return $this->hasMany(Sign::class);
    }

    public function todaySign()
    {
        return $this->signs()->whereDate('created_at', now())->first();
    }
}