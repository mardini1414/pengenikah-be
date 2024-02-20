<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';
    protected $guarded = [];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function bride()
    {
        return $this->hasOne(Bride::class);
    }

    public function groom()
    {
        return $this->hasOne(Groom::class);
    }

    public function weddingCeremony()
    {
        return $this->hasOne(WeddingCeremony::class);
    }

    public function weddingReception()
    {
        return $this->hasOne(WeddingReception::class);
    }

    public function alsoInvites()
    {
        return $this->hasMany(AlsoInvite::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
