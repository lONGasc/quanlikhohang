@extends('layouts.master')


@section('title', 'Category')
@section('content')
    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Input Text</h4>
                    </div>
          
                        <div class="card-body">
                   
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <th>Sl No.</th>
                             
                                <th>Name</th>
                                <th>Short_Form</th>
                           
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                       
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->short_form }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('unit.edit', $unit->id) }}">Edit</a> |
                                                <form action="{{ route('unit.destroy', $unit->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                     @method("DELETE")
                                                 <button class="btn btn-danger" onclick="return confirm('bạn có muốn xóa {{ $unit->name }}') ">delete</button> 
                                                 </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $units->render() }}
                        </div>
                  
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Button trigger modal -->

  


@section('scripts')
<script>
    $(document).ready(function() {
     
        $('.delete').on('click', function () {
                const id = this.id;
                $('#deleteModal').attr('action', '{{ route("supplier.destroy", "") }}' + '/' + id);
            });
    });
</script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection




@section('scripts')
<script>
    let table = new DataTable('#myTable');
</script>

@stop