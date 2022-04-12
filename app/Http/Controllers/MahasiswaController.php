<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 //  public function index()
//     {
//         $data = Mahasiswa::paginate(4);
//         return view('mahasiswa.index',compact('data'));
//     }
 public function index() {
 //fungsi eloquent menampilkan data menggunakan pagination
 $mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
 $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
 return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
 }

 public function create()
 {
 //return view('mahasiswa.create');
 $kelas = Kelas::all(); //Mendapatkan Data dari Tabel Kelas
 return view('mahasiswa.create', ['kelas' => $kelas]);
 }
 public function store(Request $request) {
 //melakukan validasi data
 $request->validate([
 'Nim' => 'required',
 'Nama' => 'required',
 'Kelas' => 'required',
 'Jurusan' => 'required',
 'Email' => 'required',
 'Alamat' => 'required',
 'Tanggallahir' => 'required',
 ]);
 
$mahasiswa = new Mahasiswa;
$mahasiswa->nim = $request->get('Nim');
$mahasiswa->nama = $request->get('Nama');
$mahasiswa->jurusan = $request->get('Jurusan');
$mahasiswa->email = $request->get('Email');
$mahasiswa->alamat = $request->get('Alamat');
$mahasiswa->tanggallahir = $request->get('Tanggallahir');
$mahasiswa->save();

$kelas = new Kelas;
$kelas->id = $request->get('Kelas');

$mahasiswa->kelas()->associate($kelas);
$mahasiswa->save();

return redirect()->route('mahasiswa.index')
->with('success', 'Mahasiswa Berhasil Ditambahkan');

//  fungsi eloquent untuk menambah data
//  Mahasiswa::create($request->all());
//  jika data berhasil ditambahkan, akan kembali ke halaman utama

 }
 public function show($nim)
 {
 //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
 $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();

 return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);

//  $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
//  return view('mahasiswa.detail', compact('Mahasiswa'));
 }
 public function edit($nim)
 {
//menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
 $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
 return view('mahasiswa.edit', compact('Mahasiswa'));
 }
 public function update(Request $request, $nim)
 {
//melakukan validasi data
 $request->validate([
 'Nim' => 'required',
 'Nama' => 'required',
 'Kelas' => 'required',
 'Jurusan' => 'required',
 'Email' => 'required',
 'Alamat' => 'required',
 'Tanggallahir' => 'required',
 ]);
//fungsi eloquent untuk mengupdate data inputan kita
 Mahasiswa::where('nim', $nim)
 ->update([
 'nim'=>$request->Nim,
 'nama'=>$request->Nama,
 'kelas'=>$request->Kelas,
 'jurusan'=>$request->Jurusan,
 'email'=>$request->Email,
 'alamat'=>$request->Alamat,
 'tanggallahir'=>$request->Tanggallahir,
 ]);
//jika data berhasil diupdate, akan kembali ke halaman utama
 return redirect()->route('mahasiswa.index')
 ->with('success', 'Mahasiswa Berhasil Diupdate');
 }
 public function destroy( $nim)
 {
//fungsi eloquent untuk menghapus data
 Mahasiswa::where('nim', $nim)->delete();
 return redirect()->route('mahasiswa.index')
 -> with('success', 'Mahasiswa Berhasil Dihapus');
 }

 public function search(Request $request){
    // Get the search value from the request
    $search = $request->input('search');
    //dd($search);
    // Search in the title and body columns from the posts table
    $data = Mahasiswa::where('nim', 'LIKE', "%{$search}%")
        ->orWhere('nama', 'LIKE', "%{$search}%")
        ->paginate();

    // Return the search view with the resluts compacted
    return view('mahasiswa.search', compact('data'));
}
}; 