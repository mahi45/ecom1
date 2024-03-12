@extends('backend.layouts.master')

@section('title')
    Category Index
@endsection

@push('admin_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .dataTables_length{
            padding: 20px 0;
        }
    </style>
@endpush

@section('admin_content')
<div class="row">
    <h1>Category List Table</h1>
    <div class="col-12">
        <div class="d-flex justify-content-end">
            <a href="{{ route('category.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>Add New Category</a>
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive my-2">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Last Modified</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Category Slug</th>
                        <th scope="col">Category Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $categories->firstItem()+$loop->index }}</th>
                            <td>{{ $category->updated_at->format('d M Y') }}</td>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    setting
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('category.edit', $category->slug) }}">
                                    <i class="fas fa-edit"></i> Edit</a></li>
                                    <li>
                                        <form action="{{ route('category.destroy', $category->slug) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item show_confirm" type="submit"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('admin_script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){
            $('#dataTable').DataTable({
                pagingType: 'first_last_numbers',
            });

            $('.show_confirm').click(function(event){
                event.preventDefault();
                let form = $(this).closest('form');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                            });
                        }
                    });
            })
        })
    </script>

@endpush
