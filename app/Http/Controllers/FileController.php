<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function store(Request $req,$id)
    {
        $date = date('ymdHis');
        if($req->hasFile('file'))
        {
            $ext = $req->file('file')->getClientOriginalExtension();
            $file_name = "$date-$id.$ext";
            $req->file('file')->storeAs('upload',$file_name);

            $data = array(
                'node_id' => $id,
                'title' => $req->title,
                'ext' => $ext,
                'path' => $file_name
            );
            File::create($data);
        }

        return redirect()->back()->with('id',$id);
    }

    public function download($id)
    {
        $file = File::find($id);
        $path = storage_path()."/app/upload/".$file->path;
        if (file_exists($path)) {
            return Response::download($path,$file->title);
        }
        return 'error';
    }

    static function destroy($id)
    {
        $file = File::find($id);
        $path = storage_path()."\app\upload/".$file->path;
        if (file_exists($path)) {
            unlink($path);
        }
        $file->delete();
        return 0;
    }
}
