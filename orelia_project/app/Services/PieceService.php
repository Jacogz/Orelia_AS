<?php

namespace App\Services;

use App\Contracts\Storage\ImageStorageInterface;
use App\Models\Piece;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;

class PieceService
{
    public function __construct(
        private readonly ImageStorageInterface $imageStorage,
    ) {}

    public function createPiece(array $pieceData, ?UploadedFile $image): Piece
    {
        try {
            if ($image !== null) {
                $pieceData['image_url'] = $this->imageStorage->upload($image, 'pieces');
            }

            $piece = new Piece;
            $piece->fill($pieceData);
            $piece->save();

            return $piece;
        } catch (QueryException $e) {
            if (isset($pieceData['image_url'])) {
                $this->imageStorage->delete($pieceData['image_url']);
            }

            throw $e;
        }
    }

    public function updatePiece(Piece $piece, array $pieceData, ?UploadedFile $image): Piece
    {
        try {
            if ($image !== null) {
                $currentPath = $piece->getImageUrl();

                if ($currentPath !== null && $currentPath !== Piece::DEFAULT_IMAGE) {
                    $this->imageStorage->delete($currentPath);
                }

                $pieceData['image_url'] = $this->imageStorage->upload($image, 'pieces');
            }

            $piece->fill($pieceData);
            $piece->save();

            return $piece;
        } catch (QueryException $e) {
            if (isset($pieceData['image_url'])) {
                $this->imageStorage->delete($pieceData['image_url']);
            }

            throw $e;
        }
    }
}
