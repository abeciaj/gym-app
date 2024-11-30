@extends('layouts.user-layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Cities</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Cities</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('city.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New City
                    </a>
                    <form action="{{ route('city.list') }}" method="GET" class="align-items-center d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                        <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th class="project-state"> ID </th>
                                <th class="project-state"> City Name</th>
                                <th class="project-state"> City Manager Name</th>
                                <th class="project-state">Created at</th>
                                <th class="project-state">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allCities as $city)
                                <tr id="cid{{ $city->id }}">

                                    <td class="project-state">{{ $city->id }}</td>
                                    <td class="project-state">{{ $city->name }}</td>
                                    @if ($city->manager == null)
                                        <td class="project-state">This city has no Manager</td>
                                    @else
                                        <td class="project-state">{{ $city->manager->name }}</td>
                                    @endif
                                    <td class="project-state">{{ $city->created_at->format('d - M - Y') }}</td>
                                    <td class="project-actions project-state">
                                        <a class="btn btn-info btn-sm" href="{{ route('city.show', $city->id) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm text-white"
                                            href="{{ route('city.edit', $city->id) }}">
                                            <i class="fas fa-pencil-alt"></i></a>

                                        <a href="javascript:void(0)"
                                            onclick="deleteCity({{ $city->id }},{{ $city->manager_id }})"
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
                        {{ $allCities->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
    <!-- /.content-wrapper -->
    <script>
        function deleteCity(id, manager) {
            if (manager > 0) {
                alert('This city has a manager so it can\'t be deleted')
            } else {
                if (confirm("Do you want to delete this record?")) {
                    $.ajax({
                        url: '/cities/' + id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            $("#cid" + id).remove();
                        }
                    });
                }
            }

        }
    </script>
@endsection
