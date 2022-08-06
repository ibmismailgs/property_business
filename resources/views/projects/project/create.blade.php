@extends('layouts.main')
@section('title', 'Create Project')
@section('content')
<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-user-plus bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('label.CREATE_PROJECT')}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('label.CREATE_PROJECT')}}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- start message area-->
        @include('include.message')
        <!-- end message area-->
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3>{{ __('label.CREATE_PROJECT')}}</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('projects') }}" >
                        @csrf
                        <div id="component">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_type_id">{{ __('label.PROJECT_TYPE')}}<span class="text-red">*</span></label>
                                        <select id="project_type_id" name="project_type_id" class="form-control @error('project_type_id') is-invalid @enderror">
                                            <option value="">Please select project type</option>
                                            @foreach($data as $val)
                                            <option value="{{$val->id}}">{{$val->type_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                        @error('project_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_name">{{ __('label.PROJECT_NAME')}}<span class="text-red">*</span></label>
                                        <input id="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="" placeholder="Enter project name" required>
                                        <div class="help-block with-errors"></div>
                                        @error('project_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_packages">{{ __('label.NUMBER_OF_PACKAGES')}}<span class="text-red">*</span></label>
                                        <input id="project_packages" type="text" class="form-control @error('project_packages') is-invalid @enderror" name="project_packages" value="" placeholder="Enter project packages" required>
                                        <div class="help-block with-errors"></div>
                                        @error('project_packages')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_value">{{ __('label.PROJECT_VALUE')}}<span class="text-red">*</span></label>
                                        <input id="project_value" type="text" class="form-control @error('project_value') is-invalid @enderror" name="project_value" value="" placeholder="Enter project value" required>
                                        <div class="help-block with-errors"></div>
                                        @error('project_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="project_duration">{{ __('label.PROJECT_DURATION')}}<span class="text-red">*</span></label>
                                        <input id="project_duration" type="text" class="form-control @error('project_duration') is-invalid @enderror" name="project_duration" value="" placeholder="Enter project duration" required>
                                        <div class="help-block with-errors"></div>
                                        @error('project_duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="implementing_agency">{{ __('label.IMPLEMENTING_AGENCY')}}<span class="text-red">*</span></label>
                                        <input id="implementing_agency" type="text" class="form-control @error('implementing_agency') is-invalid @enderror" name="implementing_agency" value="" placeholder="Enter project agency" required>
                                        <div class="help-block with-errors"></div>
                                        @error('implementing_agency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="start_date">{{ __('label.START_DATE')}}<span class="text-red">*</span></label>
                                        <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date"  placeholder="Enter project start date" required>
                                        <div class="help-block with-errors"></div>
                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="completed_date">{{ __('label.COMPLETED_DATE')}}<span class="text-red">*</span></label>
                                        <input id="completed_date" type="date" class="form-control @error('completed_date') is-invalid @enderror" name="completed_date"  placeholder="Enter project completed date" required>
                                        <div class="help-block with-errors"></div>
                                        @error('completed_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button  type="button" class="btn btn-success addmore" id="add">+ Add Component</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('label.SUBMIT')}}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- push external js -->
@push('script')



<script type="text/javascript">
    var i = 0;
$("#add").click(function() {
  ++i;
  $("#component").append('<div class="row" id="addrow"><div class="col-sm-4">\
        <div class="form-group">\
        <label for="">{{ __('label.SELECT_COMPONENT')}}<span class="text-red">*</span></label>\
        <select id="component_id" name="component_id[]" class="form-control component_id @error('component_id') is-invalid @enderror">\<option>Please select</option>\
        @foreach($component as $value)\
        <option value="{{$value->id}}">{{$value->component_name}} <b>,</b> {{$value->component_code}}</option>\
        @endforeach\</select>\<div class="help-block with-errors"></div>\
        @error("component_id")\
        <span class="invalid-feedback" role="alert">\
        <strong>{{ $message }}</strong>\
        </span>\
        @enderror\
        </div>\
        </div>\
        <div class="col-sm-4">\
        <div class="form-group">\
        <label for="gob">{{ __('label.GOB')}}<span class="text-red">*</span></label>\
        <input id="gob" type="number" class="gob form-control @error('gob') is-invalid @enderror" name="gob[]" value="" placeholder="Enter gob" min="0">\
        <div class="help-block with-errors"></div>\
        @error("gob")\
        <span class="invalid-feedback" role="alert">\
        <strong>{{ $message }}</strong>\
        </span>\
        @enderror\
        </div>\
        </div>\
        <div class="col-sm-4">\
        <div class="form-group">\
        <label for="others_rpa">{{ __('label.OTHERS_RPA')}}<span class="text-red">*</span></label>\
        <input id="others_rpa" type="number" class="others_rpa form-control @error('others_rpa') is-invalid @enderror" name="others_rpa[]" value="" min="0" placeholder="Enter others rpa" required>\
        <div class="help-block with-errors"></div>\
        @error("others_rpa")\
        <span class="invalid-feedback" role="alert">\
        <strong>{{ $message }}</strong>\
        </span>\
        @enderror\
        </div>\
        </div>\<div class="col-sm-4">\
        <div class="form-group">\
        <label for="dpa">{{ __('label.DPA')}}<span class="text-red">*</span></label>\
        <input id="dpa" type="number" class="dpa form-control @error('dpa') is-invalid @enderror" name="dpa[]" value="" min="0" placeholder="Enter DPA" required>\
        <div class="help-block with-errors"></div>\
        @error("dpa")\
        <span class="invalid-feedback" role="alert">\
        <strong>{{ $message }}</strong>\
        </span>\
        @enderror\
        </div>\
        </div>\
        <div class="col-sm-4">\
        <div class="form-group">\
        <button style="margin-top: 27px;" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">-</button>\
        </div>\
        </div>\
        </div>');
});

    $(document).on('click', '.btn_remove', function() {
    $(this).parents('#addrow').remove();
    });

    $(".addmore").click(function(){
            $(this).html("+ Add more");
        });
</script>

<script>
   $(document).on('click', 'select.component_id', function () {
      $('select[name*="component_id[]"] option').attr('disabled',false);
      $('select[name*="component_id[]"]').each(function(){
        var $this = $(this);
        $('select[name*="component_id[]"]').not($this).find('option').each(function(){
             if($(this).attr('value') == $this.val())
             $(this).attr('disabled',true);
        });
      });
    });
</script>

<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
