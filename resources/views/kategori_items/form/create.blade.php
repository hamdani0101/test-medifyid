@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Kembali ke Kategori Item</a>
            </div>
            <div class="card">

                <div class="card-header">Buat Kategori Item Baru</div>

                <div class="card-body">
                    <form action="{{ route('kategori-items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>

                        <div class="form-group">
                            <label>Kode</label>
                            <input type="number" class="form-control" name="kode" required>
                        </div>

                        <div class="form-group">
                            <label>Items</label>
                            <input type="text" class="form-control" data-role="tagsinput" id="tags">
                        </div>

                        <button class="btn btn-primary mt-3">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
