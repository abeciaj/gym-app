@extends('layouts.user-layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <form action="{{ route('city.list') }}" method="GET" class="align-items-center d-flex">
                    <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                    <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th class="project-state">ID</th>
                            <th class="project-state"> User Name</th>
                            <th class="project-state">Email</th>
                            <th class="project-state">Profile Picture</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr id="did{{ $user->id }}">
                            <td class="project-state">{{ $user->id }}</td>
                            <td class="project-state">{{ $user->name }} </td>
                            <td class="project-state">{{ $user->email }} </td>
                            <td class="project-state"><img alt="Avatar" class="table-avatar"
                                    src="{{ asset('imgs/def-image.jpg') }}"></td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('allUsers.show', $user['id']) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"
                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>

                                <a href="javascript:void(0)" onclick="banUser({{ $user->id }})"
                                    class="btn btn-dark btn-sm"><i class="fa fa-user-lock"></i></a>

                                <a class="btn btn-warning btn-sm" href="{{url('/allUsers/addGym',$user->id)}}">
                                    <i class="nav-icon fas fa-dumbbell"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="row">
                <div class="mt-3">
                    {{ $users->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
</div>
<!-- /.content-wrapper -->
<script>
function banUser(id) {
    if (confirm("Do you want to ban this user?")) {
        $.ajax({
            url: '/banUser/' + id,
            type: 'get',
            data: {
                _token: $("input[name=_token]").val()
            },
            success: function(response) {
                $("#did" + id).remove();
            }
        });
    }
}

function deleteUser(id) {
    if (confirm("Do you want to delete this record?")) {
        $.ajax({
            url: '/allUsers/' + id,
            type: 'DELETE',
            data: {
                _token: $("input[name=_token]").val()
            },
            success: function(response) {
                $("#did" + id).remove();
            }
        });
    }
}
</script>
@endsection
