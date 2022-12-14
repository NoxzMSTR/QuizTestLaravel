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
            <form id="addAttemptedQQ" action="{{route('saveAttemptedQuizQues',[$quizAtmpt])}}" method="post">
                @csrf
                <div class="row">
                
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Attempting Quiz</h3>
                                    <div id="duration" class="card-tools">
                                        Duration: {{$currentElaps}}
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="bs-stepper">
                                        <div class="bs-stepper-header" role="tablist">
                                            <!-- your steps here -->
                                            @foreach ($quiz->quizQues()->get() as $key => $item)
                                            <div class="step" data-target="#quiz-part-{{$key}}">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="quiz-part-{{$key}}" id="quiz-part-{{$key}}-trigger">
                                                    <span class="bs-stepper-circle">{{$key + 1}}</span>

                                                </button>
                                            </div>
                                            @if ($quiz->quizQues()->get()->count() !== $key + 1)
                                            <div class="line"></div>
                                            @endif
                                            @endforeach
                                            <div class="line"></div>
                                            <div class="step" data-target="#quiz-part-{{$quiz->quizQues()->get()->count()+1}}">
                                                <button type="button" class="step-trigger" role="tab" aria-controls="quiz-part-{{$key}}" id="quiz-part-{{$key}}-trigger">
                                                    <span class="bs-stepper-circle">{{$quiz->quizQues()->get()->count()+1}}</span>
                                                    <span class="bs-stepper-label">Review</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <!-- your steps content here -->
                                            @foreach ($quiz->quizQues()->get() as $key => $item)
                                            <div id="quiz-part-{{$key}}" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                                <div class="form-group">
                                                    <label for="exampleInputFile" class="title">Question: {{$item->quiz_question}}</label>
                                                    <input hidden type="text" class="form-check-input" name="ques[]" value="{{$item->id}}">
                                                    @foreach (explode(',',$item->quiz_answer) as $key2 => $opt)
                                                    <div class="input-group">
                                                        @if ($item->type == 'single')
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="single[{{$item->id}}]" value="{{$key2}}">{{$opt}}
                                                            </label>
                                                        </div>
                                                        @else
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="multi[{{$item->id}}][]" value="{{$key2}}">{{$opt}}
                                                            </label>
                                                        </div>
                                                        @endif

                                                    </div>
                                                    @endforeach
                                                </div>

                                                @if($key !== 0 )
                                                <button type="button" class="btn btn-primary validateP">Previous</button>
                                                <button type="button"  class="btn btn-primary validateN">Next</button>
                                                @else
                                                <button type="button"  class="btn btn-primary validateN">Next</button>
                                                @endif

                                            </div>
                                            @endforeach
                                            <div id="quiz-part-{{$quiz->quizQues()->get()->count()+1}}" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                                <div class="review">
                                                    @foreach ($quiz->quizQues()->get() as $key => $item)
                                                    <label for="exampleInputFile" class="title">Question: {{$item->quiz_question}}</label>
                                                    <div class="ques_{{$item->id}}"></div>
                                                    <br>
                                                    @endforeach
                                                </div>
                                                <button type="button"  class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
    $('.validateN').on('click', function() {
        var getInputs = $('.form-group').parent().eq(stepper._currentIndex).find('input:checked');
        var getInputsType = getInputs.attr('type');
        if (getInputs.is(":checked") == false) {
            Toast.fire({
                icon: 'error',
                title: 'Please select an answer to continue'
            });
        }else{
            addReview(stepper._currentIndex) 
            stepper.next();
        }
    })
    $('.validateP').on('click', function() {
        var getInputs = $('.form-group').parent().eq(stepper._currentIndex).find('input:checked');
        var getInputsType = getInputs.attr('type');
        if (getInputs.is(":checked") == false) {
            Toast.fire({
                icon: 'error',
                title: 'Please select an answer to continue'
            });
        }else{
            addReview(stepper._currentIndex) 
            stepper.previous();
        }
    })
    function addReview(index) {
        var getInputs = $('.form-group').parent().eq(index).find('input:checked');
        var getID = $('.form-group').parent().eq(index).find('input:text');
        var getInputsType = getInputs.attr('type');
        if (getInputsType == 'radio') {
            $('.ques_'+getID.val()).html('Selected Answer: '+getInputs.parent().text());
        }else{
            getInputs.each(function(i, obj) {
                if (i == 0) {
                    $('.ques_'+getID.val()).html('Selected Answer: '+$(obj).parent().text());
                } else {
                    $('.ques_'+getID.val()).append('<br>Selected Answer: '+$(obj).parent().text());
                }
          
            })
        }
    }
    $("#addAttemptedQQ").submit(function(e) {
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
                    window.location.href = response.url;
                }, 500);
              
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
<script>
var intervals = []; //prepare the intervals holder
function countdown(nr,initime,endtxt){
    var selector = "#duration";//actual class name will be .timer_123 (if nr=123)
    var timer2 = initime; //"71:10:07"; //unlimited hours
    
    intervals['countdown_'+nr] = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var hours = parseInt(timer[0], 10);
        var minutes = parseInt(timer[1], 10);
        var seconds = parseInt(timer[2], 10);
        
        --seconds; //decrement secs first
        
        minutes = (seconds < 0) ? --minutes : minutes;
        hours = (minutes < 0) ? --hours : hours;

            
        if (hours < 0 && minutes < 0 && seconds < 0) {
            clearInterval(intervals['countdown_'+nr]);
            $(selector).html(endtxt);
        } else {
            //console.log(selector+"_"+nr, timer, timer2);
            
            //do 59 reset here to allow detection of negative values above
            seconds = (seconds < 0) ? 59 : seconds;
            minutes = (minutes < 0) ? 59 : minutes;         
            
            //set new timer value
            timer2 = hours + ':' + minutes + ':' + seconds;
            
            //start changes for display only
            seconds = (seconds < 10) ? '00' + seconds : seconds;
            minutes = (minutes < 10) ? '00' + minutes : minutes; 
            $(selector).html('Duration: '+hours + ':' + minutes + ':' + seconds);
            
        } 
        
    }, 1000);   
}
countdown('1',"{{$currentElaps}}","Duration: Overdue");
</script>
@endsection