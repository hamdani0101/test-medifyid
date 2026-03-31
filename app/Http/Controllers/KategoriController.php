<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\KategoriRequest;

use App\Models\KategoriItem;
use App\Models\MasterItem;

use Barryvdh\DomPDF\Facade\Pdf;


class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kategori_items = KategoriItem::get();
        return view('kategori_items.index', compact('kategori_items'));
    }

    public function show($id)
    {
        $kategori_item = KategoriItem::with('master_items')->findOrFail($id);
        return view('kategori_items.show', compact('kategori_item'));
    }

    public function print()
    {
        $kategori_items = KategoriItem::with('master_items')->get();
        pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf = Pdf::loadView('kategori_items.print', compact('kategori_items'));
        return $pdf->download('kategori_items.pdf');
    }

    public function store(KategoriRequest $request)
    {
        $data = $request->validated();


        try{
            $create = KategoriItem::create($data);
            $create->master_items()->sync($data['items']);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan Kategori Item.');

        }

        return redirect()->route('kategori-items.index')->with('success', 'Kategori Item berhasil ditambahkan.');
    }

    public function update(KategoriRequest $request, $id)
    {
        $data = $request->validated();

        try{
            $kategori_item = KategoriItem::findOrFail($id);
            $kategori_item->master_items()->sync($data['items']);
            $kategori_item->update($data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui Kategori Item.');

        }

        return redirect()->route('kategori-items.index')->with('success', 'Kategori Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try{
            $kategori_item = KategoriItem::findOrFail($id);
            if($kategori_item->master_items()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus Kategori Item karena masih memiliki relasi dengan Master Item.');
            }

            $kategori_item->delete();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Kategori Item.');

        }

        return redirect()->route('kategori-items.index')->with('success', 'Kategori Item berhasil dihapus.');
    }

    public function getAllItems(){
        $data = MasterItem::all();
        return response()->json($data);
    }
}
