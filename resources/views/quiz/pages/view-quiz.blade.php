@extends('quiz.layout.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View Quiz</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Quiz</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12">

                        <!-- TO DO List -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    Quiz List
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#addQuiz"><i class="fas fa-plus"></i> Add Quiz</button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Quiz Title</th>
                                            <th>Duration</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getQuizzes as $quiz)
                                        <tr>
                                            <td>{{$quiz->title}}</td>
                                            <td>{{$quiz->duration}}
                                            </td>
                                            <td><a href="{{route('viewQuizQuestions',[$quiz->id])}}" class="btn btn-info">Add/View Questions</a></td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">

                            </div>
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="addQuiz">
        <form id="addQuizForm" action="{{ route('addQuiz') }}" method="POST" class="row w-100 repeater">
            @csrf
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="overlay showLoader" style="display: none">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Quiz</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body row">
                        <div class="form-group col-sm-12 col-xl-6">
                            <label for="exampleInputBorder">Quiz Title</label>
                            <input name="title" type="text" class="form-control form-control-border"
                                id="exampleInputBorder" placeholder="Enter Quiz Title...">
                        </div>
                        <div class="form-group col-sm-12 col-xl-6">
                            <label for="exampleSelectBorder">Duration</label>
                            <select name="duration" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="">Select Duration</option>
                                <option value="00:15:00">00:15:00</option>
                                <option value="00:30:00">00:30:00</option>
                                <option value="01:00:00">01:00:00</option>
                                <option value="01:15:00">01:15:00</option>
                                <option value="01:30:00">01:30:00</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-xl-12">
                            <label for="exampleSelectBorder">Quiz Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3" placeholder="Enter Short Description.."></textarea>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="addQuizBtn" type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </div>
        </form>
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
        $("#addQuizForm").submit(function(e) {
            e.preventDefault();
        }).validate({
            rules: {
                title: {
                    required: true
                },
                duration: {
                    required: true
                }
            },
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
                    formData[0].reset();
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
