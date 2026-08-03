<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:40px;
        }

        .container{
            width:500px;
        }

        input,
        textarea{
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
        }

        button{
            padding:10px 20px;
            background:orange;
            color:white;
            border:none;
            cursor:pointer;
        }

        a{
            text-decoration:none;
            margin-left:10px;
        }

        .error{
            color:red;
            margin-bottom:15px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Edit Kategori</h2>

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id_kategori) }}" method="POST">

        @csrf
        @method('PUT')

        <label>Nama Kategori</label>

        <input
            type="text"
            name="nama_kategori"
            value="{{ old('nama_kategori', $category->nama_kategori) }}"
        >

        <label>Deskripsi</label>

        <textarea
            name="deskripsi"
            rows="5"
        >{{ old('deskripsi', $category->deskripsi) }}</textarea>

        <button type="submit">
            Update
        </button>

        <a href="{{ route('categories.index') }}">
            Kembali
        </a>

    </form>

</div>

</body>
</html>