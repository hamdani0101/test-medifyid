<?php

namespace App\Helpers;

use App\Models\MasterItem;
use Illuminate\Support\Facades\DB;

class ItemHelper
{
    public static function generateKode()
    {
        return DB::transaction(function () {
            $kode = MasterItem::latest('id')->lockForUpdate()->first();
            $kode = $kode ? $kode->id + 1 : 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            return $kode;
        });
    }
}
