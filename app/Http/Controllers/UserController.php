<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\Node;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('lname','asc')->where('id','<>',Auth::id())->get();
        $nodes = Node::orderBy('parent_id','asc')->orderBy('title','asc')->get();

        if(request()->ajax()){
            $user = Approve::get();
            return datatables()->of($user)
                ->addColumn('full_name', function ($row){
                    $n = User::find($row->user_id);
                    return "$n->lname, $n->fname";
                })
                ->addColumn('node',function($row){
                    $node = Node::find($row->node_id);
                    $title = '';

                    if($node){
                        if(NodeController::hasParent($node->parent_id)){
                            $parent = Node::find($node->parent_id);
                            if(NodeController::hasParent($parent->id)){
                                $title = Node::find($parent->id)->title." &#187; ".Node::find($node->parent_id)->title." &#187; ".$node->title;
                            }else{
                                $title = Node::find($node->parent_id)->title." &#187; ".$node->title;
                            }
                        }else{
                            $title = $node->title;
                        }
                    }else{
                        $title = 'None';
                    }

                    return $title;
                })
                ->addColumn('created_at',function ($row){
                    if($row->created_at)
                        return date('M d, Y h:i A',strtotime($row->created_at));
                    return null;
                })
                ->addColumn('action',function ($row){
                    $btn = "<button class='btn btn-danger btn-sm btn-block' onclick='deleteFunc($row->id)'><i class='fa fa-trash'></i> Remove</button>";
                    return $btn;
                })
                ->rawColumns(['full_name','node','created_at','action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('users',compact('users','nodes'));
    }

    public function add(Request $req)
    {
        $data = array(
            'user_id' => $req->user,
            'node_id' => $req->folder
        );
        Approve::updateOrCreate($data);
        return 0;
    }

    public function updateUser()
    {
        $users = User::orderBy('lname','asc')->get();
        foreach($users as $u){
            $data = array(
                'fname' => ucwords(strtolower($u->fname)),
                'mname' => ucwords(strtolower($u->mname)),
                'lname' => ucwords(strtolower($u->lname)),
            );
            User::where('id',$u->id)
                ->update($data);
        }
    }

    public function destroy(Request $req)
    {
        Approve::find($req->id)->delete();
        return 0;
    }
}
