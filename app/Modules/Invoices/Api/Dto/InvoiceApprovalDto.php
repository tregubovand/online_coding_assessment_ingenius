<?php
namespace App\Modules\Invoices\Api\Dto;

use App\Domain\Enums\StatusEnum;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceApprovalDto
{
    public function __construct(
        UuidInterface $id,
        StatusEnum $approve,
    ) {}
}
