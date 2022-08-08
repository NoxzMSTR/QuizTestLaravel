@extends('quiz.layout.master') @section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quiz Questions</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quiz Questions</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- small box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <strong>Title: </strong>{{ $quiz->title }}
                            </h3>
                            <div class="card-tools">
                                <strong>Duration: </strong>{{ $quiz->duration }}
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong>Short Description:
                            </strong>{{ $quiz->short_description ?: 'None' }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <form id="addQuizQuesForm" action="{{route('addQuizQuestions',[$quiz->id])}}" class="w-100 ">
                        @csrf
                        <!-- TO DO List -->
                        <div class="card repeater">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i> Quiz Questions
                                </h3>

                                <div class="card-tools">
                                    <input class="btn btn-success" data-repeater-create type="button" value="Add Question" />
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="col-12">
                                    <div data-repeater-list="outer_list">
                                        @forelse ($quizQues as $ques)
                                            @include('quiz.pages.includes.getQuizQues')
                                        @empty
                                            @include('quiz.pages.includes.getQuizQuesStatic')
                                        @endforelse
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-right"> Save </button>
                            </div>
                    </form>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- The Modal -->
@endsection @section('js')
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
<script>
        // $('#addQuizQuesForm').validate();
        // $('[name$="quiz_question"]').each(function() {
        //     $(this).rules('add', {
        //         required: true,
        //         messages: {
        //             required: "Please enter an address"
        //         }
        //     });
        // });
        // $('[name$="type"]').each(function() {
        //     $(this).rules('add', {
        //         required: true,
        //         messages: {
        //             required: "Please enter an address"
        //         }
        //     });
        // });
        // $('[name$="quiz_answer"]').each(function() {
        //     $(this).rules('add', {
        //         required: true,
        //         messages: {
        //             required: "Please enter an address"
        //         }
        //     });
        // });
       
       $("#addQuizQuesForm").submit(function(e) {
            console.log('click');
            e.preventDefault();
        }).validate({
            submitHandler: function(form) {
                var formData = $(form);
                var url = formData.attr('action')
                //submit via ajax
                ajaxSendData(url, 'POST', formData.serialize(), '').then(function(response) {
                    console.log("Good: ", response);
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                }).catch(function(error) {
                    if (error.responseJSON) {
                        Toast.fire({
                        icon: 'error',
                        title: error.responseJSON.message
                    })
                    }
                  
                });
                return false; //This doesn't prevent the form from submitting.
            }
        });
</script>
@endsection