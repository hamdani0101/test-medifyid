@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Kembali ke Kategori Item</a>
            </div>
            <div class="card">
                <div class="card-header">Kategori Item</div>

                <div class="card-body">
                    <h1>{{$kategori_item->nama}}</h1>
                    <p>{{$kategori_item->kode}}</p>
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori_item->master_items as $item)
                                <tr>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->harga_beli}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-info" href="{{route('kategori-items.edit', $kategori_item->id)}}">Edit</a>
                    <a class="btn btn-secondary" href="{{ route('kategori-items.print') }}">Print</a>
                    <a class="btn btn-danger" href="{{route('kategori-items.destroy', $kategori_item->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
