<?php
namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Entities\Company;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceDto
{
    public function __construct(
        public UuidInterface $id,
        public StatusEnum $status,
        public string                     $number,
        public \DateTimeImmutable         $dueDate,
        public \DateTimeImmutable         $invoiceDate,
        public Company                      $company,
        public Company                      $billedCompany,
        public array                      $products,
        public int                        $total,
    ) {}
}
