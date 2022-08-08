    <div data-repeater-item class="row">
        <div class="row col-12 col-md-6">

            <div class="form-group col-12 col-xl-6">
                <label for="" class="w-100">Quiz Question</label>
                <input name="quiz_question" class="form-control" type="text" name="text-input" placeholder="Enter Question" value="{{$ques->quiz_question}}" />
            </div>
            <div class="form-group col-12 col-xl-4">
                <label for="" class="w-100">Quiz Type</label>
                <select name="type" class="custom-select form-control-border" id="exampleSelectBorder">
                    <option value="">Select Type</option>
                    <option value="single" @if ($ques->type == 'single') selected @endif>Single (Radio)</option>
                    <option value="multiple" @if ($ques->type == 'multiple') selected @endif>Multiple (Checkbox)</option>
                </select>
            </div>
            <div class="form-group col-6 col-xl-2">
                <label for="" class="w-100 py-2"></label>
                <input class="btn btn-danger" data-repeater-delete type="button" value="Delete" />
            </div>
        </div>

        <!-- innner repeater -->
        <div class="col-12 col-md-6 card inner-repeater">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">Quiz Options</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input class="btn btn-success" data-repeater-create type="button" value="Add Option" />
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="">
                    <div data-repeater-list="inner_list">
                        @php
                            $opt = explode(',',$ques->quiz_answer); 
                        @endphp
                        @foreach ($opt as $key => $item)
                        <div data-repeater-item>
                            <div class="row p-3">
                                <label for="" class="w-100">Option Title</label>
                                <div class="form-group col-sm-12 col-xl-6">
                                    <input class="form-control" type="text" name="quiz_answer" placeholder="Enter Option" value="{{$item}}" />
                                </div>
                                <div class="align-self-center col-sm-12 col-xl-4 form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox"
                                                name="quiz_correct_answer"
                                                class="form-check-input" 
                                                @if ($ques->type == 'multiple') 
                                                    {{ in_array($key, explode(',',$ques->quiz_correct_answer)) ? 'checked' : '' }}
                                                @else 
                                                    {{$ques->quiz_correct_answer == $key ? 'checked' : '' }}
                                                @endif >Is
                                            Correct Answer
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12 col-xl-2 align-self-center">
                                    <input class="btn btn-danger" data-repeater-delete type="button" value="Delete" />
                                </div>
                            </div>
                        </div>
                        @endforeach
                       
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
            <!-- /.card-footer-->
        </div>


    </div>