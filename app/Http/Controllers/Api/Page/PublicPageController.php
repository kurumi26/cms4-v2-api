<?php

namespace App\Http\Controllers\Api\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PublicPageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'public')
            ->firstOrFail();

        return response()->json([
            'id'      => $page->id,
            'title'   => $page->name,
            'slug'    => $page->slug,
            'content' => $page->contents,
            'meta'    => [
                'title'       => $page->meta_title,
                'description' => $page->meta_description,
                'keywords'    => $page->meta_keyword,
            ],
        ]);
    }
}
