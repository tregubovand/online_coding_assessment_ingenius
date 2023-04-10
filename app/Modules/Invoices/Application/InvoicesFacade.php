<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Mappers\InvoiceMapper;
use Ramsey\Uuid\UuidInterface;

final readonly class InvoicesFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private InvoiceMapper $invoiceMapper,
    ) {
    }
    public function getById(UuidInterface $id): ?InvoiceDto
    {
        $invoice = $this->invoiceRepository->getById($id);

        if ($invoice === null) {
            return null;
        }

        return $this->invoiceMapper->mapToDto($invoice);
    }

    public function getByNumber(string $number): ?InvoiceDto
    {
        $invoice = $this->invoiceRepository->getByInvoiceNumber($number);

        if ($invoice === null) {
            return null;
        }

        return $this->invoiceMapper->mapToDto($invoice);
    }

    public function makeApproved(UuidInterface $id): void
    {
        $this->invoiceRepository->setStatusById($id, StatusEnum::APPROVED);
    }

    public function makeRejected(UuidInterface $id): void
    {
        $this->invoiceRepository->setStatusById($id, StatusEnum::REJECTED);
    }
}
