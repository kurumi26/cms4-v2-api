<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $menus = Menu::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|array',
            'is_active' => 'boolean',
        ]);

        $menu = Menu::create($validated);

        return response()->json([
            'message' => 'Menu created successfully',
            'data' => $menu
        ], 201);
    }

    public function show(Menu $menu)
    {
        return response()->json([
            'data' => $menu
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|array',
            'is_active' => 'boolean',
        ]);

        $menu->update($validated);

        return response()->json([
            'message' => 'Menu updated successfully',
            'data' => $menu
        ]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Menu deleted'
        ]);
    }

    public function setActive(Menu $menu)
    {
        DB::transaction(function () use ($menu) {
            Menu::where('id', '!=', $menu->id)->update([
                'is_active' => false,
            ]);

            $menu->update([
                'is_active' => true,
            ]);
        });

        return response()->json([
            'message' => 'Menu activated successfully',
            'data' => $menu
        ]);
    }
}
