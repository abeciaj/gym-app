@extends('layouts.user-layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Gyms</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Gyms</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">Gyms</h3>
                    <div class="card-tools">
                        <a href="/gym/create" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add New Gym
                        </a>
                    </div>
                </div> -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="/gym/create" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New Gym
                    </a>
                    <form action="{{ route('gym.list') }}" method="GET" class="align-items-center d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                        <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th class="project-state">id</th>
                                <th class="project-state">Gyms Name</th>
                                <th class="project-state">Gym City</th>
                                <th class="project-state">Created at</th>
                                <th class="project-state">Gyms Cover Image</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gyms as $gym)
                                <tr id="gid{{ $gym->id }}">
                                    <td class="project-state">{{ $gym->id }}</td>
                                    <td class="project-state">{{ $gym->name }}</td>
                                    <td class="project-state">

                                        @if ($gym->city == null)
                                            <span class="project-state">this gym has no city</span>
                                        @else
                                            <span class="project-state">{{ $gym->city->name }}</span>
                                        @endif
                                    </td>
                                    <td class="project-state">{{ $gym->created_at->format('d - M - Y') }}</td>
                                    <td class="project-state">
                                        <img alt="Avatar" class="table-avatar" src="{{ asset('imgs/def-image.jpg') }}">
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{ route('gym.show', $gym['id']) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm text-white"
                                            href="{{ route('gym.edit', $gym['id']) }}">
                                            <i class="fas fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" onclick="deleteGym({{ $gym->id }})"
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
                        {{ $gyms->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
    </div>
    <!-- /.content-wrapper -->

    <script>
        function deleteGym(id) {
            if (confirm("Do you want to delete this record?")) {
                $.ajax({
                    url: '/gym/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $("#gid" + id).remove();
                    }
                });
            }
        }
    </script>
@endsection
