<?php

namespace App\Models;

use App\Observers\UserStampObserver;
use App\Traits\CanGetTableNameStatically;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserStamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, CanGetTableNameStatically, UserStamp;
    use SoftDeletes;

    const user_type = [
        "1" => 'Admin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'refresh_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function createdByUser()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
    public function updatedByUser()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
    public function deletedByUser()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }
    public function restoreByUser()
    {
        return $this->belongsTo('App\Models\User', 'restored_by');
    }
}
