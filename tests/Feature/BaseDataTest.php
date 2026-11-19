<?php

namespace Tests\Feature;

use App\Models\AdSlot;
use App\Models\Category;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseDataTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_zones_are_ticino_plus_107_italian_provinces(): void
    {
        $this->assertSame(1, Province::where('country', 'CH')->count());
        $this->assertSame(107, Province::where('country', 'IT')->count());
        $this->assertSame('Canton Ticino', Province::orderBy('sort_order')->first()->name);
    }

    public function test_categories_match_the_analysis(): void
    {
        $this->assertSame(12, Category::count());
        $this->assertTrue(Category::where('slug', 'putter')->first()->is_club);
        $this->assertTrue(Category::where('slug', 'wedge')->first()->has_loft);
        $this->assertFalse(Category::where('slug', 'sacche')->first()->is_club);
    }

    public function test_four_ad_positions_exist_without_code(): void
    {
        $this->assertSame(4, AdSlot::count());
        $this->assertFalse(AdSlot::firstWhere('key', AdSlot::GALLERY_END)->isRenderable());
    }
}
