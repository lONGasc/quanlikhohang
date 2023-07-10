@extends('layouts.master')


@section('title', 'Create | Supplier | Customer')
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
                                <th>Thumbnail</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <img src="{{ url('/uploads/supplier/' . $supplier->image) }}" alt="Supplier Img"
                                                width="60">
                                        </td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('supplier.edit', $supplier->id) }}">Edit</a> |
                                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                     @method("DELETE")
                                                 <button class="btn btn-danger" onclick="return confirm('bạn có muốn xóa {{ $supplier->name }}') ">delete</button> 
                                                 </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $suppliers->render() }}
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