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
        $gudep = Gudep::findOrFail($id);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(),[
            'email' => 'nullable|email',
            'kepsek' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
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

        $data = [
            'email' => $request->get('email') ?? $gudep->email,
            'kepsek' => $request->get('kepsek') ?? $gudep->kepsek,
        ];

        $file = $request->file('image');
        if ($file) {
            $oldFilename = $gudep->getRawOriginal('image');
            if ($oldFilename && file_exists(public_path('uploads/gudep/' . $oldFilename))) {
                unlink(public_path('uploads/gudep/' . $oldFilename));
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gudep'), $filename);

            $data['image'] = $filename;
        }

        $gudep->update($data);

        return response()->json([
            'icon' => 'success',
            'title' => 'Gugus Depan',
            'text' => 'Data gugus depan berhasil diperbarui!',
        ]);
    }
}
