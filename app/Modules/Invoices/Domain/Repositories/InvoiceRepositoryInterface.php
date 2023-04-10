<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepositoryInterface
{
    public function getById(UuidInterface $invoiceId): ?Invoice;
    public function getByInvoiceNumber(string $invoiceNumber): ?Invoice;
    public function setStatusById(UuidInterface $invoiceId, StatusEnum $status): true;
}
