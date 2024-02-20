<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bride extends Model
{
    use HasFactory;

    protected $table = 'brides';
    protected $guarded = [];
    public $timestamps = false;

    public function invitation()
    {
        return $this->hasOne(Invitation::class);
    }
}
