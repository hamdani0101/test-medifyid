<!DOCTYPE html>
<html lang="en">
<head></head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Items</title>
</head>
<body>
    <h1>Detail Kategori Items</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori_items as $kategori_item)
                @foreach($kategori_item->master_items as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->harga_beli }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
</body>
</html>
