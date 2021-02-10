@extends('layout.app')

@section('css')
    <link href="{{ url('/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div id="loader-wrapper" style="visibility: hidden;">
        <div id="loader"></div>
    </div>

    <div class="row">
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="text-danger">Search Documents</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table-sm table-hover table-striped table-bordered" style="width:100%;">
                        <thead>
                        <tr>
                            <th>Entry No.</th>
                            <th>Folder Name</th>
                            <th>File Name</th>
                            <th>Extension</th>
                            <th>Date Added</th>
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
@endsection

@section('js')
    <script src="{{ url('/plugins/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/search') }}",
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'folder', name: 'folder'},
                    { data: 'file', name: 'file'},
                    { data: 'ext', name: 'ext'},
                    { data: 'created_at', name: 'created_at'},
                ],
            });
        });
    </script>
@endsection
