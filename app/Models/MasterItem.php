<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'kode', 'image', 'nama', 'harga_beli', 'laba', 'supplier', 'jenis_id'
    ];

    public function jenis_item()
    {
        return $this->belongsTo(JenisItem::class, 'jenis_id', 'id');
    }

    public function kategori_item()
    {
        return $this->belongsToMany(KategoriItem::class, 'master_item_kategori', 'master_item_id', 'kategori_id');
    }
}
