<?php

namespace App\Modules\Invoices\Infrastructure\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Application\InvoicesFacade;

readonly class ApproveListener
{
    public function __construct(
        private InvoicesFacade $invoicesFacade
    )
    {
    }

    public function handle(EntityApproved $approved): void
    {
        if ($approved->approvalDto->entity === 'invoice') {
            $this->invoicesFacade->makeApproved($approved->approvalDto->id);
        }
    }
}
