<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api;

use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceFacadeInterface
{
    public function getById(UuidInterface $id): ?InvoiceDto;
    public function getByNumber(string $number): ?InvoiceDto;
    public function makeApproved(UuidInterface $id): void;
    public function makeRejected(UuidInterface $id): void;
}
