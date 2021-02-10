@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-editable/css/style.css') }}">
    <style>
        .edit { cursor: pointer; }
    </style>
@endsection

@section('content')
    <div id="loader-wrapper" style="visibility: hidden;">
        <div id="loader"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header">
                    <h2 class="text-danger">Manage Folders</h2>
                </div>
                <div class="box-body">
                    <ul class="tree">
                        @foreach($nodes as $n)
                            <?php $check = \App\Http\Controllers\HomeController::hasChild($n->id); ?>
                            @if($check)
                                <li><i class="fa fa-folder-open mr-1"></i> <span class="edit" data-pk="{{ $n->id }}" data-title="Update Name">{{ $n->title }}</span></a>
                                    <ul class="tree">
                                        <?php $node1 = \App\Http\Controllers\HomeController::getChildren($n->id); ?>
                                        @foreach($node1 as $n1)
                                            <?php $c1 = \App\Http\Controllers\HomeController::hasChild($n1->id); ?>
                                            @if($c1)
                                                <li><i class="fa fa-folder-open mr-1"></i><span class="edit" data-pk="{{ $n1->id }}" data-title="Update Name">{{ $n1->title }}</span>
                                                    <ul>
                                                        <?php $node2 = \App\Http\Controllers\HomeController::getChildren($n1->id); ?>
                                                        @foreach($node2 as $n2)
                                                            <li data-id="{{ $n2->id }}"><span class="edit" data-pk="{{ $n2->id }}" data-title="Update Name">{{ $n2->title }}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><span class="edit" data-pk="{{ $n1->id }}" data-title="Update Name">{{ $n1->title }}</span></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><i class="fa fa-folder mr-1"></i><span class="edit" data-pk="{{ $n->id }}" data-title="Update Name">{{ $n->title }}</span></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="box-footer">
                    <form action="{{ route('add.node', 0) }}" method="POST" id="addNodeForm" class="form-inline">
                        {{ csrf_field() }}
                        <div class="form-group mr-2">
                            <label class="mr-2"></label>
                        </div>
                        <div class="form-group mr-2">
                            <input type="text" class="form-control" name="title" placeholder="Folder Name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-plus-square-o"></i> Add Folder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/plugins/bootstrap-editable/js/bootstrap-editable.js') }}"></script>
    <script>
        $('.edit').editable({
            url: "{{ route('update.folder') }}",
            type: 'text',
            emptytext: 'N/A'
        });

        $("#addNodeForm").submit(function(e){
            e.preventDefault();
            $("#loader-wrapper").css("visibility","visible");
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log(res);
                    if(res==0){
                        alert("Unable to create folder. Current folder is not empty!");
                    }else{
                        window.location.reload();
                    }
                    $("#loader-wrapper").css("visibility","hidden");
                }
            })
        });
    </script>
@endsection
