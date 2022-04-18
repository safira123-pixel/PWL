<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use App\Models\Mahasiswa_MataKuliah;

class MahasiswaController extends Controller
{
 /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 //public function index()
 //{
 //fungsi eloquent menampilkan data menggunakan pagination
 //$mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
 //$paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
 //return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
 //}
 public function index()
    {
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
    }
 public function create()
 {
    $kelas =Kelas::all(); // mendapatkan data dari tabel kelas
    return view('mahasiswa.create',['kelas' => $kelas]);
 }
 public function store(Request $request)
 {
    //melakukan validasi data
    $request->validate([
        'Nim' => 'required',
        'Nama' => 'required',
        'Kelas' => 'required',
        'Jurusan' => 'required'   
    ]);
    $mahasiswa = new Mahasiswa;
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('kelas');

    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();
    // Mahasiswa::create($request->all());
    
    //jika data berhasil ditambahkan, akan kembali ke halaman utama
    return redirect()->route('mahasiswa.index')
    ->with('success', 'Mahasiswa Berhasil Ditambahkan');
 }
 public function show($nim)
 {
 //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
 $mahasiswa = Mahasiswa::with('Kelas')->where('nim', $nim)->first();
 return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
 }
 public function edit($nim)
 {
//menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
 $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
$kelas = Kelas::all();
 return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
 }
 public function update(Request $request, $nim)
 {
//melakukan validasi data
 $request->validate([
 'Nim' => 'required',
 'Nama' => 'required',
 'Kelas' => 'required',
 'Jurusan' => 'required',
 ]);

 $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');

 $mahasiswa->kelas()->associate($kelas);
 $mahasiswa->save();
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

 public function khs($nim){
    $mhs = Mahasiswa::where('nim', $nim)->first();
    $nilai = Mahasiswa_MataKuliah::where('mahasiswa_id', $mhs->id_mahasiswa)
                                   ->with('matakuliah')
                                   ->with('mahasiswa')
                                   ->get();
    $nilai->mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
    // dd($nilai);

    return view('mahasiswa.khs', compact('nilai'));
}

 public function search(Request $request){
    // Get the search value from the request
    $search = $request->input('search');
    //dd($search);
    // Search in the title and body columns from the posts table
    $paginate = Mahasiswa::where('nim', 'LIKE', "%{$search}%")
        ->orWhere('nama', 'LIKE', "%{$search}%")
        ->paginate();

    // Return the search view with the resluts compacted
    return view('mahasiswa.search', compact('paginate'));
}
}; 