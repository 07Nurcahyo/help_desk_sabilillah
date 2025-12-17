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
use Illuminate\Support\Facades\Storage;

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

    public function login() {
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

    public function logout(Request $request) {
        // logout harus menghapus session
        $request->session()->flush();
        Auth::logout();
        return redirect('login_admin');
    }

    // User
    // public function lihat_data_laporan(Request $request){
    //     $data_laporan = tickets_model::select('id_ticket', 'id_user', 'title', 'description', 'id_category', 'attachment', 'admin_note', 'status', 'created_at')
    //     ->with('users', 'category')
    //     ->where('id_user', Auth::user()->id_user)
    //     ;
    //     // dd($data_laporan);
    //     if ($request->id_category) {
    //         $p = strval($request->id_category);
    //         $data_laporan->where('id_category',$p);
    //     } 
    //     return DataTables::of($data_laporan)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($data_laporan) {

    //             // tombol edit (boleh semua role)
    //             $btn = '<button class="btn btn-warning btn-sm btn-edit"
    //                     data-id="'.$data_laporan->id_ticket.'">
    //                     <i class="fas fa-edit"></i></button> ';

    //             // tombol delete hanya ADMIN
    //             if (auth()->check() && auth()->user()->role === 'admin') {
    //                 $btn .= '<form class="d-inline-block" method="POST"
    //                         action="'.url('/user/'.$data_laporan->id_ticket).'"
    //                         id="delete_'.$data_laporan->id_ticket.'">'
    //                         . csrf_field()
    //                         . method_field('DELETE') .
    //                         '<button type="submit"
    //                         class="btn btn-danger btn-sm"
    //                         onclick="return deleteConfirm(\''.$data_laporan->id_ticket.'\');">
    //                         <i class="fas fa-trash-alt"></i></button></form>';
    //             }

    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    //         ->make(true);
    // }
    public function lihat_data_laporan(Request $request){
        $data_laporan = tickets_model::select(
                'id_ticket',
                'id_user',
                'title',
                'description',
                'id_category',
                'attachment',
                'admin_note',
                'status',
                'created_at'
            )
            ->with('users', 'category');

        // 🔐 jika bukan ADMIN, batasi hanya data miliknya
        if (auth()->user()->role !== 'admin') {
            $data_laporan->where('id_user', auth()->user()->id_user);
        }

        // filter kategori
        if ($request->id_category) {
            $data_laporan->where('id_category', $request->id_category);
        }

        return DataTables::of($data_laporan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data_laporan) {

                // tombol edit (semua role)
                $btn = '<button class="btn btn-warning btn-sm btn-edit"
                        data-id="'.$data_laporan->id_ticket.'">
                        <i class="fas fa-edit"></i></button> ';

                // tombol delete hanya ADMIN
                if (auth()->check() && auth()->user()->role === 'admin') {
                    $btn .= '<form class="d-inline-block" method="POST"
                            action="'.url('/user/'.$data_laporan->id_ticket).'"
                            id="delete_'.$data_laporan->id_ticket.'">'
                            . csrf_field()
                            . method_field('DELETE') .
                            '<button type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return deleteConfirm(\''.$data_laporan->id_ticket.'\');">
                            <i class="fas fa-trash-alt"></i></button></form>';
                }

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function kelola_laporan(){
        $activeMenu = 'kelola_laporan';
        $category = category_model::all();
        return view('user/create', ['category' => $category, 'activeMenu' => $activeMenu]);
    }
    public function tambah_data_laporan(Request $request) {
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
        $ticket->status = 'baru';
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $ticket->attachment = $path; // contoh: attachments/file.png
        }

        $ticket->save();

        return back()
            ->with('success', 'Laporan berhasil ditambahkan.')
            ->with('alert_timeout', 5000);
    }

    public function edit_json($id) {
        $data = tickets_model::findOrFail($id);
        return response()->json($data);
    }
    public function update_data_laporan(Request $request, $id) {
        $data = tickets_model::findOrFail($id);

        $data->id_user = $request->id_user;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->id_category = $request->id_category;
        $data->status = $request->status ?? 'baru';
        if ($request->hasFile('attachment')) {

            // hapus file lama (jika ada)
            if ($data->attachment && Storage::disk('public')->exists($data->attachment)) {
                Storage::disk('public')->delete($data->attachment);
            }

            // simpan file baru
            $path = $request->file('attachment')->store('attachments', 'public');
            $data->attachment = $path;
        }

        $data->save();

        return response()->json(['success' => true]);
    }

    // Admin
    public function kelola_laporan_admin(){
        $activeMenu = 'kelola_laporan_admin';
        // $tickets = tickets_model::all();
        // $data_laporan = tickets_model::select('id_ticket', 'id_user', 'title', 'description', 'id_category', 'attachment', 'admin_note', 'status', 'created_at')
        // ->with('users', 'category')
        // ->where('id_user', Auth::user()->id_user)
        // ;
        $category = category_model::all();
        return view('admin/kelola_data', ['category' => $category, 'activeMenu' => $activeMenu]);
    }

    public function hapus_data_laporan($id) {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $data = tickets_model::findOrFail($id);

        // hapus file kalau ada
        if ($data->attachment && file_exists(storage_path('app/'.$data->attachment))) {
            unlink(storage_path('app/'.$data->attachment));
        }

        $data->delete();

        return redirect('/user/kelola_laporan_admin')
            ->with('success', 'Data berhasil dihapus');
    }



}
