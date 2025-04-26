@extends('index')

@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Halaman</h5>
        <div class="table-responsive text-nowrap">
            <table class="datatables-basic table" id="pagesTable">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Komponen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#pagesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pages.cms.datatable') }}",
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'slug', name: 'slug' },
                    { data: 'template', name: 'template' },
                    { data: 'components_list', name: 'components_list', orderable: false, searchable: false },
                    { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endsection