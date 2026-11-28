<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MarketController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $scope = $request->query('scope', 'all');

        if (!in_array($status, ['all', 'active', 'inactive'], true)) {
            $status = 'all';
        }

        if (!in_array($scope, ['all', 'market', 'city', 'province', 'national'], true)) {
            $scope = 'all';
        }

        $query = Market::query()->withCount('priceRecords');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'ilike', "%{$search}%")
                  ->orWhere('name', 'ilike', "%{$search}%")
                  ->orWhere('city', 'ilike', "%{$search}%")
                  ->orWhere('province', 'ilike', "%{$search}%");
            });
        }

        if ($status !== 'all') {
            $query->where('is_active', $status === 'active');
        }

        if ($scope !== 'all') {
            $query->where('scope_type', $scope);
        }

        return view('admin.markets.index', [
            'markets' => $query->orderBy('name')
                ->paginate(10)->withQueryString(),
            'totalMarkets' => Market::count(),
            'activeMarkets' => Market::where('is_active', true)->count(),
            'inactiveMarkets' => Market::where('is_active', false)->count(),
            'search' => $search,
            'status' => $status,
            'scope' => $scope,
        ]);
    }

    public function create(): View
    {
        return view('admin.markets.form', [
            'market' => new Market(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Market::create($this->validatedData($request));

        return redirect()->route('admin.markets.index')
            ->with('success', 'Pasar/wilayah berhasil ditambahkan.');
    }

    public function edit(Market $market): View
    {
        return view('admin.markets.form', compact('market'));
    }

    public function update(Request $request, Market $market): RedirectResponse
    {
        $market->update($this->validatedData($request, $market));

        return redirect()->route('admin.markets.index')
            ->with('success', 'Pasar/wilayah berhasil diperbarui.');
    }

    public function toggleStatus(Market $market): RedirectResponse
    {
        $market->update(['is_active' => !$market->is_active]);

        return redirect()->route('admin.markets.index')
            ->with('success', 'Status pasar/wilayah berhasil diubah.');
    }

    private function validatedData(
        Request $request,
        ?Market $market = null
    ): array {
        return $request->validate([
            'code' => [
                'required', 'string', 'max:50',
                'regex:/^[A-Z0-9_]+$/',
                Rule::unique('markets', 'code')->ignore($market?->id),
            ],
            'name' => ['required', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'scope_type' => [
                'required',
                Rule::in(['market', 'city', 'province', 'national']),
            ],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
