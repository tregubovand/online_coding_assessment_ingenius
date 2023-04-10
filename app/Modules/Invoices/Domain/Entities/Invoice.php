<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entities;

use App\Domain\Enums\StatusEnum;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

final class Invoice
{
    public function __construct(
        public UuidInterface    $id,
        public string            $number,
        public StatusEnum        $status,
        public DateTimeImmutable $invoiceDate,
        public DateTimeImmutable $dueDate,
    ) {
    }
}
