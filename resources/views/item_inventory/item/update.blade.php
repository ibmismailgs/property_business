@extends('layouts.main')
@section('title', 'Edit Item Inventory')
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
                        <h5>{{ __('label.UPDATE_ITEM_INVENTORY')}}</h5>
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
                            <a href="#">{{ __('label.UPDATE_ITEM_INVENTORY')}}</a>
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
                    <h3>{{ __('label.UPDATE_ITEM_INVENTORY')}}</h3>
                </div>
                <div class="card-body">
                <form class="forms-sample" method="POST" action="{{ url('/item-inventory/'.$item->id) }}" >
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="category_id">{{ __('label.SELECT_CATEGORY')}}<span class="text-red">*</span></label>
                                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required="">
                                        <option>Please select </option>
                                        @foreach($category as $data)
                                        <option value="{{$data->id}}" {{ $data->id==$item->category_id ? 'selected' : ' '}}>{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="subcategory_id">{{ __('label.SELECT_SUB_CATEGORY')}}<span class="text-red">*</span></label>

                                    <select id="subcategory_id" name="subcategory_id" class="form-control @error('subcategory_id') is-invalid @enderror" >
                                        <option value="">Please select </option>
                                        @foreach($subcategory as $value)
                                        <option value="{{$value->id}}" {{ $value->id==$item->subcategory_id ? 'selected' : ' '}}>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="group_id">{{ __('label.SELECT_GROUP')}}<span class="text-red">*</span></label>
                                    <select id="group_id" name="group_id" class="form-control @error('group_id') is-invalid @enderror" >
                                        <option value="">Please select </option>
                                        @foreach($group as $data)
                                        <option value="{{$data->id}}" {{ $data->id == $item->group_id ? 'selected' : ' '}}>{{$data->group_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    @error('group_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="item_id">{{ __('label.ITEM_NAME')}}<span class="text-red">*</span></label>
                                    <select id="item_id" name="item_id" class="form-control @error('item_id') is-invalid @enderror" >
                                        <option value="">Please select </option>
                                        @foreach($itemname as $itemnames)
                                        <option value="{{$itemnames->id}}" {{ $itemnames->id == $item->item_id ? 'selected' : ' '}}>{{$itemnames->item_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    @error('item_id')
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
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('#category_id').on('change',function(e) {
         var category_id = e.target.value;
         $.ajax({
               url:"{{ url('selectsubcategory') }}",
               type:"POST",
               data: {
                category_id: category_id
                },
               success:function (data) {
                $('#subcategory_id').empty();
                $.each(data.subcategory, function(key){
                    $('#subcategory_id').append("<option value='"+data.subcategory[key].id+"'>"+data.subcategory[key].name+"</option>");
                    })
               }
           })
        });
    });
</script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--get role wise permissiom ajax script-->
{{-- <script src="{{ asset('js/get-role.js') }}"></script> --}}
@endpush

@endsection
