@extends('layouts.main')
@section('title', 'Edit Employee')
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
            <h5>{{ __('label.EMPLOYEE_UPDATE')}}</h5>
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
              <a href="#">{{ __('label.EMPLOYEE_UPDATE')}}</a>
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
          <h3>{{ __('label.EMPLOYEE_UPDATE')}}</h3>
        </div>
        <div class="card-body">
          <form class="forms-sample" method="POST" action="{{ url('/employees/'.$data->id) }}" >
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="first_name">{{ __('label.FIRST_NAME')}}<span class="text-red">*</span></label>
                  <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $data->first_name }}" placeholder="Enter first name" required>
                  <div class="help-block with-errors"></div>
                  @error('first_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="last_name">{{ __('label.LAST_NAME')}}<span class="text-red">*</span></label>
                  <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $data->last_name }}" placeholder="Enter last name" required>
                  <div class="help-block with-errors"></div>
                  @error('last_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="father_name">{{ __('label.FATHER_NAME')}}<span class="text-red">*</span></label>
                  <input id="father_name" name="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" value="{{ $data->father_name }}" placeholder="Enter father name" required>
                  <div class="help-block with-errors"></div>
                  @error('father_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mother_name">{{ __('label.MOTHER_NAME')}}<span class="text-red">*</span></label>
                  <input id="mother_name" name="mother_name" type="text" class="form-control @error('mother_name') is-invalid @enderror" value="{{ $data->mother_name }}" placeholder="Enter mother name" required>
                  <div class="help-block with-errors"></div>
                  @error('mother_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="email">{{ __('label.EMPLOYEE_EMAIL')}}<span class="text-red">*</span></label>
                  <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $data->email }}" placeholder="Enter email address" required>
                  <div class="help-block with-errors"></div>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="phone">{{ __('label.EMPLOYEE_PHONE')}}<span class="text-red">*</span></label>
                  <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ $data->phone }}" placeholder="Enter phone" required>
                  <div class="help-block with-errors"></div>
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

                <div class="col-sm-4">
                        <div class="form-group">
                        <label for="gender">{{ __('label.CHOOSE_GENDER')}}<span class="text-red">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender1" @error('gender') is-invalid @enderror"  aria-checked="false" required="" autocomplete="off" value="1" @if ($data->gender == 1) checked @endif>
                            <label class="form-check-label" for="gender">Male</label>
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            <input class="form-check-input" type="radio" name="gender" id="gender2" aria-checked="false" required="" autocomplete="off" value="2" @if ($data->gender == 2) checked @endif>
                            <label class="form-check-label" for="gender" @error('gender') is-invalid @enderror">Female</label>
                        </div>
                        <div class="help-block with-errors"></div>
                        @error('contactor_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="designation_id">{{ __('label.DESIGNATION')}}<span class="text-red">*</span></label>
                  <select id="designation_id" name="designation_id" class="form-control @error('designation_id') is-invalid @enderror" required="">
                    <option>Please select </option>
                    @foreach($designation as $value)
                    <option value="{{$value->id}}" {{ $value->id==$data->designation_id ? 'selected' : ' '}}>{{$value->name}}</option>
                    @endforeach
                  </select>
                  <div class="help-block with-errors"></div>
                  @error('designation_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="birthday">{{ __('label.DATE_OF_BIRTH')}}<span class="text-red">*</span></label>
                  <input id="birthday" name="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" value="{{ $data->birthday }}" placeholder="Enter birthday" required>
                  <div class="help-block with-errors"></div>
                  @error('salary_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="joining_date">{{ __('label.JOINING_DATE')}}<span class="text-red">*</span></label>
                  <input id="joining_date" name="joining_date" type="date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ $data->joining_date }}" placeholder="Enter joining date" required>
                  <div class="help-block with-errors"></div>
                  @error('salary_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="address">{{ __('label.EMPLOYEE_ADDRESS')}}<span class="text-red">*</span></label>
                  <textarea style="height: 36px" id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="" placeholder="Enter employee address" required>{{ $data->address }}</textarea>
                  <div class="help-block with-errors"></div>

                  @error('employee_address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

            </div>
            <div class="col-md-12">
              <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
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
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
