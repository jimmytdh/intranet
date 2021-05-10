<h1 class="text-danger title-header">
    {{ $node->title }}
    @can('delete.node',$node)
    <span class="pull-right">
        <button class="btn btn-danger btn-sm" data-id="{{ $node->id }}" id="deleteNode">
            <i class="fa fa-times"></i>
        </button>
    </span>
    @endcan
</h1>
<?php
    $icon = "fa-file";
    $color = "primary";
?>
{{--    <ul class="tree">--}}
{{--        <li class="branch font-weight-bold">--}}
{{--            <i class="fa fa-folder-open-o"></i> {{ $node->title }} Files--}}
{{--            <ul>--}}
{{--                <li class="text-danger">--}}
{{--                    <i class="fa fa-file-pdf-o"></i> Sample File.pdf--}}
{{--                </li>--}}
{{--                <li class="text-primary">--}}
{{--                    <i class="fa fa-file-word-o"></i> Form 1022.docx--}}
{{--                </li>--}}
{{--                <li class="text-success">--}}
{{--                    <i class="fa fa-file-excel-o"></i> Attendance Format.xlsx--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--    </ul>--}}
    @if(count($files)>0)
        <ul class="tree">
            <li class="branch font-weight-bold">
                <i class="fa fa-folder-open-o"></i> Downloadable Files
                <ul>
                    @foreach($files as $f)
                    <?php
                        switch ($f->ext){
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
                    ?>
                    <li>
                        <a class="text-{{ $color }}" href="{{ route('download',$f->id) }}" target="_blank">
                        <i class="fa {{ $icon }}"></i> {{ $f->title }}.{{ $f->ext }}
                        </a>
                        @can('delete.file',$node)
                            <a href="javascript:void(0)" class="deleteItem text-danger" data-id="{{ $f->id }}" data-node="{{ $node->id }}">
                                <i class="fa fa-times"></i>
                            </a>
                        @endcan
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @else
        <span class="text-danger">
            <i class="fa fa-folder-open-o"></i> Empty Directory.
        </span>
    @endif
<hr>


@can('upload.file',$node)

    <div class="box-dashed">
        <form action="{{ route('upload', $node->id) }}" method="POST" enctype="multipart/form-data" id="submitForm">
            {{ csrf_field() }}
            <h4 class="text-success">Add File</h4>
            <div class="form-row">
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="title" placeholder="File Name" required autocomplete="off">
                </div>
                <div class="col-sm-5">
                    <input type="file" class="form-control btn" name="file" placeholder="Upload File" required accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf">
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-cloud-upload"></i> Upload File
                    </button>
                </div>
            </div>
        </form>
    </div>
@endcan

@can('add.node',$node)
    <div class="box-dashed mt-4">
        <form action="{{ route('add.node', $node->id) }}" method="POST" id="addNodeForm">
            {{ csrf_field() }}
            <h4 class="text-success">Add Folder</h4>
            <div class="form-row">
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="title" placeholder="Folder Name" required autocomplete="off">
                </div>
                <div class="col-sm-3">
                    <select name="type" class="custom-select">
                        <option>Sub</option>
                        <option>Main</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-success btn-block" type="submit">
                        <i class="fa fa-plus-square-o"></i> Add Folder
                    </button>
                </div>
            </div>
        </form>
    </div>
@endcan


