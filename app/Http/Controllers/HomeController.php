<?php

namespace App\Http\Controllers;

use App\Models\AdSlot;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Province;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'listings' => Listing::visible()
                ->with(['mainPhoto', 'province'])
                ->latest('published_at')
                ->limit(20)
                ->get(),
            'provinces' => Province::orderBy('sort_order')->get(),
            'categories' => Category::where('is_active', true)->orderBy('sort_order')->get(),
            'feedAd' => AdSlot::firstWhere('key', AdSlot::LIST_FEED),
            'adFrequency' => max(1, (int) Setting::get('ads_list_frequency', config('secondamano.ads.list_frequency'))),
        ]);
    }
}
