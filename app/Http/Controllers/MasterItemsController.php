<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use Illuminate\Http\Request;
use App\Helpers\ItemHelper;
use App\Models\JenisItem;
use App\Http\Requests\ItemRequest;

class MasterItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {

        $data_search = MasterItem::query()->when($request->kode, function($query) use ($request) {
            $query->where('kode', $request->kode);
        })->when($request->nama, function($query) use ($request) {
            $query->where('nama', 'LIKE', '%' . $request->nama . '%');
        })->when($request->hargamin, function($query) use ($request) {
            $query->where('harga_beli', '>=', $request->hargamin)->where('harga_beli', '<=', $request->hargamax);
        })->leftJoin('jenis_items', 'master_items.jenis_id', '=', 'jenis_items.id')
            ->select('master_items.kode', 'master_items.nama', 'jenis_items.name as jenis', 'master_items.harga_beli', 'master_items.laba', 'master_items.supplier')
            ->orderBy('master_items.id')
            ->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        $item = [];
        if ($method != 'new') {
            $item = MasterItem::find($id);
        }

        $data['item'] = $item;
        $data['jenis_items'] = JenisItem::get();
        $data['method'] = $method;
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('jenis_item')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(ItemRequest $request, $method, $id = 0)
    {
        $kode = ItemHelper::generateKode();
        if ($method != 'new') {
            $item = MasterItem::find($id);
            if(!$item) return redirect('master-items')->withErrors(['Item not found']);

            $kode = $item->kode;
        }

        $path = $request->file('image')->storeAs('public/images', $kode.'.jpg');

        $dataCreate = [
            'nama' => $request->nama,
            'harga_beli' => $request->harga_beli,
            'laba' => $request->laba,
            'supplier' => $request->supplier,
            'jenis_id' => $request->jenis,
            'image' => $path
        ];

        MasterItem::updateOrCreate(['kode' => $kode], $dataCreate);

        return redirect('master-items')->with('success', 'Item saved successfully');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
