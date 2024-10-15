@extends('theme.layout')
@section('content')
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Welcome!</h3>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-menu-alt-r"></em></a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="nk-block ">
                <div class="row g-gs">
                    <div class="col-md-3">
                        <div class="card is-dark h-100">
                            <div class="nk-ecwg nk-ecwg1">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Total No. of Schools</h6>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div><!-- .nk-ecwg -->
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card h-100">
                            <div class="card-inner pb-1" style="min-height: 50px">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <a href="/teacher/students/" class="d-flex align-items-center">
                                        <div class="user-avatar sq bg-primary">
                                            <span style="text-transform: uppercase;">
                                                <em class="ni ni-users"></em>
                                            </span>
                                        </div>
                                        <div class="ms-3">
                                            No. of Registered Accounts
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <center>
                                
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="card h-100">
                            <div class="card-inner pb-1" style="min-height: 50px">
                                <center>
                                    <img src="/deped seal.webp" alt="" height="130">
                                    <hr>
                                    <h5 style="letter-spacing: 2px;">SCHOOL YEAR : <b>2023-2024</b></h5>
                                </center>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card h-100">
                            <div class="card-inner">
                                <a class="btn btn-primary d-none d-md-inline-flex" style="float: right"
                                    href="/admin/schools?register"><em class="icon ni ni-plus"></em><span>Register
                                        School</span></a>
                                <table class="datatable-init table">
                                    <thead>
                                        <tr>
                                            <th>School ID</th>
                                            <th>School Name</th>
                                            <th>School Region</th>
                                            <th>School Address</th>
                                            <th width="100">
                                                <center>...</center>
                                            </th>
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
        </div>

        <script>
            function quarter(type) {
                $.ajax({
                    url: '/api/quarter',
                    type: 'POST',
                    data: {
                        push_type: type
                    },
                    success: function(data) {
                        console.log(data);
                        //window.location.href = data;
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        </script>
    @endsection
