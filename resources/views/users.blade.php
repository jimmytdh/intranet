@extends('layout.app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="loader-wrapper" style="visibility: hidden;">
        <div id="loader"></div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-danger">
                <form method="post" action="{{ route('add.access') }}" id="accessForm">
                <div class="box-header">
                    <h3 class="text-danger">Add Access</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Select User</label>
                        <select class="custom-select" name="user">
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->lname }}, {{ $u->fname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Folder</label>
                        <select class="custom-select" name="folder">
                            @foreach($nodes as $n)
                                @if(\App\Http\Controllers\NodeController::hasParent($n->parent_id))
                                    <?php $parent = \App\Models\Node::find($n->parent_id); ?>
                                    @if(\App\Http\Controllers\NodeController::hasParent($parent->parent_id))
                                            <option value="{{ $n->id }}">{{ \App\Models\Node::find($parent->parent_id)->title }} &#187; {{ \App\Models\Node::find($n->parent_id)->title }} &#187; {{ $n->title }}</option>
                                    @else
                                            <option value="{{ $n->id }}">{{ \App\Models\Node::find($n->parent_id)->title }} &#187; {{ $n->title }}</option>
                                    @endif
                                @else
                                    <option value="{{ $n->id }}">{{ $n->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-block btn-success">
                        <i class="fa fa-save"></i> Add
                    </button>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="text-danger">Users with Access</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table-sm table-hover table-striped table-bordered" style="width:100%;">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Folder Name</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/users') }}",
                columns: [
                    { data: 'full_name', name: 'full_name'},
                    { data: 'node', name: 'node'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action'},
                ],
            });
        });

        $("#accessForm").submit(function (e) {
            e.preventDefault();
            var data = new FormData(this);
            $("#loader-wrapper").css("visibility","visible");
            $.ajax({
                url: $(this).attr('action'),
                method: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function (res) {
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnDraw(false);
                    setTimeout(function () {
                        $("#loader-wrapper").css("visibility","hidden");
                    },500);
                }
            });
        });

        function deleteFunc(id) {
            if(confirm("Are you sure you want to delete this access?") == true) {
                var id = id;
                $.ajax({
                    type: "POST",
                    url: "{{ url("users/destroy") }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res) {
                        var oTable = $('#dataTable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
    </script>
@endsection
