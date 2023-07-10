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
                             
                                <th>Invoice No</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                           
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                       
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->total_amount }}</td>
                                        <td>{{ $invoice->paid_amount }}</td>
                                        <td>{{ $invoice->due_amount }}</td>
                                        
                                 
                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('invoice.edit', $invoice->id) }}">Edit</a> |
                                                <a class="btn btn-success"
                                                href="{{ route('invoice.show', $invoice->id) }}">View</a> |

                                                <form action="{{ route('invoice.destroy', $invoice->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                     @method("DELETE")
                                                 <button class="btn btn-danger" onclick="return confirm('bạn có muốn xóa {{ $invoice->name }}') ">delete</button> 
                                                 </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $invoices->render() }}
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