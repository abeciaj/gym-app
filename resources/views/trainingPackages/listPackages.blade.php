@extends('layouts.user-layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Packages</h1>
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
                <!-- <div class="card-header">
                    <h3 class="card-title">Projects</h3>
                    <div class="card-tools">
                        <a href="{{ route('trainingPackages.creatPackage') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add New Package
                        </a>
                    </div>
                    
                </div> -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('trainingPackages.creatPackage') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add New Package
                    </a>
                    <form action="{{ route('trainingPackages.listPackages') }}" method="GET" class="align-items-center d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                        <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th class="project-state">Package Id</th>
                                <th class="project-state">Package Name</th>
                                <th class="project-state">Price</th>
                                <th class="project-state">Number of sessions</th>
                                <th class="project-state">Creator</th>
                                <th class="text-center">Actions </th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($packages as $package)
                                <tr id="did{{ $package->id }}">
                                    <td class="project-state">{{ $package->id }}</td>
                                    <td class="project-state">{{ $package->name }} </td>
                                    <td class="project-state">{{ $package->price / 100 }} $ </td>
                                    <td class="project-state">{{ $package->sessions_number }}</td>
                                    <td class="project-state">{{ $package->user ? $package->user->name : 'Not found' }}
                                    </td>
                                    <td class="project-actions text-center">
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('trainingPackages.show_training_package', $package['id']) }}">

                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm text-white"
                                            href="{{ route('trainingPackages.editPackage', $package['id']) }}">
                                            <i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{ route('PaymentPackage.stripe') }}" class="btn btn-info btn-sm">Buy
                                        </a>
                                        @role('admin')
                                            <a href="javascript:void(0)" onclick="deletePackage({{ $package->id }})"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                        @endrole


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="row">
                    <div class="mt-3">
                        {{ $packages->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
    </div>
    <!-- /.content-wrapper -->
    <script>
        function deletePackage(id) {
            if (confirm("Do you want to delete this record?")) {
                $.ajax({
                    url: '/trainingPackages/' + id,
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
