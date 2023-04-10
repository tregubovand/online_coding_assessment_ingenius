<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceProductLinesModel extends Model
{
    use HasUuids;
    protected  $primaryKey = 'id';
    protected $table = 'invoice_product_lines';

    public function product(): HasOne
    {
        return $this->hasOne(ProductsModel::class, 'id', 'product_id');
    }
}
