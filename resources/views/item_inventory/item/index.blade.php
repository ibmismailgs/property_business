@extends('layouts.main')
@section('title', 'Item Inventory')
@section('content')
<!-- push external head elements to head -->
@push('head')
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
@endpush

<div class="container-fluid">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-lg-8">
        <div class="page-header-title">
          <i class="ik ik-users bg-blue"></i>
          <div class="d-inline">
            <h5>{{ __('label.ITEM_INVENTORY')}}</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <nav class="breadcrumb-container" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{route('dashboard')}}"><i class="ik ik-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="#">{{ __('label.ITEM_INVENTORY')}}</a>
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
      <div class="card p-3">
        <div class="card-header">
          <h3>{{ __('label.ITEM_INVENTORY')}}</h3>
          <div class="card-header-right">
              <a href="{{url('item-inventory/create')}}" class="btn btn-primary">  @lang('label.CREATE')</a>
          </div>
      </div>
        <div class="card-body">
          <table  class="table">
            <thead>
              <tr>
                <th>{{ __('label.SERIAL')}}</th>
                <th>{{ __('label.ITEM_NAME')}}</th>
                <th>{{ __('label.CATEGORY_NAME')}}</th>
                <th>{{ __('label.SUB_CATEGORY_NAME')}}</th>
                <th>{{ __('label.GROUP_NAME')}}</th>
                <th>{{ __('label.ACTION')}}</th>
              </tr>
            </thead>
            <?php $i=1;?>
            <tbody>
              @foreach($item as $value)
              <tr>
                <td>{{$i++}}</td>
                <td>{{ $value->items->item_name}}</td>
                <td>{{ $value->category->name}}</td>
                <td>
                @if(($value->subcategory_id) == Null)
                    Empty
                @else
                {{ $value->subcategory->name}}
                @endif
            </td>
                <td>
                @if(($value->group_id) == Null)
                    Empty
                @else
                    {{ $value->group->group_name}}
                @endif
            </td>

                <td scope="col">
                  <div class="table-actions">
                      <a href="{{route('item-inventory.show', $value->id)}}" title="View">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-primary">
                            <i class="fa fa-eye btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a href="{{route('item-inventory.edit', $value->id)}}" title="Edit">
                        <button class="mr-2 btn-icon btn-icon-only btn btn-success">
                            <i class="fa fa-edit btn-icon-wrapper"></i>
                        </button>
                    </a>
                    <a>
                        <form action="{{url('item-inventory/'.$value->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="mr-2 btn-icon btn-icon-only btn btn-danger btn-delete"  type="submit" >  <i class="fa fa-trash btn-icon-wrapper"></i></button>
                        </form>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- push external js -->
@push('script')
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<!--server side users table script-->
<script src="{{ asset('js/custom.js') }}"></script>
@endpush
@endsection
