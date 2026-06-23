<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Kegiatan_partisipan;
use App\Models\Kegiatan_partisipan_anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PendaftaranController extends Controller
{
    function get_index() {
        return view('backend.user.pendaftaran.index');
    }

    function get_editData($kegiatan_id, $gudep_id) {
        $kegiatan_partisipan = Kegiatan_partisipan::where('kegiatans_id', $kegiatan_id)->where('gudeps_id', $gudep_id)->first();

        if (!$kegiatan_partisipan) {
            return '404';
        }

        $kegiatan = Kegiatan::find($kegiatan_id);

        $anggota_pa = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $kegiatan_partisipan->id)->where('is_pa', 1)->get();
        $anggota_pi = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $kegiatan_partisipan->id)->where('is_pi', 1)->get();

        
        return view('backend.user.pendaftaran.edit', compact('kegiatan', 'kegiatan_partisipan', 'anggota_pa', 'anggota_pi'));
    }

    function post_pendaftaranJoin(Request $request) {

        // $partisipan = Kegiatan_partisipan::where('kegiatans_id', $request->kegiatans_id)->where('gudeps_id', $request->gudeps_id)->count();

        // if ($partisipan>0) {
        //     return response()->json(['cekPartisipan' => 'Anda telah berpartisipasi!'], 422);
        // }

        // $validator = Validator::make($request->all(), [
        //     'kegiatans_id' => 'required',
        //     'gudeps_id' => 'required',
        // ]); 
        $validator = Validator::make($request->all(), [
            'kegiatans_id' => [
                'required',
                Rule::unique('kegiatan_partisipans')
                    ->where(function ($query) use ($request) {
                        return $query->where('gudeps_id', $request->gudeps_id);
                    }),
            ],
            'gudeps_id' => 'required',
            'file_pendaftaran' => 'required|mimes:pdf',
        ]); 

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('file_pendaftaran');
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/file_pendaftaran'), $filename);
        }

        Kegiatan_partisipan::create([
            'kegiatans_id' => $request->kegiatans_id,
            'gudeps_id' => $request->gudeps_id,
            'file_pendaftaran' => $filename,
        ]);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Partisipasi Kegiatan',
            'text' => 'Anda telah berpartisipasi!',
            'data'    => ''
        ]);
    }

    function datacek() {

        $kegiatan = Kegiatan::with('partisipans')->find(5);
        $gudep = auth()->user()->gudep->first();

        $cek = Kegiatan::whereHas('partisipans', function ($q) use ($kegiatan, $gudep) {
            $q->where('kegiatans_id', $kegiatan->id)->where('gudeps_id', $gudep->id);
        })->count();

        return response()->json(['cek' => $cek, 'kegiatan' => $kegiatan, 'gudep' => $gudep]);
    }

    function post_addAnggota(Request $request) {

        $validator = Validator::make($request->all(), [
            'kegiatans_id' => 'required',
            'kegiatan_partisipans_id' => 'required',
            'name' => 'required',
            'is_pa' => 'nullable',
            'is_pi' => 'nullable',
            'is_pembina' => 'nullable',
            'add_berkas' => 'required|mimes:pdf',
        ]); 

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('add_berkas');
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/file_pendaftaran'), $filename);
        }

        Kegiatan_partisipan_anggota::create([
            'kegiatans_id' => $request->kegiatans_id,
            'kegiatan_partisipans_id' => $request->kegiatan_partisipans_id,
            // 'gudeps_id' => $request->gudeps_id,
            'is_pa' => $request->is_pa ? true : false,
            'is_pi' => $request->is_pi ? true : false,
            'is_pembina' => $request->is_pembina == 'true' ? true : false,
            'name' => $request->name,
            'file' => $filename,
        ]);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Aggota Gudep',
            'text' => 'Data ditambahkan!',
            'data'    => ''
        ]);

        // $data = $request->all();
        // return response()->json($data);
    }

    function delete_deleteAnggota($id) {
        Kegiatan_partisipan_anggota::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Aggota Gudep',
            'text' => 'Data dihapus!',
            'data'    => ''
        ]);
    }

    function get_datatable(Request $request) { 
        if ($request->ajax()) {
            $data = Kegiatan::where('date', '>=', date('Y-m-d'))->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('date', function($row) {
                    return $row->date;
                })
                ->addColumn('title', function($row) {
                    return $row->title;
                })
                ->addColumn('gudep', function($row) {
                    return auth()->user()->gudep->first()->name;
                })
                ->addColumn('status', function($row) {
                    $gudep = auth()->user()->gudep->first();
                    $cek = Kegiatan::whereHas('partisipans', function ($q) use ($row, $gudep) {
                        $q->where('kegiatans_id', $row->id)->where('gudeps_id', $gudep->id);
                    })->count();
                    if ($cek) {
                        return 'Berpatisipasi';
                    }
                })
                ->addColumn('readiness', function($row) {

                    $kegiatan_partisipan = Kegiatan_partisipan::where('kegiatans_id', $row->id)->where('gudeps_id', auth()->user()->gudep->first()->id)->first();

                    if (!$kegiatan_partisipan) {
                        return '';
                    }

                    $anggota_pa = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $row->id)->where('is_pa', 1)->count();
                    $anggota_pi = Kegiatan_partisipan_anggota::where('kegiatan_partisipans_id', $row->id)->where('is_pi', 1)->count();

                    if ($anggota_pa > 0 && $anggota_pi > 0) {
                        $ready = '100%';
                    } else {
                        $ready = '50%';
                    }
                    return $ready;
                })
                ->addColumn('action', function($row) {
                    $gudep = auth()->user()->gudep->first();
                    $cek = Kegiatan::whereHas('partisipans', function ($q) use ($row, $gudep) {
                        $q->where('kegiatans_id', $row->id)->where('gudeps_id', $gudep->id);
                    })->count();

                    if (!$cek) {
                        return '<div style="display: inline-flex;" class="">
                                    <a href="javascript:void(0)" id="btn-partisipan" data-id="' . $row->id . '" class="btn btn-sm btn-success mr-2">Partisipan</a>
                                </div>';
                    } else {
                        return '<div style="display: inline-flex;" class="">
                                    <a href="'.url('/user/pendaftaran/edit-data/'.$row->id.'/'.$gudep->id).'" id="btn-edit" data-id="' . $row->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                                </div>';
                        
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
