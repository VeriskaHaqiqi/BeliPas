<?php

namespace App\Http\Controllers\User;

use App\Data\UserDashboardDemoData;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

final class PredictionExplanationController extends Controller
{
    public function __invoke(?string $code = null): View
    {
        $code ??= 'cabai-rawit-merah';
        $commodity = UserDashboardDemoData::detail($code);

        abort_unless($commodity, 404);

        return view('user.prediction-explanation', [
            'profile' => UserDashboardDemoData::dashboard()['profile'],
            'activeNav' => 'help',
            'detailCode' => $code,
            'commodity' => $commodity,
            'commodities' => UserDashboardDemoData::commodities(),
            'evaluationMetrics' => [
                ['icon' => 'prediction-metric-error.svg', 'tag' => 'Evaluasi model', 'title' => 'Rata-rata Selisih Harga', 'value' => null, 'suffix' => '', 'description' => 'Perbedaan rata-rata antara estimasi dan harga pembanding pada data evaluasi.'],
                ['icon' => 'prediction-metric-trend.svg', 'tag' => 'Evaluasi model', 'title' => 'Ketepatan Arah Tren', 'value' => null, 'suffix' => '', 'description' => 'Seberapa sering arah naik, stabil, atau turun diperkirakan dengan tepat.'],
                ['icon' => 'prediction-metric-efficiency.svg', 'tag' => 'Evaluasi model', 'title' => 'Perbandingan Metode', 'value' => null, 'suffix' => '', 'description' => 'Perbandingan dengan metode acuan menunggu hasil evaluasi yang disepakati.'],
            ],
            'comparisonMethods' => [
                ['name' => 'Tebakan / intuisi', 'description' => 'Nilai pembanding belum tersedia.'],
                ['name' => 'Rata-rata harga sebelumnya', 'description' => 'Nilai pembanding belum tersedia.'],
                ['name' => 'BeliPas', 'description' => 'Evaluasi belum tersedia dari tim model.'],
            ],
            'evaluationPeriod' => null,
        ]);
    }
}
