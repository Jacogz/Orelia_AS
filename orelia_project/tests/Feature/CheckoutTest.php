<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        $user = new User;
        $user->fill([
            'name'      => 'Test',
            'last_name' => 'User',
            'email'     => 'test@test.com',
            'password'  => bcrypt('password'),
            'address'   => '123 St',
            'role'      => 'client',
        ]);
        $user->save();

        return $user;
    }

    private function makePiece(): Piece
    {
        $collection = new Collection;
        $collection->fill(['name' => 'Test Collection', 'description' => 'desc']);
        $collection->save();

        $piece = new Piece;
        $piece->fill([
            'name'          => 'Test Ring',
            'price'         => 100000,
            'type'          => 'ring',
            'stock'         => 10,
            'collection_id' => $collection->getId(),
        ]);
        $piece->save();

        return $piece;
    }

    public function test_checkout_creates_order_and_items(): void
    {
        $user = $this->makeUser();
        $piece = $this->makePiece();
        $cart = [$piece->getId() => 2];

        $response = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->post(route('cart.checkout'));

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('success');
        $response->assertSessionMissing('error');

        $order = Order::where('user_id', $user->getId())->latest()->first();
        $this->assertNotNull($order, 'Order was not created');
        $this->assertEquals('pending', $order->getStatus());

        $items = OrderItem::where('order_id', $order->getId())->get();
        $this->assertCount(1, $items);
        $this->assertEquals(200000, $order->getTotal());
    }

    public function test_checkout_fails_with_empty_cart(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)
            ->withSession(['cart' => []])
            ->post(route('cart.checkout'));

        $response->assertRedirect();
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_checkout_clears_cart_on_success(): void
    {
        $user = $this->makeUser();
        $piece = $this->makePiece();
        $cart = [$piece->getId() => 1];

        $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->post(route('cart.checkout'))
            ->assertSessionMissing('cart');
    }
}
