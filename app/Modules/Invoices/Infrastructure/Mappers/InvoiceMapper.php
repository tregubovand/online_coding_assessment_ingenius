<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Api\Dto\InvoiceDto;
use App\Modules\Invoices\Domain\Entities\Company;
use App\Modules\Invoices\Domain\Entities\ProductLine;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\ValueObjects\ProductsPrice;
use App\Modules\Invoices\Infrastructure\Models\CompaniesModel;
use App\Modules\Invoices\Infrastructure\Models\InvoiceProductLinesModel;
use App\Modules\Invoices\Infrastructure\Models\InvoicesModel;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Uuid;


final class InvoiceMapper
{
    public function mapToDto(Invoice $invoice): ?InvoiceDto
    {
        return new InvoiceDto(
            id: $invoice->id,
            status: $invoice->status,
            number: $invoice->number,
            dueDate: $invoice->dueDate,
            invoiceDate: $invoice->invoiceDate,
            company: $invoice->company,
            billedCompany: $invoice->billedCompany,
            products: $invoice->products,
            total: $invoice->getTotal(),
        );
    }

    public function mapFromInvoiceModelToDomainObject(InvoicesModel $invoicesModel): Invoice
    {
        $companyData = $invoicesModel->company()->first();
        $billingCompanyData = $invoicesModel->billingCompany()->first();
        $products = $invoicesModel->productLines()->get();

        return new Invoice(
            id: Uuid::fromString($invoicesModel->id),
            number: $invoicesModel->number,
            status: $this->stringStatusToEnum($invoicesModel->status),
            invoiceDate: new \DateTimeImmutable($invoicesModel->date),
            dueDate:  new \DateTimeImmutable($invoicesModel->due_date),
            company: $this->mapFromCompanyModelToEntity($companyData),
            billedCompany: $this->mapFromCompanyModelToEntity($billingCompanyData),
            products: $this->mapFromProductsModelArrayToEntityArray($products),
        );
    }

    private function mapFromCompanyModelToEntity(?CompaniesModel $companiesModel): Company
    {
        return new Company(
            name: $companiesModel->name,
            streetAddress: $companiesModel->street,
            city: $companiesModel->city,
            zipCode: $companiesModel->zip,
            phone: $companiesModel->phone,
            emailAddress: $companiesModel->email,
        );
    }

    /**
     * @param Collection<InvoiceProductLinesModel> $products
     * @return ProductLine[]
     */
    private function mapFromProductsModelArrayToEntityArray(Collection $products): array
    {
        $productsEntities = [];

        foreach ($products as $product)
        {
            $productLine = $this->mapFromProductLinesModelToEntity($product);

            if (!is_null($productLine)) {
                $productsEntities[] = $productLine;
            }
        }

        return $productsEntities;
    }

    private function mapFromProductLinesModelToEntity(InvoiceProductLinesModel $invoiceProductLinesModel): ?ProductLine
    {
        $productData = $invoiceProductLinesModel->product()->first();

        if (empty($productData)) {
            return null;
        }

        $price = new ProductsPrice(
            value: $productData->price,
            currency: $productData->currency,
        );

        return new ProductLine(
            name: $productData->name,
            quantity: $invoiceProductLinesModel->quantity,
            unitPrice: $price,
        );
    }

    public function stringStatusToEnum(string $statusName): StatusEnum
    {
        foreach (StatusEnum::cases() as $status) {
            if ($status->value === $statusName) {
                return $status;
            }
        }

        throw new \ValueError("Status {$statusName} not supported");
    }
}
