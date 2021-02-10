@extends('layout.app')

@section('css')
    <style>
        .box-dashed {
            border: 2px dashed #d28079;
            padding: 10px 20px;
        }
        #folder li {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div id="loader-wrapper" style="visibility: hidden;">
        <div id="loader"></div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-body">
                    <ul id="folder">
                        @foreach($nodes as $n)
                            <?php $check = \App\Http\Controllers\HomeController::hasChild($n->id); ?>
                            @if($check)
                                <li><a href="#">{{ $n->title }}</a>
                                    <ul>
                                        <?php $node1 = \App\Http\Controllers\HomeController::getChildren($n->id); ?>
                                        @foreach($node1 as $n1)
                                            <?php $c1 = \App\Http\Controllers\HomeController::hasChild($n1->id); ?>
                                            @if($c1)
                                                <li>{{ $n1->title }}
                                                    <ul>
                                                        <?php $node2 = \App\Http\Controllers\HomeController::getChildren($n1->id); ?>
                                                        @foreach($node2 as $n2)
                                                            <li class="items" data-id="{{ $n2->id }}">{{ $n2->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="items" data-id="{{ $n1->id }}">{{ $n1->title }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="items" data-id="{{ $n->id }}">{{ $n->title }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-body load_content pt-2 pl-4 pr-4 pb-3">
                    <h1 class="text-danger title-header">Welcome to Intranet</h1>
                    <p>
                        An INTRANET (Document Management System) is a web-based information system that share information, downloadable forms, operational manuals, and other documents within the organization, usually to the exclusion of access by outsiders.
                    </p>
                    <p>
                        Document management, often referred to as Document Management Systems (DMS), is the use of a computer system and software to store, manage and track electronic documents and electronic images of paper-based information captured through the use of a document scanner.
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('script.item')
    <script>

    </script>
@endsection
