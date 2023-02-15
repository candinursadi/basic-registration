@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">Gender</label>

                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender')=='male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender')=='female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="hobby" class="col-md-4 col-form-label text-md-end">Hobby</label>

                            <div class="col-md-6">
                                <input id="hobby" type="text" class="form-control @error('hobby') is-invalid @enderror" name="hobby" value="{{ old('hobby') }}" required autocomplete="hobby" autofocus maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus maxlength="20">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus maxlength="10">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <button type="reset" class="btn btn-light">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">Registration List</div>

                <div class="card-body" style="overflow-x: scroll">
                    <table id="registration_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Hobby</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="/vendor/sweetalert/sweetalert.all.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#registration_list thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#registration_list thead');

        var userTable = $('#registration_list').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function () {
                var api = this.api();

                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        var disabled = '';
                        var disabled_array = [0,8];
                        if(disabled_array.indexOf(colIdx) > -1) disabled = 'disabled';
                        $(cell).html('<input type="text" placeholder="' + title + '" ' + disabled + '/>');

                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != ''
                                            ? regexr.replace('{search}', '(((' + this.value + ')))')
                                            : '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            aaSorting: [[1,'desc']],
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'created_at', name: 'created_at', render: function(data, type, row){
                    if(type === "sort" || type === "type"){
                        return data;
                    }
                    return moment(data).format("YYYY-MM-DD HH:mm:ss");
                }},
                { data: 'name', name: 'name' },
                { data: 'gender', name: 'gender' },
                { data: 'hobby', name: 'hobby' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'username', name: 'username' },
                { data: 'id', name: 'action', render: function(data, type, row) {
                    return '<button type="button" class="btn btn-danger delete" data-id="'+data+'">Delete</button>';
                }}
            ],
            columnDefs: [
                { 'searchable': false, 'targets': [0,8] },
                { 'orderable': false, 'targets': [0,8] }
            ]
        });
    });

    $('body').on('click','.delete', function() {
        var table = $('#registration_list').DataTable();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('register.delete') }}",
                    type: 'post',
                    data: {_token: "{{ csrf_token() }}", id: $(this).data('id')},
                    success: function(response){
                        if(response.status == true){
                            Swal.fire(
                            'Deleted!',
                            'Data has been deleted.',
                            'success'
                            );

                            // Reload DataTable
                            table.ajax.reload();
                        }else{
                            Swal.fire(
                            'Failed!',
                            'Something wrong.',
                            'error'
                            );
                        }
                    }
                })
            }
        });
    });
</script>
@endpush
