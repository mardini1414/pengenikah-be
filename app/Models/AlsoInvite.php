<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlsoInvite extends Model
{
    use HasFactory;

    protected $table = 'also_invites';
    protected $guarded = [];
    public $timestamps = false;
}
