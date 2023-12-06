@extends('dashboard.layouts.main')
@section('header')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
@endsection
@section('content')
    <div class="content-wrapper pb-5">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  card-primary card-outline h-100">
                            <div class="card-header bg-primary">USER PPPOE</div>
                            <div class="card-body">
                                <div class="d-flex border-bottom border-1 border-dark flex-wrap justify-content-left mb-3">
                                    <button type="button" class="btn btn-success mr-2 mb-3" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle"></i> BUAT USER</button>
                                </div>

                                <table id="example" class="table border-dark nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>USERNAME</th>
                                            <th>PASSWORD</th>
                                            <th>PROFILE</th>
                                            <th>SERVER</th>
                                            <th>EXPIRED AT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td><i class="fas fa-circle text-{{ $actives->where('username', $user[0])->count() > 0 ? 'success' : 'danger' }}"></i></td>
                                                <td>{{ $user[0] }}</td>
                                                <td>{{ $user[1] }}</td>
                                                <td>{{ $user[2] }}</td>
                                                <td>{{ $user[3] }}</td>
                                                <td>{{ $user[4] }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal-{{ str_replace(['@', '.'], '-', $user[0]) }}"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{ str_replace(['@', '.'], '-', $user[0]) }}"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="deleteModal-{{ str_replace(['@', '.'], '-', $user[0]) }}" tabindex="-1" aria-labelledby="deleteModal-{{ str_replace(['@', '.'], '-', $user[0]) }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModal-{{ str_replace(['@', '.'], '-', $user[0]) }}Label">DELETE USER</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h1>Yakin ingin menghapus user ini ?</h1>
                                                            <h3>Data yang telah dihapus tidak dapat dikembalikan lagi!!!</h3>
                                                        </div>
                                                        <form action="/pppoe/user/delete" method="post">
                                                            @csrf
                                                            <input type="hidden" name="name" value="{{ $user[0] }}">
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger">DELETE</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="editModal-{{ str_replace(['@', '.'], '-', $user[0]) }}" tabindex="-1" aria-labelledby="editModal-{{ str_replace(['@', '.'], '-', $user[0]) }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModal-{{ str_replace(['@', '.'], '-', $user[0]) }}Label">EDIT USER</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="/pppoe/user/update" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="oldname" value="{{ $user[0] }}">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>USERNAME</label>
                                                                    <input type="text" name="username" class="form-control" value="{{ $user[0] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>PASSWORD</label>
                                                                    <input type="text" name="password" class="form-control" value="{{ $user[1] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>PROFILE NAME</label>
                                                                    <select name="profile" class="form-control" required>
                                                                        <option value="">PILIH PROFILE USER</option>
                                                                        @foreach ($profiles as $profile)
                                                                            <option {{ $profile->username == $user[2] ? 'selected' : '' }} value="{{ $profile->username }}">{{ $profile->username }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>SERVER</label>
                                                                    <input type="text" name="servername" class="form-control" value="{{ $user[3] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>EXPIRED AT</label>
                                                                    <input type="date" name="exp" class="form-control" value="{{ date('Y-m-d', strtotime($user[4])) }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
    <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">TAMBAH USER BARU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/pppoe/user/add" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>USERNAME</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>PASSWORD</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>PROFILE NAME</label>
                            <select name="profile" class="form-control" required>
                                <option value="">PILIH PROFILE USER</option>
                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile->username }}">{{ $profile->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>SERVER</label>
                            <input type="text" name="servername" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>EXPIRED AT</label>
                            <input type="date" name="exp" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('#example').DataTable({
            responsive: true,
            ordering: false,
        });

        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });
    </script>
@endsection
