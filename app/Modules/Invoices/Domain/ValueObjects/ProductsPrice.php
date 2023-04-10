<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\ValueObjects;

final readonly class ProductsPrice
{
    public function __construct(
        public int $value,
        public string $currency
    )
    {
    }
}
