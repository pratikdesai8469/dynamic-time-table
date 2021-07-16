<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Time Table</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            .mt-20pr{
                margin-top: 2%;
            }
            .d-none{
                display: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card-header">
                <div class="card-title">
                    <h1>Time Table</h1>
                    <hr>
                </div>
            </div>
            <br>
            <div class="row">
                {{Form::open(['route'=>'timetable'])}}
                    <div class="form-group">
                        <div class="col-md-3">
                            {{Form::label('No Of Working Days')}}
                            {{Form::text('no_of_working_days','',['class'=>'form-control valid-number','maxlength'=>1,'placeholder'=>'No Of Working Days','data-max'=>55,'required'])}}
                            @if($errors->has('no_of_working_days'))
                                <div class=" text-danger error">{{ $errors->first('no_of_working_days') }}</div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            {{Form::label('No Of Subjects Per Days')}}
                            {{Form::text('no_of_subjects_days','',['class'=>'form-control valid-number','maxlength'=>1,'placeholder'=>'No Of Subjects Days','data-max'=>57,'required'])}}
                            @if($errors->has('no_of_subjects_days'))
                                <div class="text-danger error">{{ $errors->first('no_of_subjects_days') }}</div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            {{Form::label('Total Subject')}}
                            {{Form::text('total_subjects','',['class'=>'form-control valid-number','maxlength'=>1,'placeholder'=>'Total Subject','data-max'=>57,'required'])}}
                            @if($errors->has('total_subjects'))
                                <div class="text-danger error">{{ $errors->first('total_subjects') }}</div>
                            @endif
                        </div>
                        <div class="col-md-1 mt-20pr">
                            {{Form::submit('Submit',['class'=>'btn btn-primary total-hours-form'])}}
                        </div>
                    </div>  
            </div>
            @php
                $data = session('data');
                $totalHours = $data['totaWeeklHours'];
                $totalSubjects = $data['totalSubjects'];
                $totalDays = $data['noOfWorkingDays'];
                $week = $data['week'];
                $subjectData = $data['subjectData'];
            @endphp
            @if(!empty($totalSubjects))
                <hr>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <h4>Subjects Hour</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=1; $i <= $totalSubjects; $i++)
                                    <tr>
                                        <td>{{Form::text('subject_data['.$i.'][subject]','',['class'=>'form-control only-alphabet','maxlength'=>'10','required'])}}</td>
                                        <td>{{Form::text('subject_data['.$i.'][hours]','',['class'=>'form-control valid-number subject-hours','data-max'=>57,'maxlength'=>'2','required'])}}</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                        <div class="text-danger hours-error d-none">Please enter correct hours</div>
                        {{Form::submit('Submit',['class'=>'btn btn-primary total-hours-form'])}}
                    {{Form::close()}}
                    </div>
                    @if(!empty($subjectData))
                        <div class="col-md-9">
                            <h4><b>Dynamic Time Table</b></h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        @for($i=1; $i <= $totalDays; $i++)
                                            <th>{{$week[$i]}}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjectData as $key=>$item)
                                        <tr>
                                            @for($i=0; $i < $totalDays; $i++)
                                                <td>{{isset($item[$i]) ? $item[$i] : '-'}}</td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <script>
            $(document).on('keypress', '.valid-number', function(e) {
                var maxId = $(this).data('max');
                if (e.which != 8 && (e.which < 48 || e.which > maxId)) {
                    return false;
                }
            });
            $(document).on('keydown', '.only-alphabet', function(e) {
                var key = e.keyCode;
                if(!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))){
                    e.preventDefault();
                }
            });

            $(document).on('click','.total-hours-form',function(){
                var subjectTotalHours = 0;
                $('.hours-error').addClass('d-none');
                $('.subject-hours').each(function(){
                    subjectTotalHours += parseFloat($(this).val());
                });
                var totalHours = "{{$totalHours}}";
                if(subjectTotalHours > totalHours){
                    $('.hours-error').removeClass('d-none');
                    return false;
                }
            });
        </script>
    </body>
</html>
