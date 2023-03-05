<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarBarang extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'keluar_barang';


    public function storeData($input)
    {
        return static::create($input);
    }

    public function supplier()
    {
        return $this->belongsTo(DataSupplier::class);
    }

    public function barang()
    {
        return $this->belongsTo(DataBarang::class);
    }
}
