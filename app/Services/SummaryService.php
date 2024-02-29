<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\Song;
use App\Models\Theme;

class SummaryService
{
    public function getTotal()
    {
        $data = [
            'total_invitation' => Invitation::count(),
            'total_song' => Song::count(),
            'total_theme' => Theme::count()
        ];
        return $data;
    }
}