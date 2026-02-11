<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_gudep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function get_index() {
        return view('backend.admin.user.index');
    }

    function get_show($id) {
        $user = User::with('gudep')->find($id);
        return response()->json($user);
    }

    function post_store(Request $request) {
        // Validation and storing logic here
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'gudep_id' => 'required|exists:gudeps,id',
            
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        User_gudep::create([
            'user_id' => $user->id,
            'gudep_id' => $request->get('gudep_id'),
        ]);

        return response()->json([
            'icon' => 'success',
            'title' => 'User',
            'text' => 'Data user berhasil ditambahkan!',
        ]);

    }

    function post_update(Request $request, $id) {
        // Validation and updating logic here
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();

        return response()->json([
            'icon' => 'success',
            'title' => 'User',
            'text' => 'Data user berhasil diupdate!',
        ]);
    }

    function delete_delete(Request $request, $id) {
        // Deletion logic here
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'icon' => 'success',
            'title' => 'User',
            'text' => 'Data user berhasil dihapus!',
        ]);
    }

    function get_datatable(Request $request) {
        
        
        // $data = User::with('gudep')->get();
        // return response()->json($data);
        if ($request->ajax()) {
            $data = User::with('gudep')->get();
            return datatables()->of($data)
                ->addColumn('user_name', function($row){
                    return $row->name;
                })
                ->addColumn('user_email', function($row){
                    return $row->email;
                })
                ->addColumn('gudep_nogudep', function($row){
                    return $row->gudep[0]->nogudeppa . ' - ' . $row->gudep[0]->nogudeppi ?? '-';
                })
                ->addColumn('gudep_name', function($row){
                    return $row->gudep[0]->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    
    }
}
