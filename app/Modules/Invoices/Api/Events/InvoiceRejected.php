<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Events;

use App\Modules\Invoices\Api\Dto\InvoiceApprovalDto;
use Illuminate\Foundation\Events\Dispatchable;

final class InvoiceRejected
{
    use Dispatchable;

    public function __construct(public readonly InvoiceApprovalDto $invoice)
    {
    }
}
