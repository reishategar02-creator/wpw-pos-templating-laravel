<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Menentukan kolom database yang diizinkan untuk diisi secara massal
    protected $fillable = ['title', 'content'];
}