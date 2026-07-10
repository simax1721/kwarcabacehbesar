<?php

namespace App\Http\Controllers\Frondend;

use App\Http\Controllers\Controller;
use App\Models\Gudep;
use App\Models\Kegiatan;
use App\Models\Ranting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    function get_index() {
        $totalGudep = Gudep::count();
        $totalRanting = Ranting::count();
        $totalKegiatan = Kegiatan::count();
        $kegiatanTerbaru = Kegiatan::latest('date')->take(3)->get();

        return view('frondend.home', compact('totalGudep', 'totalRanting', 'totalKegiatan', 'kegiatanTerbaru'));
    }

    function get_gugusDepan() {
        $rantings = Ranting::all();
        return view('frondend.gugusdepan', compact('rantings'));
    }

    function get_kegiatan() {
        $kegiatans = Kegiatan::orderByDesc('date')->paginate(9);
        return view('frondend.kegiatan', compact('kegiatans'));
    }

    function get_kegiatanDetail($id) {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatanLainnya = Kegiatan::where('id', '!=', $id)->orderByDesc('date')->take(3)->get();

        return view('frondend.kegiatandetail', compact('kegiatan', 'kegiatanLainnya'));
    }

    function get_strukturOrganisasi() {
        return view('frondend.strukturorganisasi');
    }

    function get_gugusDepanView($id) {
        $gudep = Gudep::findOrFail($id);
        return view('frondend.gugusdepanview', compact('gudep'));
    }

    public function get_gugusDepanDatatable(Request $request)
    {
        if ($request->ajax()) {

            $query = Gudep::query();

            // 🔍 Filter keyword (nama / alamat / kepala sekolah)
            if ($request->filled('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('address', 'like', '%'.$request->keyword.'%')
                    ->orWhere('kepsek', 'like', '%'.$request->keyword.'%');
                });
            }

            // 🔍 Filter ranting
            if ($request->filled('ranting')) {
                $query->where('district_code', $request->ranting);
                // sesuaikan nama kolom jika berbeda
            }

            // 🔍 Filter jenjang
            if ($request->filled('grade')) {
                $query->where('grade', $request->grade);
            }

            // 🔍 Filter status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('nogudep', function ($row) {
                    return ($row->nogudeppa || $row->nogudeppi)
                        ? $row->nogudeppa.' - '.$row->nogudeppi
                        : '-';
                })

                ->addColumn('namagudep', function ($row) {
                    return '<a class="text-primary" href="/gugus-depan-view/'.$row->id.'">'.$row->name.'</a>';
                    // return $row->name;
                })
                ->addColumn('jenjang', fn ($row) => $row->grade)

                ->addColumn('status', function ($row) {
                    return match ($row->status) {
                        'N' => 'Negeri',
                        'S' => 'Swasta',
                        default => '-'
                    };
                })

                ->addColumn('ranting', fn ($row) => $row->district_name)
                ->addColumn('kepsek', fn ($row) => $row->kepsek ?? '-')
                ->addColumn('address', fn ($row) => $row->address ?? '-')
                ->rawColumns(['namagudep'])
                ->make(true);
        }

    }

    
}
