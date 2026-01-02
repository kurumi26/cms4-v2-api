<?php

namespace App\Http\Controllers\Api\Page;

use Str;
use App\Models\Menu;
use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PublicPageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::with([
                'album.banners' => function ($q) {
                    $q->orderBy('order');
                }
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'id'        => $page->id,
            'title'     => $page->name,
            'label'     => $page->label,
            'slug'      => $page->slug,
            'content'   => $page->contents,
            'page_type' => $page->page_type,
            'template'  => $page->template,
            'image_url' => $page->image_url,

            'meta' => [
                'title'       => $page->meta_title,
                'description' => $page->meta_description,
                'keywords'    => $page->meta_keyword,
            ],
            'album' => $page->album ? [
                'id'             => $page->album->id,
                'name'           => $page->album->name,
                'type'           => $page->album->type,
                'banner_type'    => $page->album->banner_type,
                'transition'     => $page->album->transition,
                'transition_in'  => $page->album->transition_in,
                'transition_out' => $page->album->transition_out,
                'banners' => $page->album->banners->map(function ($banner) {
                    return [
                        'id'          => $banner->id,
                        'title'       => $banner->title,
                        'description' => $banner->description,
                        'alt'         => $banner->alt,
                        'image_url' => url(Storage::url($banner->image_path)),
                        'button_text' => $banner->button_text,
                        'url'         => $banner->url,
                        'order'       => $banner->order,
                    ];
                })->values(),
            ] : null,
        ]);
    }

    public function active()
    {
        $menu = Menu::where('is_active', true)->first();

        if (!$menu) {
            return response()->json([
                'data' => null,
            ]);
        }

        return response()->json([
            'data' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'items' => $this->normalizeItems($menu->items),
            ],
        ]);
    }

    private function normalizeItems(array $items)
    {
        return collect($items)->map(function ($item) {
            return [
                'id' => $item['id'] ?? null,
                'title' => $item['label'],
                'slug' => Str::slug($item['label']),
                'children' => $this->normalizeItems($item['children'] ?? []),
            ];
        })->values();
    }

    public function footer()
    {
        $footer = Page::where('slug', 'footer')
            ->where('status', 'published')
            ->first();

        if (!$footer) {
            return response()->json([
                'message' => 'Footer not found'
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $footer->id,
                'slug' => $footer->slug,
                'contents' => $footer->contents,
            ]
        ]);
    }
    
}
