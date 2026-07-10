<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gudep;
use App\Models\Kegiatan;
use App\Models\Kegiatan_partisipan;
use App\Models\Ranting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    function get_index() {
        return redirect()->route('admin.get_login');
    }

    function get_dashboard() {
        if (Auth::guard('admin')->check()) {
            $totalRanting = Ranting::count();
            $totalGudep = Gudep::count();
            $totalUser = User::count();
            $totalKegiatan = Kegiatan::count();
            $totalPartisipan = Kegiatan_partisipan::count();

            $kegiatanMendatang = Kegiatan::where('date', '>=', date('Y-m-d'))->orderBy('date')->take(5)->get();
            $partisipanTerbaru = Kegiatan_partisipan::with(['kegiatan', 'gudep'])->latest()->take(5)->get();

            return view('backend.admin.dashboard', compact(
                'totalRanting',
                'totalGudep',
                'totalUser',
                'totalKegiatan',
                'totalPartisipan',
                'kegiatanMendatang',
                'partisipanTerbaru'
            ));
        } else {
            return redirect('admin/login');
        }
    }

    function get_login() {

        if (Auth::guard('admin')->check()) {
            return redirect('admin/dashboard');
        } else {
            return view('auth.loginadmin');
        }
    }

    function post_login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect('admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
        return redirect('admin/login');
    }
}
