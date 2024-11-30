@extends('layouts.user-layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Sessions</h1>
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
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">Projects</h3>
                    <div class="card-tools">
                        <a href="{{ route('TrainingSessions.training_session') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add New Session
                        </a>
                    </div>
                </div> -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('TrainingSessions.training_session') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New Session
                    </a>
                    <form action="{{ route('TrainingSessions.listSessions') }}" method="GET" class="align-items-center d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                        <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Session Name</th>
                                <th>Day</th>
                                <th>Starts At</th>
                                <th>Finishes At</th>
                                <th>Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingSessions as $trainingSession)
                                <tr id="did{{ $trainingSession->id }}" class="text-center">
                                    <td>{{ $trainingSession->id }}</td>
                                    <td>{{ $trainingSession->name }} </td>
                                    <td>{{ $trainingSession->day }} </td>
                                    <td>{{ $trainingSession->starts_at }}</td>
                                    <td>{{ $trainingSession->finishes_at }}</td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('TrainingSessions.show_training_session', $trainingSession['id']) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm text-white"
                                            href="{{ route('TrainingSessions.edit_training_session', $trainingSession['id']) }}">
                                            <i class="fas fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" onclick="deleteSession({{ $trainingSession->id }})"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="row">
                    <div class="mt-3">
                        {{ $trainingSessions->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
    <!-- /.content-wrapper -->
    <script>
        function deleteSession(id) {
            if (confirm("Do you want to delete this record?")) {

                $.ajax({
                    url: '/TrainingSessions/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()

                    }
                    ,
                    success: function(response) {
                        if (response.success) {
                            $("#did" + id).remove();
                        } else {
                            alert("You can't delete the session");
                        }
                    }

                });
            }
        }
    </script>
@endsection
