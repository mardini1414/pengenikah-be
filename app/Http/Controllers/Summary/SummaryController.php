<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use App\Services\Summary\SummaryService;

class SummaryController extends Controller
{

    private $dashboardService;

    public function __construct(SummaryService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getTotal();
        return response()->json(['data' => $data]);
    }
}
