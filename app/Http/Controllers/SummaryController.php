<?php

namespace App\Http\Controllers;

use App\Services\SummaryService;

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
