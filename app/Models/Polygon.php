<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Polygon extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'vertices'];



    //get user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}