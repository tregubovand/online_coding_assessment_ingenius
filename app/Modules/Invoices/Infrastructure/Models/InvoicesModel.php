<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoicesModel extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    protected $table = 'invoices';
    public $incrementing = false;

    public function company(): HasOne
    {
        return $this->hasOne(CompaniesModel::class, 'id', 'company_id');
    }

    public function billingCompany(): HasOne
    {
        return $this->hasOne(CompaniesModel::class, 'id', 'billing_company_id');
    }

    public function productLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLinesModel::class, 'invoice_id', 'id');
    }
}
