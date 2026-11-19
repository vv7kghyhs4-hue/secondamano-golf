<?php

namespace Tests\Feature;

use App\Models\AdSlot;
use App\Models\Listing;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_home_shows_empty_state_and_filters(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Ancora nessun annuncio pubblicato.')
            ->assertSee('Canton Ticino')
            ->assertSee('Putter');
    }

    public function test_prices_show_currency_and_flag(): void
    {
        Listing::factory()->published()->create(['price' => 1250, 'currency' => 'CHF']);
        Listing::factory()->published()->create(['price' => 90, 'currency' => 'EUR']);
        Listing::factory()->published()->create(['is_free' => true, 'price' => null]);

        $this->get('/')
            ->assertSee("CHF 1'250")
            ->assertSee('aria-label="Franchi svizzeri"', false)
            ->assertSee('EUR 90')
            ->assertSee('aria-label="Euro"', false)
            ->assertSee('Gratis');
    }

    public function test_feed_ad_appears_every_n_listings_only_when_it_has_code(): void
    {
        Setting::put('ads_list_frequency', 2);
        Listing::factory()->published()->count(5)->create();

        $this->get('/')->assertDontSee('aria-label="Pubblicità"', false);

        AdSlot::where('key', AdSlot::LIST_FEED)->update(['adsense_code' => '<ins class="adsbygoogle"></ins>']);

        $html = $this->get('/')->getContent();
        // 5 annunci, uno spazio ogni 2 → dopo il 2° e il 4°.
        $this->assertSame(2, substr_count($html, 'aria-label="Pubblicità"'));
    }
}
