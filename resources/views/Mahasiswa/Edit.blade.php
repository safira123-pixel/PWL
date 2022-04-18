@extends('mahasiswa.layout')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
        <div class="card-header">
            Edit Mahasiswa
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="post" action="{{ route('mahasiswa.update', $mahasiswa->nim) }}" id="myForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Nim">Nim</label>
                    <input type="text" name="Nim" class="form-control" id="Nim" value="{{ $mahasiswa->nim }}" aria-describedby="Nim" >
                </div>
                <div class="form-group">
                    <label for="Nama">Nama</label>
                    <input type="text" name="Nama" class="form-control" id="Nama" value="{{ $mahasiswa->nama }}" aria-describedby="Nama" >
                </div>
                <div class="form-group">
                    <label for="Kelas">Kelas</label>
                    <input type="Kelas" name="Kelas" class="form-control" id="Kelas" value="{{ $mahasiswa->kelas }}" aria-describedby="Kelas" >
                </div>
                <div class="form-group">
                    <label for="Jurusan">Jurusan</label>
                    <input type="Jurusan" name="Jurusan" class="form-control" id="Jurusan" value="{{ $mahasiswa->jurusan }}" aria-describedby="Jurusan" >
                </div>
                <!-- <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="Email" name="Email" class="form-control" id="Email" value="{{ $mahasiswa->email }}" aria-describedby="Email" >
                </div>
                <div class="form-group">
                    <label for="Alamat">Alamat</label>
                    <input type="Alamat" name="Alamat" class="form-control" id="Alamat" value="{{ $mahasiswa->alamat }}" aria-describedby="Alamat" >
                </div>
                <div class="form-group">
                    <label for="Tanggallahir">Tanggal Lahir</label>
                    <input type="Tanggallahir" name="Tanggallahir" class="form-control" id="Tanggallahir" value="{{ $mahasiswa->tanggallahir }}" aria-describedby="Tanggallahir" >
                </div> -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</div>
@endsection