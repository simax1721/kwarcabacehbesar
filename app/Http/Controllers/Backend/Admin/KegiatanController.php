<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    function get_index() {
        return view('backend.admin.kegiatan.index');
    }

    function get_create() {
        return view('backend.admin.kegiatan.create');
        }
        
        function get_edit($id) {
            $kegiatan = Kegiatan::find($id);
            return view('backend.admin.kegiatan.edit', compact('kegiatan'));
    }

    function post_store(Request $request) {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('thumbnail');
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnails'), $filename);
        }


        Kegiatan::create([
            'title' => $request->get('title'),
            'date' => $request->get('date') ?? null,
            'thumbnail' => $filename ?? null,
            'description' => $request->get('description') ?? null,
        ]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Kegiatan',
            'text' => 'Data kegiatan berhasil ditambahkan!',
        ]);
        
    }

    function post_update(Request $request, $id) {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kegiatan = Kegiatan::find($id);

        $file = $request->file('thumbnail');
        if ($file) {

            $filename = basename($kegiatan->thumbnail) ?? null;

            if (($filename != null) && file_exists(public_path('uploads/thumbnail/' . $filename))) {
                unlink(public_path('uploads/thumbnail/' . $filename));
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/thumbnails'), $filename);

            $kegiatan->update([
                'thumbnail' => $filename
            ]);
        }

        $kegiatan->update([
            'title' => $request->get('title'),
            'date' => $request->get('date') ?? null,
            'description' => $request->get('description') ?? null,
        ]);
            
            

         return response()->json([
            'icon' => 'success',
            'title' => 'Kegiatan',
            'text' => 'Data kegiatan berhasil diperbaharui!',
        ]);


    }



    function get_datatable(Request $request) {
        // $data = Kegiatan::all();
        // return response()->json($data);
        if ($request->ajax()) {
            $data = Kegiatan::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('date', function($row) {
                    return $row->date ? date('d M Y', strtotime($row->date)) : '-';
                })
                ->addColumn('thumbnail', function($row) {
                    if ($row->thumbnail) {
                        return '<img src="' . $row->thumbnail . '" alt="Thumbnail" width="200">';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($row) {
                   return '<div style="display: inline-flex;" class="">
                            <a href="'.url('/admin/data/kegiatan/edit/'.$row->id).'" id="btn-edit" data-id="' . $row->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="'.url('/admin/data/kegiatan/edit/'.$row->id).'" id="btn-delete" data-id="' . $row->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['thumbnail', 'action'])
                ->make(true);
        }
    }
}
