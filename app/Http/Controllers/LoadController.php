<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Node;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function index($id)
    {
        $node = Node::find($id);
        $files = File::where('node_id',$id)->orderBy('title','asc')->get();
        return view('load.files',compact('node','files'));
    }
}
