@extends('common_template')

@section('content')
<style>
  .content-section {
    margin-top: 40px;
  }
  .add-emp {
      margin-bottom: 10px;
  }
</style>
<div class="content-section">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <a href="{{route('employee.create')}}" class="btn btn-info add-emp">Add employee</a>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Employee Name</td>
          <td>Status</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($resultArr as $result)
        <tr>
            <td>{{$result->id}}</td>
            <td>{{$result->emp_name}}</td>
            <td>@php echo isset($result->emp_status) && !empty($result->emp_status) ? 'Active' : 'Inactive'; @endphp</td>
            <td><a href="{{ route('employee.edit', $result->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                <button class="btn btn-danger" type="button" onclick="deleteEmployee({{$result->id}})">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
@endsection
@section('script')
<script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function deleteEmployee(id) {
    var html = '';
    var msgType = 'danger';
    $('.alert').remove();
    $.ajax({
      'url':'/employee/destroy',
      'type':'DELETE',
      'dataType':'JSON',
      'data':'id='+id,
      success:function(resp) {
        if(resp.ack == 'ok') {
          msgType = 'success';
        }
        html = '<div class="alert alert-'+msgType+'"><ul><li>'+resp.msg+'</li></ul></div>';
        $('.content-section').append(html).slideDown(5000);
        location.reload()
      }
    })
  }
</script>
@endsection