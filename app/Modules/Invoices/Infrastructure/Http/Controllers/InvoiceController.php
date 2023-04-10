<?php

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Domain\Enums\StatusEnum;
use App\Infrastructure\Controller;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Http\ResponseDataStorage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    /**
     * @throws Exception
     */
    public function getById(
        Request                $request,
        InvoiceFacadeInterface $invoiceFacade,
    ): JsonResponse
    {
        $response = new ResponseDataStorage();
        $responseCode = Response::HTTP_OK;

        try {
            if (empty($request->input('invoice_id'))) {
                $response->setMessage('invoice_id is missing');
                $responseCode = Response::HTTP_BAD_REQUEST;
            } else {
                $invoiceId = Uuid::fromString($request->input('invoice_id'));

                $invoice = $invoiceFacade->getById($invoiceId);

                if (is_null($invoice)) {
                    $response->setStatus(false);
                    $response->setMessage('Invoice not found');
                    $responseCode = Response::HTTP_NOT_FOUND;
                } else {
                    $response->setData((array) $invoice);
                }
            }
        } catch (Exception $exception) {
            $response->setError($exception->getMessage());
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($response->toArray(), $responseCode);
    }

    /**
     * @throws Exception
     */
    public function approve(
        Request                    $request,
        string                     $id,
        InvoiceFacadeInterface     $invoiceFacade,
        ApprovalFacadeInterface    $approvalFacade,
    ): JsonResponse
    {
        $response = new ResponseDataStorage();
        $responseCode = Response::HTTP_OK;

        try {
            if (empty($id)) {
                $response->setMessage('invoice_id is missing');
                $responseCode = Response::HTTP_BAD_REQUEST;
            } else {
                $invoiceId = Uuid::fromString($id);

                $invoice = $invoiceFacade->getById($invoiceId);

                if (is_null($invoice)) {
                    $response->setStatus(false);
                    $response->setMessage('Invoice not found');
                    $responseCode = Response::HTTP_NOT_FOUND;
                } else {
                    $approvalDto = new ApprovalDto(
                        $invoice->id,
                        $invoice->status,
                        'invoice'
                    );

                    $approvalFacade->approve($approvalDto);
                    $response->setMessage("Invoice approved");
                }
            }
        } catch (Exception $exception) {
            $response->setError($exception->getMessage());
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json($response->toArray(), $responseCode);
    }

    /**
     * @throws Exception
     */
    public function reject(
        Request                    $request,
        ApprovalFacadeInterface    $approvalFacade,
        InvoiceRepositoryInterface $invoiceRepository
    ): JsonResponse
    {
        $invoiceId = $request->input('invoice_id');
        $invoice = $invoiceRepository->getById($invoiceId);

        $response = new ResponseDataStorage();

        if (empty($invoice)) {
            $response->setMessage('invoice not found');
        } else {
            try {
                $approvalDto = new ApprovalDto($invoice->id, StatusEnum::APPROVED, $request->user()->id);
                $approvalFacade->reject($approvalDto);

                $response->setMessage('Invoice approved successfully');

            } catch (Exception $exception) {
                $response->setError($exception->getMessage());
                $response->setStatus(false);
            }
        }

        return response()->json($response->toArray());
    }
}
