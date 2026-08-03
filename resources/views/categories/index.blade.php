<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:40px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table,th,td{
            border:1px solid #ccc;
        }

        th,td{
            padding:10px;
            text-align:left;
        }

        .btn{
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
            color:white;
        }

        .btn-add{
            background:green;
        }

        .btn-edit{
            background:orange;
        }

        .btn-delete{
            background:red;
            border:none;
            cursor:pointer;
        }

        .success{
            background:#d4edda;
            padding:10px;
            margin-bottom:15px;
            border-radius:5px;
        }
    </style>
</head>
<body>

<h2>Daftar Kategori</h2>

@if(session('success'))
<div class="success">
    {{ session('success') }}
</div>
@endif

<a href="{{ route('categories.create') }}" class="btn btn-add">
    Tambah Kategori
</a>

<table>

    <thead>

        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

    </thead>

    <tbody>

        @forelse($categories as $category)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $category->nama_kategori }}</td>

            <td>{{ $category->deskripsi }}</td>

            <td>

                <a href="{{ route('categories.edit',$category->id_kategori) }}" class="btn btn-edit">
                    Edit
                </a>

                <form action="{{ route('categories.destroy',$category->id_kategori) }}" method="POST" style="display:inline;">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-delete"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="4">
                Belum ada data kategori.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</body>
</html>