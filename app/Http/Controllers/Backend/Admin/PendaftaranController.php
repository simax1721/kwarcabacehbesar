<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan_partisipan;
use App\Models\Kegiatan_partisipan_anggota;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    function get_index() {
        return view('backend.admin.pendaftaran.index');
    }

    function get_detail($id) {
        $kegiatan_partisipan = Kegiatan_partisipan::with(['kegiatan', 'gudep'])->findOrFail($id);

        $anggota_pa = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $kegiatan_partisipan->id)->where('is_pa', 1)->get();
        $anggota_pi = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $kegiatan_partisipan->id)->where('is_pi', 1)->get();

        return view('backend.admin.pendaftaran.detail', compact('kegiatan_partisipan', 'anggota_pa', 'anggota_pi'));
    }

    function get_datatable(Request $request) {
        if ($request->ajax()) {
            $data = Kegiatan_partisipan::with(['kegiatan', 'gudep'])->latest()->get();

            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('kegiatan', function ($row) {
                    return $row->kegiatan->title ?? '-';
                })
                ->addColumn('tanggal_kegiatan', function ($row) {
                    return ($row->kegiatan && $row->kegiatan->date) ? date('d M Y', strtotime($row->kegiatan->date)) : '-';
                })
                ->addColumn('gudep', function ($row) {
                    return $row->gudep->name ?? '-';
                })
                ->addColumn('ranting', function ($row) {
                    return $row->gudep->district_name ?? '-';
                })
                ->addColumn('file_pendaftaran', function ($row) {
                    if (!$row->file_pendaftaran) {
                        return '-';
                    }
                    return '<a href="'.url('uploads/file_pendaftaran/'.$row->file_pendaftaran).'" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-file-pdf"></i> Lihat
                            </a>';
                })
                ->addColumn('readiness', function ($row) {
                    // Minimal kuota per kelompok (peserta + pembina) agar dianggap 100% siap
                    $minAnggota = 11;

                    $anggota_pa = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $row->id)->where('is_pa', 1)->count();
                    $anggota_pi = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $row->id)->where('is_pi', 1)->count();

                    $percent_pa = min(100, round(($anggota_pa / $minAnggota) * 100));
                    $percent_pi = min(100, round(($anggota_pi / $minAnggota) * 100));

                    $percent = (int) round(($percent_pa + $percent_pi) / 2);

                    $color = $percent == 100 ? 'success' : ($percent >= 50 ? 'warning' : 'danger');

                    return '<div class="progress" style="height: 20px; min-width: 100px;" title="PA: '.$anggota_pa.'/'.$minAnggota.' • PI: '.$anggota_pi.'/'.$minAnggota.'">
                                <div class="progress-bar bg-'.$color.'" role="progressbar" style="width: '.$percent.'%;">'.$percent.'%</div>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="'.url('/admin/pendaftaran/detail/'.$row->id).'" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>';
                })
                ->rawColumns(['file_pendaftaran', 'readiness', 'action'])
                ->make(true);
        }
    }
}
