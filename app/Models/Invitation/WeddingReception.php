<?php

namespace App\Models\Invitation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeddingReception extends Model
{
    use HasFactory;

    protected $table = 'wedding_receptions';
    protected $guarded = [];
    public $timestamps = false;
}
