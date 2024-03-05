<?php

namespace App\Models\Invitation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';
    protected $guarded = [];
    public $timestamps = false;
}
