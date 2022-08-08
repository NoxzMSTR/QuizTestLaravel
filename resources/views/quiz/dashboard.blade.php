@extends('quiz.layout.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>150</h3>

                                <p>Total Quizzes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <!-- ./col -->
                    {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> --}}
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>44</h3>

                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <!-- ./col -->
                    {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> --}}
                    <!-- ./col -->
                </div>
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
                                            <td><a href="{{route('startQuiz',[$quiz->id])}}" class="btn btn-info">Start Quiz</a></td>
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
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body ">
                    <form action="" class="row w-100 repeater">
                        <div class="form-group col-sm-12 col-xl-6">
                            <label for="exampleInputBorder">Quiz Title</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder"
                                placeholder="Enter Quiz Title...">
                        </div>
                        <div class="form-group col-sm-12 col-xl-6">
                            <label for="exampleSelectBorder">Duration</label>
                            <select class="custom-select form-control-border" id="exampleSelectBorder">
                                <option>Select Duration</option>
                                <option value="00:15:00">00:15:00</option>
                                <option value="00:30:00">00:30:00</option>
                                <option value="01:00:00">01:00:00</option>
                                <option value="01:15:00">01:15:00</option>
                                <option value="01:30:00">01:30:00</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <div data-repeater-list="outer-list">
                                <div data-repeater-item>
                                    <div class="row">
                                        <label for="" class="w-100">Quiz Question</label>
                                        <div class="form-group col-sm-12 col-xl-6">
                                            <input class="form-control" type="text" name="text-input" value="A" />
                                        </div>
                                        <div class="form-group col-sm-12 col-xl-6">
                                            <input class="btn btn-danger" data-repeater-delete type="button" value="Delete" />
                                        </div>
                                    </div>
                                
                                    
                                    <!-- innner repeater -->
                                    <div class="card direct-chat direct-chat-primary">
                                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                                          <h3 class="card-title">Quiz Options</h3>
                          
                                          <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                              <i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                              <i class="fas fa-times"></i>
                                            </button>
                                          </div>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="inner-repeater">
                                                <div data-repeater-list="inner-list">
                                                    <div data-repeater-item>
                                                        <div class="row">
                                                            <div class="form-group col-sm-12 col-xl-6">
                                                                <input class="form-control" type="text" name="text-input" value="B" />
                                                            </div>
                                                            <div class="form-group col-sm-12 col-xl-6">
                                                                <input class="btn btn-danger" data-repeater-delete type="button" value="Delete" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="btn btn-success" data-repeater-create type="button" value="Add Option" />
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <!-- /.card-footer-->
                                      </div>
                                  

                                </div>
                            </div>
                        </div>
                        <input class="btn btn-success" data-repeater-create type="button" value="Add Question" />
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
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
