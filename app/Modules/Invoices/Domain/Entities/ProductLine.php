<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entities;

use App\Modules\Invoices\Domain\ValueObjects\ProductsPrice;
use InvalidArgumentException;

final class ProductLine
{
    public int $total;
    public function __construct(
        public string        $name,
        public int           $quantity,
        public ProductsPrice $unitPrice,
    ) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty.');
        }

        $this->setTotal();
    }

    public function setTotal(): true
    {
        $this->total = $this->unitPrice->value * $this->quantity;

        return true;
    }
}
