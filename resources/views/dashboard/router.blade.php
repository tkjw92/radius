@extends('dashboard.layouts.main')
@section('header')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
@endsection
@section('content')
    <div class="content-wrapper pb-5">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h4 class="m-0"><i class="fas fa-server"></i> <span class="font-weight-bold">ROUTER</span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card  card-primary card-outline h-100">
                            <div class="card-header">FORM ROUTER</div>
                            <hr />
                            <form action="/router/add" method="post">
                                @csrf
                                <div class="card-body pt-0">
                                    <div class="form-group">
                                        <label for="nama" class="text-muted font-weight-normal">Nama router</label>
                                        <input type="text" class="form-control" id="nama" name="name" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="port" class="text-muted font-weight-normal">COA Port</label>
                                        <input type="text" class="form-control" id="port" name="coa" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="secret" class="text-muted font-weight-normal">Secret radius</label>
                                        <input type="text" class="form-control" id="secret" name="secret" required />
                                    </div>
                                    <button type="reset" class="btn btn-danger" type="button">RESET</button>
                                    <button type="submit" class="btn btn-primary" type="submit">TAMBAH</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card  card-primary card-outline h-100">
                            <div class="card-header">DATA ROUTER</div>
                            <div class="card-body">
                                <table id="example" class="table border-dark nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>NAMA ROUTER</th>
                                            <th>IP ADDRESS</th>
                                            <th>SECRET</th>
                                            <th class="text-center">PORT</th>
                                            <th class="text-center">ONLINE</th>
                                            <th class="text-center">OPTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($routers as $router)
                                            @php
                                                $count = 0;
                                                foreach ($actives as $active) {
                                                    if ($router->nasname == $active->nasipaddress) {
                                                        $count++;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td class="align-middle">{{ $router->shortname }}</td>
                                                <td class="align-middle">{{ $router->nasname }}</td>
                                                <td class="align-middle">{{ $router->secret }}</td>
                                                <td class="text-center align-middle">{{ $router->ports }}</td>
                                                <td class="text-center align-middle">
                                                    <h4 class="m-0 text-danger font-weight-bold">{{ $count }}</h4>
                                                </td>
                                                <td class="text-center align-middle"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-cog"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $('#example').DataTable({
            // responsive: true,
            ordering: false,
            scrollX: true
        });
    </script>
@endsection
