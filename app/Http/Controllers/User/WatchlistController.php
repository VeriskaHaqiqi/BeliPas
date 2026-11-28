<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateWatchlistRequest;
use App\Services\UserWatchlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class WatchlistController extends Controller
{
    public function update(UpdateWatchlistRequest $request): JsonResponse|RedirectResponse
    {
        if (! UserWatchlistService::isBackedByDatabase()) {
            $message = 'Tabel komoditas pantauan belum tersedia pada database aktif.';

            return $request->expectsJson()
                ? response()->json(['message' => $message], 503)
                : back()->with('status', $message);
        }

        $trackedCodes = UserWatchlistService::syncForUser(
            $request->user(),
            $request->validated('commodity_codes'),
        );

        $message = 'Daftar komoditas pantauan berhasil diperbarui.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'tracked_codes' => $trackedCodes,
            ]);
        }

        return back()->with('status', $message);
    }
}
