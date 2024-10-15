@extends('theme.layout')
@section('content')
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Generate Reports</h3>
                        <p>Process of monitoring and maintaining an activity.</p>
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
                                @php
                                    $user_type = session('student_assign');
                                    if (Auth::check()) {
                                        $dsas = true;
                                    } else {
                                        $dsas = false;
                                    }
                                @endphp
                                <select class="form-select" style="float: right; width: 31%" onclick="filter(this.value)">
                                    <option value="" data-select2-id="3"
                                        style="text-transform: uppercase !important;">{{ $course_info }}</option>
                                    @foreach ($courses as $data)
                                        <option value="{{ $data['id'] }}">{{ $data['course_name'] }}
                                            {{ $data['course_major'] ? '(' . $data['course_major'] . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <table class="datatable-init-export nowrap table table-hover" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th width="20">#</th>
                                            <th>Activities</th>
                                            <th>Departments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num = 1;
                                        @endphp
                                        @foreach ($events as $event)
                                            <tr style="cursor: pointer" onclick="link({{ $event->eid }})">
                                                <td>{{ $num++ }}.</td>
                                                <td>{{ $event->event_name }}</td>
                                                <td><em class="asterisk-off icon ni ni-star-fill text-warning"></em>&ensp;
                                                    {{ $event->course_name ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-gs mt-1">
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
                                @php
                                    $user_type = session('student_assign');
                                    if (Auth::check()) {
                                        $dsas = true;
                                    } else {
                                        $dsas = false;
                                    }
                                @endphp
                                <select class="form-select" style="float: right; width: 31%" onclick="events(this.value)">
                                    <option value="" data-select2-id="3"
                                        style="text-transform: uppercase !important;">{{ $attendance_info }}</option>
                                    @foreach ($events as $data)
                                        <option value="{{ $data['eid'] }}">{{ $data['event_name'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <table class="datatable-init-export nowrap table table-hover" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th width="20">#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num = 1;
                                        @endphp
                                        @foreach ($attendance as $student)
                                            <tr style="cursor: pointer" onclick="link({{ $student->attend_student_id }})">
                                                <td>{{ $num++ }}.</td>
                                                <td>{{ $student->attend_student_id }}</td>
                                                <td><em class="asterisk-off icon ni ni-user text-dark"></em>&ensp;
                                                    {{ $student->attend_student_name ?? '-' }}
                                                </td>
                                                <td>{{ date_format(date_create($student->attend_checked_in_at), 'D, M d, Y h:i A') }}
                                                </td>
                                                <td>{{ date_format(date_create($student->attend_checked_out_at), 'D, M d, Y h:i A') }}
                                                </td>
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

            function filter(id) {
                if (id) {
                    window.location.href = '/reports/filter/' + id;
                }
            }

            function events(id) {
                if (id) {
                    window.location.href = '/reports/event/' + id;
                }
            }
        </script>

    </div>

@endsection
