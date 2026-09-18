<?php

namespace App\Enums;

enum ProductBadge: string
{
    case BestSeller = 'best_seller';
    case Favorite = 'favorit';
    case Recommended = 'recommended';

    public function label(): string
    {
        return match ($this) {
            self::BestSeller => 'Best Seller',
            self::Favorite => 'Favorit',
            self::Recommended => 'Recommended',
        };
    }
}
