<?php

namespace App\Jobs;

use App\Models\AiMatchingLog;
use App\Models\FoundItem;
use App\Models\LostReport;
use App\Services\AiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MatchLostReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(public LostReport $lostReport)
    {
    }

    public function handle(AiService $aiService): void
    {
        $lostReport = $this->lostReport->loadMissing('category');
        $lostDescription = "Nama Barang: {$lostReport->item_name}, Kategori: {$lostReport->category?->name}, Warna: {$lostReport->color}, Merek: {$lostReport->brand}, Lokasi Hilang: {$lostReport->location_lost}, Ciri Khusus: {$lostReport->distinctive_features}";

        FoundItem::with('category')->where('status', 'active')->chunkById(25, function ($foundItems) use ($aiService, $lostReport, $lostDescription): void {
            foreach ($foundItems as $foundItem) {
                $foundDescription = "Nama Barang: {$foundItem->title}, Kategori: {$foundItem->category?->name}, Warna: {$foundItem->color}, Merek: {$foundItem->brand}, Lokasi Temu: {$foundItem->location_found}, Deskripsi: {$foundItem->description}";
                $matchResult = $aiService->matchItems($lostDescription, $foundDescription);

                if ($matchResult) {
                    AiMatchingLog::updateOrCreate(
                        ['lost_report_id' => $lostReport->id, 'found_item_id' => $foundItem->id],
                        [
                            'score' => $matchResult['score'],
                            'reason' => $matchResult['reason'],
                            'color_match' => $matchResult['color_match'],
                            'brand_match' => $matchResult['brand_match'],
                            'location_match' => $matchResult['location_match'],
                            'time_match' => $matchResult['time_match'],
                        ]
                    );
                }
            }
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Lost report AI matching failed.', [
            'lost_report_id' => $this->lostReport->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
