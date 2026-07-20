<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pharmacien extends Model
{
    use HasFactory;

    protected $fillable = [
    'Name',
    'First_name',
    'phone_number',
    'gender',
    'age',
    'user_id'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

