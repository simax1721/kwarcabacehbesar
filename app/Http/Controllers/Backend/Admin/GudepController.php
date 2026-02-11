<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gudep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GudepController extends Controller
{
    function get_index() {
        return view('backend.admin.gudep.index');
    }

    function get_create() {
        return view('backend.admin.gudep.create');
    }

    function get_edit($id) {
        $gudep = Gudep::findOrFail($id);
        return view('backend.admin.gudep.edit', compact('gudep'));
    }

    function post_index(Request $request) {
        $validator = Validator::make($request->all(),[
            'npsn' => 'nullable|string|unique:gudeps,npsn',
            'nogudeppa' => 'nullable|string',
            'nogudeppi' => 'nullable|string',
            'email' => 'nullable|email',
            'kepsek' => 'nullable|string',
            'name' => 'required|string',
            'email' => 'nullable|string',
            'grade' => 'nullable|string',
            'status' => 'nullable|string',
            'accreditation' => 'nullable|string',
            'address' => 'nullable|string',
            'province_code' => 'nullable|string',
            'province_name' => 'nullable|string',
            'regency_code' => 'nullable|string',
            'regency_name' => 'nullable|string',
            'district_code' => 'nullable|string',
            'district_name' => 'nullable|string',
            'lang' => 'nullable',
            'long' => 'nullable',
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Gudep::create([
            'npsn' => $request->get('npsn') ?? null,
            'nogudeppa' => $request->get('nogudeppa') ?? null,
            'nogudeppi' => $request->get('nogudeppi') ?? null,
            'email' => $request->get('email') ?? null,
            'kepsek' => $request->get('kepsek') ?? null,
            'name' => $request->get('name') ?? null,
            'grade' => $request->get('grade') ?? null,
            'status' => $request->get('status') ?? null,
            'accreditation' => $request->get('accreditation') ?? null,
            'address' => $request->get('address') ?? null,
            'province_code' => $request->get('province_code') ?? null,
            'province_name' => $request->get('province_name') ?? null,
            'regency_code' => $request->get('regency_code') ?? null,
            'regency_name' => $request->get('regency_name') ?? null,
            'district_code' => $request->get('district_code') ?? null,
            'district_name' => $request->get('district_name') ?? null,
            'lang' => $request->get('lang') ?? null,
            'long' => $request->get('long') ?? null,
        ]);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Gudep',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function post_update(Request $request) {
        $validator = Validator::make($request->all(),[
            'id' => 'required|exists:gudeps,id',
            'nogudeppa' => 'nullable|string',
            'nogudeppi' => 'nullable|string',
            'email' => 'nullable|email',
            'kepsek' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $gudep = Gudep::findOrFail($request->get('id'));

        $gudep->update([
            'nogudeppa' => $request->get('nogudeppa') ?? null,
            'nogudeppi' => $request->get('nogudeppi') ?? null,
            'email' => $request->get('email') ?? null,
            'kepsek' => $request->get('kepsek') ?? null,
            'address' => $request->get('address') ?? null,
        ]);

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Gudep',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_index($id) {
        $gudep = Gudep::findOrFail($id);
        $gudep->delete();

        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Gudep',
            'text' => 'Data Berhasil Dihapus!',
            'data'    => ''
        ]);
    }


    function get_datasekolah(Request $request)
    {
        $response = Http::withHeaders([
            'x-api-co-id' => env('API_CO_ID_KEY'), // simpan di .env
        ])->get(
            'https://use.api.co.id/regional/indonesia/schools',
            [
                'regency_code' => '1106',
                'page' => $request->get('page') ?? 1,
                'district_code' => $request->get('district_code') ?? '',
                'district_name' => $request->get('district_name') ?? '',
                'name' => $request->get('name'),
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal mengambil data kecamatan'
            ], 500);
        }

        

        return $response->json();
    }

    function get_detailsekolah(Request $request) {
        $response = Http::withHeaders([
            'x-api-co-id' => env('API_CO_ID_KEY'), // simpan di .env
        ])->get(
            'https://use.api.co.id/regional/indonesia/schools',
            [
                'npsn' => $request->get('npsn'),
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal mengambil data sekolah'
            ], 500);
        }

        return $response->json();
    }

    function get_datatable(Request $request) {
        $data = Gudep::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('nogudep', function ($data) {
                    if ($data->nogudeppa == null && $data->nogudeppi == null) {
                        return '';
                    }
                    return $data->nogudeppa . ' - ' . $data->nogudeppi;
                })
                ->addColumn('namagudep', function ($data) {
                    return $data->name;
                })
                ->addColumn('jenjang', function ($data) {
                    return $data->grade;
                })
                ->addColumn('ranting', function ($data) {
                    return $data->district_name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="'.url('admin/data/gudep/edit/'.$data->id).'" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function get_datakegudep(Request $request) {
        $search = $request->get('q');

        $query = Gudep::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('nogudeppa', 'like', '%' . $search . '%')
                  ->orWhere('nogudeppi', 'like', '%' . $search . '%');
        }

        $gudeps = $query->limit(10)->get();

        $results = [];
        foreach ($gudeps as $gudep) {
            $results[] = [
                'id' => $gudep->id,
                'text' => $gudep->nogudeppa . ' - ' . $gudep->nogudeppi . ' - ' . $gudep->name,
            ];
        }

        return response()->json($results);
    }
}
