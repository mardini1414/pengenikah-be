<?php

namespace App\Services\Summary;

use App\Models\Invitation\Invitation;
use App\Models\Invitation\Song;
use App\Models\Invitation\Theme;

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