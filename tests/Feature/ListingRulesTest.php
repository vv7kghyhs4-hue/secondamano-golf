<?php

namespace Tests\Feature;

use App\Enums\ListingStatus;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingRulesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_publishing_sets_a_60_day_expiry(): void
    {
        $this->freezeSecond();
        $listing = Listing::factory()->create();

        $listing->publish();

        $this->assertSame(ListingStatus::Published, $listing->status);
        $this->assertTrue($listing->expires_at->equalTo(now()->addDays(60)));
    }

    public function test_expired_and_draft_listings_are_not_visible(): void
    {
        Listing::factory()->published()->create(['title' => 'Visibile']);
        Listing::factory()->create(['title' => 'Bozza']);
        Listing::factory()->published()->create(['title' => 'Scaduto', 'expires_at' => now()->subDay()]);

        $this->assertSame(['Visibile'], Listing::visible()->pluck('title')->all());
    }

    public function test_private_users_can_have_at_most_30_active_listings(): void
    {
        $user = User::factory()->create();
        Listing::factory()->published()->count(29)->for($user)->create();
        $this->assertTrue($user->canPublishAnotherListing());

        Listing::factory()->published()->for($user)->create();
        $this->assertFalse($user->canPublishAnotherListing());
    }

    public function test_proshops_have_no_listing_limit(): void
    {
        $shop = User::factory()->proshop()->create();
        Listing::factory()->published()->count(30)->for($shop)->create();

        $this->assertTrue($shop->canPublishAnotherListing());
    }
}
