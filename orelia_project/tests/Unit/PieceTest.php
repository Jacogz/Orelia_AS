<?php

namespace Tests\Unit;

use App\Models\Piece;
use PHPUnit\Framework\TestCase;

class PieceTest extends TestCase
{
    public function test_piece_getters_and_setters(): void
    {
        $piece = new Piece;
        $piece->setName('Golden Ring');
        $piece->setPrice(150000);
        $piece->setStock(10);

        $this->assertEquals('Golden Ring', $piece->getName());
        $this->assertEquals(150000, $piece->getPrice());
        $this->assertEquals(10, $piece->getStock());
    }

    public function test_piece_returns_default_image_when_no_image_set(): void
    {
        $piece = new Piece;
        $piece->setImageUrl(null);

        $this->assertEquals(Piece::DEFAULT_IMAGE, $piece->getImageUrl());
    }
}
