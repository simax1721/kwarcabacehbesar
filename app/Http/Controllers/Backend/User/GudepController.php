<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\Gudep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GudepController extends Controller
{
    function get_index() {
        return view('backend.user.gudep.index');
    }

    function post_update(Request $request, $id) {
        // Validation and updating logic here
        $gudep = Gudep::findOrFail($id);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'email' => 'nullable|email',
            'kepsek' => 'nullable|string|max:255',
        ]);
         //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (Auth::user()->gudep[0]->id != $gudep->id) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Gugus Depan',
                'text' => 'Anda tidak memiliki akses untuk mengubah data gugus depan ini!',
            ]);
        }

        $gudep->update([
            'email' => $request->get('email') ?? $gudep->email,
            'kepsek' => $request->get('kepsek') ?? $gudep->kepsek,
        ]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Gugus Depan',
            'text' => 'Data gugus depan berhasil diperbarui!',
        ]);
    }
}
