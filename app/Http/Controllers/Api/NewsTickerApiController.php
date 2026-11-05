<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsTicker;
use Illuminate\Http\JsonResponse;

class NewsTickerApiController extends Controller
{
    /**
     * Public endpoint for React frontend ticker: GET /api/news-ticker
     */
    public function getTickers(): JsonResponse
    {
        $tickers = NewsTicker::query()
            ->orderBy('id')
            ->get()
            ->unique('title')
            ->values();

        return response()->json([
            'success' => true,
            'count' => $tickers->count(),
            'data' => $tickers->map(fn (NewsTicker $ticker) => $this->tickerData($ticker)),
        ], 200);
    }

    /**
     * Return the public ticker fields without exposing legacy/internal columns.
     */
    private function tickerData(NewsTicker $ticker): array
    {
        return [
            'id' => $ticker->id,
            'title' => $ticker->title,
            'pdf_url' => $ticker->pdf_url,
        ];
    }
}
