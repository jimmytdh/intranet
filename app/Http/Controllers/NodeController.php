<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function index()
    {
        $nodes = Node::where('parent_id',0)->orderBy('title','asc')->get();
        return view('folders',compact('nodes'));
    }

    public function update(Request $req)
    {
        Node::find($req->pk)
            ->update([
                'title' => $req->value
            ]);
        return 0;
    }

    public function create(Request $req,$id)
    {
        if(!self::hasFile($id)){
            $data= array(
                'parent_id' => $id,
                'title' => $req->title,
                'type' => self::nodeType($id)
            );
            if($req->type=='Main'){
                $parent_id = Node::find($id)->parent_id;
                $data['parent_id'] = $parent_id;
                $data['type'] = ($parent_id==0) ? 'main': self::nodeType($parent_id);
            }
            Node::create($data);
            return 1;
        }
        return 0;
    }

    public function hasFile($id)
    {
        return File::where('node_id',$id)->first();
    }

    public function nodeType($id)
    {
        if($id==0)
            return 'main';
        $type = Node::find($id)->type;
        if($type=='main')
            return 'sub';
        return 'none';
    }

    public function destroy(Request $req)
    {
        $id = $req->id;
        self::scanFiles($id);
        self::destroyNode($id);
        return 0;
    }

    public function scanFiles($id)
    {
        $files = File::where('node_id',$id)->get();
        foreach($files as $f)
        {
            FileController::destroy($f->id);
        }
        return 0;
    }

    public function destroyNode($id)
    {
        Node::find($id)->delete();
        return 0;
    }

    static function hasParent($id)
    {
        $check = Node::find($id);
        return $check;
    }
}
