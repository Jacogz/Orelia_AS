<?php

namespace Tests\Feature\Piece;

use App\Models\Collection;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CartImageDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_displays_piece_image_url_correctly(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $collection = Collection::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.pieces.store'), [
                'name' => 'Ring with Image',
                'description' => 'Test',
                'price' => 100,
                'type' => 'ring',
                'image' => UploadedFile::fake()->image('ring.jpg'),
                'stock' => 10,
                'size' => '7',
                'weight' => 5.5,
                'collection_id' => $collection->getId(),
            ]);

        $piece = Piece::first();
        $this->assertNotNull($piece);

        $session = $this->app->make('session');
        $session->put('cart', [$piece->getId() => 2]);

        $response = $this->actingAs($user)
            ->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertSee($piece->getImageUrl());
    }
}
