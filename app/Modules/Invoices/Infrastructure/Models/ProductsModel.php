<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasUuids;
    protected  $primaryKey = 'id';
    protected $table = 'products';
}
