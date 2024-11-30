@extends('layouts.user-layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Purchases</h1>
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
                    <h3 class="card-title">Purchases</h3>
                </div> -->
                <div class="card-header d-flex justify-content-center align-items-center">
                    <form action="{{ route('PaymentPackage.purchase_history') }}" method="GET" class="align-items-center d-flex">
                        <input type="text" name="search" class="form-control" value="{{ $search ?? '' }}" />
                        <button class="btn btn-outline-success my-3 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Email</th>
                                <th>User Name</th>
                                <th>Package Name</th>
                                <th>Amount</th>
                                @role('admin')
                                    <th>Gym Name</th>
                                    <th>City Name</th>
                                @endrole
                                @role('cityManager')
                                    <th>Gym Name</th>
                                @endrole

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($revenues as $revenue)
                                <tr>
                                    <td>{{ $revenue->user->id }}</td>
                                    <td>{{ $revenue->user->email }}</td>
                                    <td> {{ $revenue->user->name }}</td>
                                    @if ($revenue->trainingPackage->name == null)
                                        <td>there is no training Package name </td>
                                    @else
                                        <td> {{ $revenue->trainingPackage->name }}</td>
                                    @endif
                                    <td> {{ $revenue->price / 100 }} $</td>
                                    @role('admin')
                                        <td>{{ $revenue->user->gym->name }}</td>
                                        <td>{{ $revenue->user->city->name }}</td>
                                    @endrole
                                    @role('cityManager')
                                        <td>{{ $revenue->user->gym->name }}</td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- Pagination -->
                <div class="row">
                    <div class="mt-3">
                        {{ $revenues->appends(['search' => $search])->links(('vendor.pagination.bootstrap-5')) }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
