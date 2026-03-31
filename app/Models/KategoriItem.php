<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'nama'
    ];

    public function master_items()
    {
        return $this->belongsToMany(MasterItem::class, 'master_item_kategori', 'kategori_id', 'master_item_id');
    }
}
