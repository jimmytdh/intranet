<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Node;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            $files = File::orderBy('title','asc')->get();
            return datatables()->of($files)
                ->addColumn('id', function ($row){
                    return str_pad($row->id,4,0, STR_PAD_LEFT);
                })
                ->addColumn('folder', function ($row){
                    return Node::find($row->node_id)->title;
                })
                ->addColumn('file', function ($row){
                    switch ($row->ext){
                        case 'ppt':
                        case 'pptx':
                        case 'pdf':
                            $color = 'danger';
                            break;
                        case 'doc':
                        case 'docx':
                            $color = 'primary';
                            break;
                        case 'xls':
                        case 'xlsx':
                            $color = 'success';
                            break;
                    }
                    $url = url('download/'.$row->id);
                    return "<a target='_blank' href='$url' class='font-weight-bold text-$color'><i class='fa fa-cloud-download'></i> $row->title</a>";
                })
                ->addColumn('ext', function ($row){
                    switch ($row->ext){
                        case 'pdf':
                            $icon = 'fa-file-pdf-o';
                            $color = 'danger';
                            break;
                        case 'doc':
                        case 'docx':
                            $icon = 'fa-file-word-o';
                            $color = 'primary';
                            break;
                        case 'xls':
                        case 'xlsx':
                            $icon = 'fa-file-excel-o';
                            $color = 'success';
                            break;
                        case 'ppt':
                        case 'pptx':
                            $icon = 'fa-file-powerpoint-o';
                            $color = 'danger';
                            break;
                    }
                    $url = url('download/'.$row->id);
                    return "<a target='_blank' href='$url' class='font-weight-bold text-$color'><i class='fa $icon'></i> $row->ext</a>";
                })
                ->addColumn('created_at', function ($row){
                    return Carbon::parse($row->created_at)->format('M d, Y h:i A');
                })
                ->rawColumns(['id','folder','file','ext','created_at'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('search');
    }
}
