<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ranting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RantingController extends Controller
{
    function get_index() {
        return view('backend.admin.ranting.index');
    }

    function get_create() {
        return view('backend.admin.ranting.create');
    }

    function get_edit($id) {
        $ranting = Ranting::where('code', $id)->firstOrFail();
        return view('backend.admin.ranting.edit', compact('ranting'));
    }

    function post_store(Request $request) {
        
        return 0;
    }

    function post_update(Request $request, $id) {
        
        $validator = Validator::make($request->all(),[
            'nokwaranting' => 'nullable|string|unique:rantings,nokwaranting,'.$request->code.',code',
            'name' => 'required|string',
            'ketuakwaranting' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $ranting = Ranting::findOrFail($request->code);
        
        $ranting->update([
            'nokwaranting' => $request->get('nokwaranting') ?? $ranting->nokwaranting,
            'name' => $request->get('name') ?? $ranting->name,
            'ketuakwaranting' => $request->get('ketuakwaranting') ?? $ranting->ketuakwaranting,
            'address' => $request->get('address') ?? $ranting->address,
        ]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Ranting',
            'text' => 'Data ranting berhasil diperbarui!',
        ]);
            
    }

    function get_datakecamatan(Request $request)
    {
        $response = Http::withHeaders([
            'x-api-co-id' => env('API_CO_ID_KEY'), // simpan di .env
        ])->get(
            'https://use.api.co.id/regional/indonesia/districts',
            [
                'regency_code' => '1106',
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

    function get_datatable(Request $request) {
        if ($request->ajax()) {
            $query = Ranting::get();
            return DataTables::of($query)
                // ->addIndexColumn()
                ->addColumn('nokwaranting', fn ($row) => $row->nokwaranting ?? '')
                ->addColumn('name', fn ($row) => $row->name)
                ->addColumn('ketuakwaranting', fn ($row) => $row->ketuakwaranting ?? '')
                ->addColumn('total_gudep', function ($row) {
                    return $row->gudeps->count();
                    // return $row->gudep->count();
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.url('admin/data/ranting/edit/' . $row->code).'" class="btn btn-sm btn-primary mr-1">Edit</a>';
                    $btn .= '<a href="'.url('admin.get_ranting_delete'. $row->code).'" class="btn btn-sm btn-danger">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    function get_show($id) {
        $ranting = Ranting::where('code', $id)->firstOrFail();
        return response()->json($ranting);
    }
    
    function get_datakecamatanimportcepat(Request $request)
    {
        $response = Http::withHeaders([
            'x-api-co-id' => env('API_CO_ID_KEY'), // simpan di .env
        ])->get(
            'https://use.api.co.id/regional/indonesia/districts',
            [
                'regency_code' => '1106',
                'name' => $request->get('name'),
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal mengambil data kecamatan'
            ], 500);
        }

        $data = $response['data'];

        foreach ($data as $item) {
            Ranting::updateOrCreate(
                [
                    'code' => $item['code'],
                ],
                [
                    'name' => $item['name'],
                    'nokwaranting' => null,
                    'ketuakwaranting' => null,
                    'regency_code' => $item['regency_code'],
                    'regency' => $item['regency'],
                    'address' => null,
                ]
            );
        }

        // return response()->json($data);
        return response()->json([
            'message' => 'Import data kecamatan berhasil!'
        ]);
    }

}
