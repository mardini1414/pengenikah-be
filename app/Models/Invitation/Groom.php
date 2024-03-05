<?php

namespace App\Models\Invitation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groom extends Model
{
    use HasFactory;

    protected $table = 'grooms';
    protected $guarded = [];
    public $timestamps = false;
}
