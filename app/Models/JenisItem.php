<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'name'
    ];

    public function master_items()
    {
        return $this->hasMany(MasterItem::class, 'jenis_id', 'id');
    }
}
