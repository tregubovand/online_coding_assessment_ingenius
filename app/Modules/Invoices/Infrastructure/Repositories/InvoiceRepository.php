<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Mappers\InvoiceMapper;
use App\Modules\Invoices\Infrastructure\Models\InvoicesModel;
use Ramsey\Uuid\UuidInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(private readonly InvoiceMapper $invoiceMapper)
    {
    }
    public function getById(UuidInterface $invoiceId): ?Invoice
    {
        $invoiceData = InvoicesModel::find($invoiceId->toString());

        if (is_null($invoiceData)) {
            return null;
        }

        return $this->invoiceMapper->mapFromInvoiceModelToDomainObject($invoiceData);
    }
    public function getByInvoiceNumber(string $invoiceNumber): ?Invoice
    {
        $invoiceData = InvoicesModel::where('number', $invoiceNumber);

        if (is_null($invoiceData)) {
            return null;
        }

        return $this->invoiceMapper->mapFromInvoiceModelToDomainObject($invoiceData);
    }

    /**
     * @throws \Exception
     */
    public function setStatusById(UuidInterface $invoiceId, StatusEnum $status): true
    {
        $invoiceModel = InvoicesModel::find($invoiceId);

        if (empty($invoiceModel)) {
            throw new \Exception("Invoice not found");
        }

        $invoiceModel->status = $status->value;
        $invoiceModel->save();

        return true;
    }
}
