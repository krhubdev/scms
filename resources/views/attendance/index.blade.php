@extends('theme.layout')
@section('content')
    @php
        $status = session('attendance_status');
        if (empty($status)) {
            session()->put('attendance_status', 'Check-In');
            $html_status = '<b class="text-success">Check-In</b>';
        } else {
            if ($status == 'Check-In') {
                $html_status = '<b class="text-success">Check-In</b>';
            } else {
                $html_status = '<b class="text-danger">Check-Out</b>';
            }
        }
    @endphp
    <style>
        .mobile-view {
            display: block;
        }

        @media only screen and (max-width: 767px) {
            .mobile-view {
                display: none
            }
        }
    </style>
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ $course->course_name }}</h3>
                        <p>A part of an organization for activies & attendance monitoring.</p>
                    </div>
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="drodown">
                                            <a href="#"
                                                class="dropdown-toggle dropdown-indicator btn btn-outline-light btn-white"
                                                data-bs-toggle="dropdown">
                                                <em class="icon ni ni-list-index-fill"></em> &ensp; Change Attendance Status
                                                : ( {!! $html_status !!} )
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="/attendance/check/in"><span>Check-In</span></a></li>
                                                    <li><a href="/attendance/check/out"><span>Check-Out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-block ">
                <div class="row g-gs">
                    <div class="col-sm-9">
                        <div class="card h-100">
                            <div class="card-inner">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><em class="icon ni ni-info"></em>&ensp; {{ $event->event_name }}</td>
                                        <td class="mobile-view" width="250"><em class="icon ni ni-calendar"></em>&ensp;
                                            {{ date_format(date_create($event->event_start_date), 'F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><em class="icon ni ni-map-pin"></em>&ensp; {{ $event->event_location }}</td>
                                        <td class="mobile-view"><em class="icon ni ni-calendar"></em>&ensp;
                                            {{ date_format(date_create($event->event_end_date), 'F d, Y') }}</td>
                                    </tr>
                                </table>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <input type="text" id="sid" onkeypress="keyenter(event)"
                                            placeholder="Search student id number here.." class="form-control">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" onclick="search(document.getElementById('sid').value)"
                                            class="btn  btn-light bg-white btn-block" style="float: right">
                                            <em class="icon ni ni-search"></em>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-light bg-white btn-block" onclick="qr_scan()"
                                            style="float: right" data-bs-toggle="modal" data-bs-target="#qr-scanner">
                                            <em class="icon ni ni-qr"></em>
                                            &nbsp; Scan QR Code
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-9">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="180" class="text-end mobile-view">Student ID # :</td>
                                                <td><b class="text-dark" id="student_id">-</b></td>
                                            </tr>
                                            <tr>
                                                <td width="180" class="text-end mobile-view">Student Name :</td>
                                                <td><b class="text-dark" id="student_name">-</b></td>
                                            </tr>
                                            <tr>
                                                <td width="180" class="text-end mobile-view">Course & Year Level :</td>
                                                <td><b class="text-dark" id="student_course_yr">-</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" class=" text-end"><span class="text-dark"
                                                        style="font-size: 13px" id="datetime">-</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end">Status :</td>
                                                <td>{!! $html_status !!}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-end">Confirmation :</td>
                                                <td>
                                                    <b class="text-dark" id="confirmation">
                                                        -
                                                    </b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card h-100">
                            <div class="card-inner">
                                <center>
                                    {!! $qrCode !!}
                                </center>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card h-100">
                            <div class="card-inner">
                                <div id="attendance">
                                    <table class="datatable-init-export nowrap table table-hover"
                                        data-export-title="Export">
                                        <thead>
                                            <tr>
                                                <th width="20">#</th>
                                                <th width="150">Student ID</th>
                                                <th>Student Name</th>
                                                <th width="210">Date & Time Check-In</th>
                                                <th width="210">Date & Time Check-Out</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $num = 1;
                                            @endphp
                                            @foreach ($attendance as $data)
                                                <tr>
                                                    <td>{{ $num++ }}.</td>
                                                    <td>{{ $data->attend_student_id }}</td>
                                                    <td>{{ $data->attend_student_name }}</td>
                                                    <td>{{ date_format(date_create($data->attend_checked_in_at), 'M. d, Y h:i:s A') }}
                                                    </td>
                                                    @if ($data->attend_checked_out_at != null)
                                                        <td>{{ date_format(date_create($data->attend_checked_out_at), 'M. d, Y h:i:s A') ?? '' }}
                                                        </td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
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

        @include('attendance.modal')

    </div>

    <script>
        function search(id) {
            //const student_id = document.getElementById('sid').value;

            default_result()

            $.ajax({
                type: 'POST',
                url: '/api/search',
                data: {
                    id: id,
                    token: "{{ session('access_token') }}",
                },
                success: function(response) {
                    success_result(response)
                },
                error: function(err) {
                    error_result()
                }
            });
        }

        function default_result() {
            document.getElementById('student_id').innerHTML = '<em class="icon ni ni-clock"></em> <i>Please wait..</i>'
            document.getElementById('student_name').innerHTML = '<em class="icon ni ni-clock"></em> <i>Please wait..</i>'
            document.getElementById('student_course_yr').innerHTML =
                '<em class="icon ni ni-clock"></em> <i>Please wait..</i>'
            document.getElementById('confirmation').innerHTML = '-';
        }

        function success_result(response) {
            document.getElementById('student_id').innerHTML = response['id']
            document.getElementById('student_name').innerHTML = response['name']

            if (response['course_description'] == '{{ $course->course_name }}') {

                document.getElementById('student_course_yr').innerHTML = response['course'] + ' (' +
                    response['year_level'] + ')'


                document.getElementById('confirmation').innerHTML =
                    '<center><button class="btn btn-xs btn-success" onclick="save()"><em class="icon ni ni-check"></em></button>&nbsp;&nbsp;<button class="btn btn-xs btn-danger"><em class="icon ni ni-cross"></em></button> </center>'

            } else {
                document.getElementById('student_course_yr').innerHTML =
                    '<i class="text-danger fw-normal">This student is belong to the<i class="fw-bolder"> `' + response[
                    'course'] + '` </i> Department. Please try another. Thank you.</i>'
            }

        }

        function error_result() {
            console.log('Sorry, you have unauthorized access.');
            document.getElementById('student_id').innerHTML =
                '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
            document.getElementById('student_name').innerHTML =
                '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
            document.getElementById('student_course_yr').innerHTML =
                '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
            document.getElementById('confirmation').innerHTML = '-';
        }

        function keyenter(event) {
            if (event.key === "Enter" || event.keyCode === 13) {
                const student_id = document.getElementById('sid').value;
                search(student_id);
            }
        }

        function save() {
            const id = document.getElementById('student_id').innerHTML
            const name = document.getElementById('student_name').innerHTML
            const status = "{{ $status }}"
            const event = "{{ $event_id }}"

            $.ajax({
                type: 'POST',
                url: '/api/save',
                data: {
                    id: id,
                    name: name,
                    status: status,
                    event: event,
                },
                success: function(response) {
                    console.log(response)
                    Swal.fire({
                        title: response['message'],
                        text: response['content'],
                        icon: response['status'],
                        showConfirmButton: false // Optionally hide the confirm button
                    });
                    if (response['status'] == 'success') {
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function(err) {
                    console.log('Sorry, you have unauthorized access.');
                }
            });
        }

        function updateDateTime() {
            const now = new Date();
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const dayName = days[now.getDay()];
            const day = String(now.getDate()).padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;
            hours = String(hours).padStart(2, '0');

            const formattedDate = `${dayName}, ${month}. ${day}, ${year}`;
            const formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;

            document.getElementById('datetime').textContent = `${formattedDate} ${formattedTime}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
@endsection
