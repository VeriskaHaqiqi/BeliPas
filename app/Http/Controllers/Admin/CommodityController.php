<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommodityController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');

        if (!in_array($status, ['all', 'active', 'inactive'], true)) {
            $status = 'all';
        }

        $query = Commodity::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                  ->orWhere('code', 'ilike', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        return view('admin.commodities.index', [
            'commodities' => $query
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString(),

            'totalCommodities' => Commodity::count(),

            'activeCommodities' => Commodity::where(
                'is_active', true
            )->count(),

            'inactiveCommodities' => Commodity::where(
                'is_active', false
            )->count(),

            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.commodities.form', [
            'commodity' => new Commodity(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => [
                'required', 'string', 'max:50',
                'regex:/^[A-Z0-9_]+$/',
                Rule::unique('commodities', 'code'),
            ],
            'name' => ['required', 'string', 'max:150'],
            'unit' => ['required', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
        ]);

        Commodity::create($validated);

        return redirect()
            ->route('admin.commodities.index')
            ->with('success', 'Komoditas berhasil ditambahkan.');
    }

    public function edit(Commodity $commodity): View
    {
        return view('admin.commodities.form', [
            'commodity' => $commodity,
        ]);
    }

    public function update(
        Request $request,
        Commodity $commodity
    ): RedirectResponse {
        $validated = $request->validate([
            'code' => [
                'required', 'string', 'max:50',
                'regex:/^[A-Z0-9_]+$/',
                Rule::unique('commodities', 'code')
                    ->ignore($commodity->id),
            ],
            'name' => ['required', 'string', 'max:150'],
            'unit' => ['required', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
        ]);

        $commodity->update($validated);

        return redirect()
            ->route('admin.commodities.index')
            ->with('success', 'Komoditas berhasil diperbarui.');
    }

    public function toggleStatus(
        Commodity $commodity
    ): RedirectResponse {
        $commodity->update([
            'is_active' => !$commodity->is_active,
        ]);

        return redirect()
            ->route('admin.commodities.index')
            ->with('success', 'Status komoditas berhasil diubah.');
    }
}
