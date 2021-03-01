@extends('common_template')

@section('content')
<style>
  .content-section {
    margin-top: 40px;
  }
</style>
<div class="card upcontent-sectioner">
  <div class="card-header">
    Add employee
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
    @php 
      $empId = isset($resultArr->id) ? $resultArr->id : '';
      $empName = $empStatus = $method = '';
      $route = route('employee.store');
      if(!empty($empId)) {
        $route = route('employee.update', $resultArr->id);
        $empName = $resultArr->emp_name;
        if($resultArr->emp_status == 1) {
          $empStatus = 'checked';
        }
      }
    @endphp
      <form method="post" action="{{ $route }}">
          <div class="form-group">
              @csrf
              @if(!empty($empId))
                @method('PATCH')
              @endif
              <label for="name">Employee name:</label>
              <input type="text" class="form-control" name="emp_name" value="{{@$empName}}"/>
          </div>
          <div class="form-group">
              <label for="Employee status">Is active ?</label>
              <input type="checkbox" class="checkbox" name="emp_status" {{@$empStatus}}/>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
      </form>
  </div>
</div>
@endsection