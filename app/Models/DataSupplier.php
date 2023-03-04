<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSupplier extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'data_supplier';

    public function storeData($input)
    {
        return static::updateOrCreate($input);
    }

    public function suppliers()
    {
        $this->hasMany(TerimaBarang::class, 'supplier_id');
    }
}
