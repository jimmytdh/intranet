<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $nodes = Node::where('parent_id',0)->orderBy('title','asc')->get();
        return view('home',compact('nodes'));
    }

    static function hasChild($id)
    {
        $check = Node::where('parent_id',$id)->first();
        if($check)
            return true;
        return false;
    }

    static function getChildren($id)
    {
        $nodes = Node::where('parent_id',$id)->orderBy('title','asc')->get();
        return $nodes;
    }
}
