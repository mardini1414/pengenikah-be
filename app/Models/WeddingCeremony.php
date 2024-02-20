<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingCeremony extends Model
{
    use HasFactory;

    protected $table = 'wedding_ceremonies';
    protected $guarded = [];
    public $timestamps = false;
}
