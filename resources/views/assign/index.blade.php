@extends('theme.layout')
@section('content')
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Account Management</h3>
                        <p>Account management is the process of creating and maintaining an user account.</p>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                                <em class="icon ni ni-menu-alt-r"></em>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block ">
                <div class="row g-gs">
                    <div class="col-sm-12">
                        <div class="card h-100">
                            <div class="card-inner">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <b><em class="icon ni ni-check"></em></b> {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <button type="button" class="btn btn-primary" style="float: right" data-bs-toggle="modal"
                                    data-bs-target="#modalDefault">
                                    <em class="icon ni ni-plus-circle"></em>
                                    &nbsp; New Event
                                </button>
                                <table class="datatable-init-export nowrap table table-hover" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th width="20">#</th>
                                            <th width="80">Student ID</th>
                                            <th>Student Name</th>
                                            <th>Department</th>
                                            <th>Account Type</th>
                                            <th width="150">Date Registered</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num = 1;
                                        @endphp
                                        @foreach ($assign as $rw)
                                            <tr data-bs-toggle="modal" data-bs-target="#view" style="cursor: pointer"
                                                onclick="details({{ $rw->student_id }})">
                                                <td>{{ $num++ }}.</td>
                                                <td>{{ $rw->student_id }}</td>
                                                <td>{{ $rw->student_name }}</td>
                                                <td>{{ $rw->course_name }}</td>
                                                <td>{{ $rw->assign_type }}</td>
                                                <td>{{ date_format(date_create($rw->created_at), 'F d Y h:i A') }}</td>
                                                <td><button class="btn btn-xs btn-light btn-block bg-white"><em
                                                            class="icon ni ni-eye"></em></button></td>
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

        <script>
            function link(id) {
                window.location.href = '/attendance/' + id;
            }
        </script>
        @include('assign.modal', ['courses' => []])

    </div>

@endsection
