<?php

namespace App\Http\Controllers;

use App\Models\category_model;
use App\Models\logs_model;
use App\Models\tickets_model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class main_controller extends Controller
{
    public function index(){
        $category = category_model::all();
        $tickets = tickets_model::all();
        $users = User::all();
        $logs = logs_model::all();
        $user = Auth::user();
        if ($user->role == 'guru' || $user->role == 'staf' || $user->role == 'siswa') {
            $activeMenu = 'rekap_laporan';
            return view('user/main', ['activeMenu' => $activeMenu, 'category' => $category, 'tickets' => $tickets, 'users' => $users, 'logs' => $logs]);
        } else {
            $activeMenu = 'dashboard';
            return view('admin/main', ['activeMenu' => $activeMenu, 'category' => $category, 'tickets' => $tickets, 'users' => $users, 'logs' => $logs]);
        }
    }

    public function login(){
        $user = Auth::user();
        // kondisi jika usernya ada
        // dd($user);
        if ($user) {
            return redirect()->intended('user');
        }
        return view('login');
    }    

    public function proses_login(Request $request) {
        // Validasi form username dan password
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        // Ambil data username dan password
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            // dd(Auth::user());
            $request->session()->regenerate();

            if ($request->ajax()) {
                return response()->json(['status' => 'success']);
            } else {
                return redirect()->intended('user');
            }
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau Password salah!'
                ]);
            } else {
                return redirect('login_admin')
                    ->withInput()
                    ->withErrors(['error' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
            }
        }
    }

    // public function proses_login(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $username = $request->username;
    //     $password = $request->password;

    //     // Konfigurasi API
    //     $apiUrl = 'https://test-api.sekolahsabilillah.sch.id/api.php';
    //     $token  = '40f6c8e7fb3f22be8449ffd7980b85e74a0dd65a';

    //     try {

    //         $pegawaiResponse = Http::withHeaders([
    //             'Authorization' => $token
    //         ])->get($apiUrl, [
    //             'endpoint' => 'data-pegawai'
    //         ]);
    //         // dd($pegawaiResponse);

    //         $siswaResponse = Http::withHeaders([
    //             'Authorization' => $token
    //         ])->get($apiUrl, [
    //             'endpoint' => 'data-siswa'
    //         ]);

    //         if (!$pegawaiResponse->successful() || !$siswaResponse->successful()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal terhubung ke server autentikasi'
    //             ], 500);
    //         }

    //         // Gabungkan data user
    //         $users = collect($pegawaiResponse->json())
    //             ->merge($siswaResponse->json());

    //         // Cari user berdasarkan username
    //         $user = $users->firstWhere('USERNAME', $username);

    //         if (!$user) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Username tidak ditemukan'
    //             ], 401);
    //         }

    //         // Cek status aktif
    //         if (isset($user['STATUS']) && $user['STATUS'] !== 'aktif') {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Akun tidak aktif'
    //             ], 403);
    //         }

    //         // Verifikasi password (API hash dari "testProgrammer")
    //         if (!Hash::check($password, $user['PASSWORD'])) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Username atau Password salah'
    //             ], 401);
    //         }

    //         /**
    //          * 3. Simpan ke session
    //          */
    //         Session::put('login', true);
    //         Session::put('username', $user['USERNAME']);
    //         Session::put('role', $user['ROLE'] ?? 'siswa');
    //         Session::put('user', $user);

    //         // Response
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'role' => $user['ROLE'] ?? 'siswa'
    //             ]);
    //         }

    //         // Redirect berdasarkan role
    //         if (($user['ROLE'] ?? '') === 'admin') {
    //             return redirect()->route('admin.dashboard');
    //         } elseif (($user['ROLE'] ?? '') === 'guru') {
    //             return redirect()->route('guru.dashboard');
    //         } else {
    //             return redirect()->route('siswa.dashboard');
    //         }

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan sistem',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function proses_login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $username = $request->username;
    //     $password = $request->password;

    //     $apiUrl = 'https://test-api.sekolahsabilillah.sch.id/api.php';
    //     $token  = '40f6c8e7fb3f22be8449ffd7980b85e74a0dd65a';

    //     try {
    //         // =====================
    //         // DATA PEGAWAI
    //         // =====================
    //         $pegawaiResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Accept' => 'application/json',
    //         ])->get($apiUrl, [
    //             'endpoint' => 'data-pegawai'
    //         ]);
    //         // dd($pegawaiResponse->json());

    //         // =====================
    //         // DATA SISWA
    //         // =====================
    //         $siswaResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Accept' => 'application/json',
    //         ])->get($apiUrl, [
    //             'endpoint' => 'data-siswa'
    //         ]);

    //         if (!$pegawaiResponse->successful() || !$siswaResponse->successful()) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Gagal menghubungi server autentikasi'
    //             ], 500);
    //         }

    //         $users = collect($pegawaiResponse->json()['data'])
    //         ->concat($siswaResponse->json()['data']);

    //         // Cari user
    //         $user = $users->firstWhere('USERNAME', $username);
    //         // dd($username, $users, $user);

    //         if (!$user) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Username tidak ditemukan'
    //             ], 401);
    //         }

    //         // Cek status
    //         // dd($user['STATUS']);
    //         if ($user['STATUS'] !== "1") {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Akun tidak aktif'
    //             ], 403);
    //         }

    //         // Verifikasi password (hash dari API)
    //         // if (!Hash::check($password, $user['PASSWORD'])) {
    //         //     return response()->json([
    //         //         'status' => 'error',
    //         //         'message' => 'Username atau Password salah'
    //         //     ], 401);
    //         // }

    //         // Simpan session
    //         Session::put('is_login', true);
    //         Session::put('username', $user['USERNAME']);
    //         Session::put('role', $user['ROLE'] ?? 'siswa');
    //         Session::put('user', $user);

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'role' => $user['ROLE'] ?? 'siswa'
    //             ]);
    //         }

    //         // Redirect by role
    //         return match ($user['ROLE'] ?? 'siswa') {
    //             'admin' => redirect()->intended('admin'),
    //             'guru'  => redirect()->intended('admin'),
    //             default => redirect()->intended('admin'),
    //         };

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan sistem',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function logout(Request $request){
        // logout harus menghapus session
        $request->session()->flush();
        Auth::logout();
        return redirect('login_admin');
    }

    // user
    public function lihat_data_laporan(Request $request){
        $data_laporan = tickets_model::select('id_user', 'title', 'description', 'id_category', 'attachment', 'admin_note', 'created_at')
        ->with('users', 'category')
        ->where('id_user', Auth::user()->id_user)
        ;
        // dd($data_laporan);
        if ($request->id_category) {
            // logger()->info('ID Provinsi: ' . $request->id_provinsi);
            $p = strval($request->id_category);
            $data_laporan->where('id_category',$p);
        } 
        return DataTables::of($data_laporan)
            ->addIndexColumn()
            ->make(true);
    }
    public function kelola_laporan(){
        $activeMenu = 'kelola_laporan';
        $category = category_model::all();
        return view('user/create', ['category' => $category, 'activeMenu' => $activeMenu]);
    }
    public function tambah_data_laporan(Request $request){
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'id_category' => 'required|exists:category,id_category',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $ticket = new tickets_model();
        $ticket->id_user = Auth::user()->id_user;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->id_category = $request->id_category;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/attachments'), $filename);
            $ticket->attachment = $filename;
        }

        $ticket->save();

        return back()->with('success', 'Laporan berhasil ditambahkan.')->with('alert_timeout', 5000);
    }

}
