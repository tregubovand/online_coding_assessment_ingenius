<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Entities\Company;
use App\Modules\Invoices\Domain\Entities\ProductLine;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;


class Invoice
{
    public function __construct(
        public UuidInterface $id,
        public string $number,
        public StatusEnum $status,
        public DateTimeImmutable $invoiceDate,
        public DateTimeImmutable $dueDate,
        public Company $company,
        public Company $billedCompany,
        /** @var ProductLine[] */
        public array $products,
    ) {
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total += $product->total;
        }

        return $total;
    }
}
