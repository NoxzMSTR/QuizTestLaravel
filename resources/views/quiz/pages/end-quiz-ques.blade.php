@extends('quiz.layout.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$quiz->title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quiz</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <form id="addAttemptedQQ" action="{{route('saveAttemptedQuizQues',[$quiz])}}" method="post">
                @csrf
                <div class="row">
                
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Attempting Quiz</h3>
                                    <div id="duration" class="card-tools">
                                        Duration: {{$quiz->duration}}
                                    </div>
                                </div>
                                <div class="card-body p-4 text-center">
                                    <h2><strong>{{$testAverage}}</strong></h2>
                                    <h4>{{$scored}}</h4>
                                    <h6>{{$status}}</h6>
                                    <a href="{{route('subscribe',[$quiz->id])}}" class="btn btn-info">Subscribe Quiz</a>
                                    <a href="{{route('dashboard')}}" class="btn btn-dark">Go to dashboard</a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('js')
<script>
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
<script>
    $(document).ready(function() {
        $('.repeater').repeater({
            // (Required if there is a nested repeater)
            // Specify the configuration of the nested repeaters.
            // Nested configuration follows the same format as the base configuration,
            // supporting options "defaultValues", "show", "hide", etc.
            // Nested repeaters additionally require a "selector" field.
            repeaters: [{
                // (Required)
                // Specify the jQuery selector for this nested repeater
                selector: '.inner-repeater'
            }]
        });
    });
</script>

@endsection