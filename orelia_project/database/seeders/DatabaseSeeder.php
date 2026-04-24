<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Fixed accounts ──────────────────────────────────────────────────────
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@admin.com',
            'address' => '123 Admin St, Springfield',
            'password' => Hash::make('adminpassword'),
        ]);

        $demoClient = User::factory()->client()->create([
            'name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'address' => '456 Maple Ave, Shelbyville',
            'password' => Hash::make('userpassword'),
        ]);

        // ── Random clients ───────────────────────────────────────────────────────
        $clients = User::factory()->client()->count(12)->create();
        $clients->push($demoClient); // include the demo client in orders

        // ── Materials ────────────────────────────────────────────────────────────
        // The MaterialFactory uses fake()->unique() so up to 24 materials can be created.
        $materials = Material::factory()->count(20)->create();

        // ── Collections & Pieces ─────────────────────────────────────────────────
        // 8 collections, each with 4–7 pieces; each piece gets 1–3 materials.
        $allPieces = collect();

        Collection::factory()->count(8)->create()->each(function (Collection $collection) use ($materials, &$allPieces) {
            $pieceCount = fake()->numberBetween(4, 7);

            Piece::factory()
                ->count($pieceCount)
                ->create(['collection_id' => $collection->id])
                ->each(function (Piece $piece) use ($materials) {
                    $assignedMaterials = $materials->random(fake()->numberBetween(1, 3));
                    $piece->materials()->attach($assignedMaterials->pluck('id')->toArray());
                });

            $allPieces = $allPieces->merge($collection->pieces);
        });

        // ── Orders ───────────────────────────────────────────────────────────────
        // Each client gets 2–4 orders; each order has 1–4 items drawn from existing pieces.
        $clients->each(function (User $client) use ($allPieces) {
            $orderCount = fake()->numberBetween(2, 4);

            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::factory()->create(['client_id' => $client->id]);

                $itemCount = fake()->numberBetween(1, 4);
                $selectedPieces = $allPieces->random($itemCount);
                $orderTotal = 0;

                foreach ($selectedPieces as $piece) {
                    $quantity = fake()->numberBetween(1, 3);
                    $unitPrice = $piece->price;
                    $subtotal = $unitPrice * $quantity;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'piece_id' => $piece->id,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);

                    $orderTotal += $subtotal;
                }

                $order->update(['total' => $orderTotal]);
            }
        });
    }
}
