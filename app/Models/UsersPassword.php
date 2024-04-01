<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'website',
        'password',
        'account_name',
        'users_id',
        // Add other fields that you want to allow mass assignment here
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
