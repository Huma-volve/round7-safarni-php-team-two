<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles, HasPermissions;
    protected $fillable = ['name','email','password','is_superadmin','is_admin','image','is_active'];

     protected $hidden = [
                            'created_at',
                            'updated_at',
                            'password',
                        ];



}
