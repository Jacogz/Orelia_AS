<?php

namespace Tests\Feature\Piece;

use App\Models\Collection;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PieceImageStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_piece_with_image_stores_path_and_generates_url(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'admin']);
        $collection = Collection::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('admin.pieces.store'), [
                'name' => 'Test Piece',
                'description' => 'A test piece',
                'price' => 100,
                'type' => 'ring',
                'image' => UploadedFile::fake()->image('test.jpg'),
                'stock' => 10,
                'size' => '7',
                'weight' => 5.5,
                'collection_id' => $collection->getId(),
            ]);

        $response->assertRedirect(route('admin.pieces.index'));

        $piece = Piece::first();
        $this->assertNotNull($piece);
        $this->assertNotNull($piece->getImageUrl());
        $this->assertNotEquals(Piece::DEFAULT_IMAGE, $piece->getImageUrl());

        $imageUrl = $piece->getImageUrl();
        $this->assertStringContainsString('pieces/', $imageUrl);

        $path = $piece->getImagePath();
        Storage::disk('public')->assertExists($path);
    }

    public function test_update_piece_with_new_image_replaces_old_one(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'admin']);
        $collection = Collection::factory()->create();
        $piece = Piece::factory()->create([
            'collection_id' => $collection->getId(),
        ]);

        $oldImageUrl = $piece->getImageUrl();

        $response = $this->actingAs($user)
            ->putJson(route('admin.pieces.update', $piece->getId()), [
                'name' => $piece->getName(),
                'description' => $piece->getDescription(),
                'price' => $piece->getPrice(),
                'type' => $piece->getType(),
                'image' => UploadedFile::fake()->image('new.jpg'),
                'stock' => $piece->getStock(),
                'size' => $piece->getSize(),
                'weight' => $piece->getWeight(),
                'collection_id' => $collection->getId(),
            ]);

        $response->assertRedirect(route('admin.pieces.index'));

        $piece->refresh();
        $this->assertNotEquals($oldImageUrl, $piece->getImageUrl());
        $this->assertNotEquals(Piece::DEFAULT_IMAGE, $piece->getImageUrl());

        $imageUrl = $piece->getImageUrl();
        $this->assertStringContainsString('pieces/', $imageUrl);

        $path = $piece->getImagePath();
        Storage::disk('public')->assertExists($path);
    }
}
