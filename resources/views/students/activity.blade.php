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
        <style>.image-container {
            width: 100%;
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .zoomable-image {
            transition: transform 0.5s ease;
        }

        .zoomable-image:hover {
            transform: scale(1.5);
            cursor: zoom-in;
        }
    </style>

    </style>
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">{{ $course->course_name }}</h3>
                        <p>A part of an organization for activies & attendance monitoring.</p>
                    </div>
                </div>
            </div>

            <div class="nk-block ">
                <div class="row g-gs">

                    <div class="col-sm-2">
                        <div class="card h-100">
                            <div class="card-inner">
                                <center>
                                    {!! $qrCode !!}
                                </center>
                                <hr>
                                <button type="button" class="btn btn-md btn-light bg-white btn-block" onclick="qr_scan()"
                                    data-bs-toggle="modal" data-bs-target="#qr-scanner">
                                    <em class="icon ni ni-qr"></em>
                                    &nbsp; Scan QR Code
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <div class="card h-100">
                            <div class="card-inner">
                                <table class="table table-bordered mt-3">
                                    <tr>
                                        <td><em class="icon ni ni-info"></em>&ensp; {{ $event->event_name }}</td>
                                        <td width="250"><em class="icon ni ni-calendar"></em>&ensp;
                                            {{ date_format(date_create($event->event_start_date), 'F d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><em class="icon ni ni-map-pin"></em>&ensp; {{ $event->event_location }}</td>
                                        <td><em class="icon ni ni-calendar"></em>&ensp;
                                            {{ date_format(date_create($event->event_end_date), 'F d, Y') }}</td>
                                    </tr>
                                </table>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="180" class="text-end">Student ID # :</td>
                                                <td><b class="text-dark">{{ session('student_id') }}</b></td>
                                            </tr>
                                            <tr>
                                                <td width="180" class="text-end">Student Name :</td>
                                                <td><b class="text-dark">{{ session('student_name') }}</b></td>
                                            </tr>
                                            <tr>
                                                <td width="180" class="text-end">Course & Year Level :</td>
                                                <td><b class="text-dark">{{ session('student_course') }}
                                                        ({{ session('student_year_level') }})</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    @php
                        $start_date = new DateTime($event->event_start_date);
                        $end_date = new DateTime($event->event_end_date);
                        $current_date = new DateTime();

                        // Check if the current date is within the event period
                        if ($current_date >= $start_date && $current_date <= $end_date) {
                            // Ongoing event
                            $remaining_days = $end_date->diff($current_date)->days;
                            $remaining_days == 0
                                ? ($status = '1 day(s) left in the event')
                                : ($status = "$remaining_days day(s) left in the event");
                            $bg_status = 'alert-success';
                        } elseif ($current_date < $start_date) {
                            // Upcoming event
                            $days_until_event = $start_date->diff($current_date)->days;
                            $days_until_event == 0
                                ? ($status = 'Event is already started.')
                                : ($status = "$days_until_event day(s) until the event starts");

                            $days_until_event == 0 ? ($bg_status = 'alert-success') : ($bg_status = 'alert-warning');
                        } else {
                            // Event has passed
                            $days_since_event = $current_date->diff($end_date)->days;
                            $days_since_event == 0
                                ? ($status = '1 day(s) since the event ended')
                                : ($status = "$days_since_event day(s) since the event ended");
                            $bg_status = 'alert-secondary text-dark';
                        }

                    @endphp

                    <div class="col-sm-12">

                        <div class="alert {{$bg_status}} alert-icon">
                            <em class="icon ni ni-alert-circle"></em> {{ $status }}
                        </div>

                        <div class="card h-10x0">
                            <div class="card-inner">
                                <div id="attendance">
                                    <table class="datatable-init nowrap table table-hover">
                                        <thead>
                                            <tr>
                                                <th width="20">#</th>
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

                    <div class="rowx    ">
                        @if ($feedback == null)
                            <div class="col-sm-12">
                                <div class="card card-borderedx">
                                    <div class="card-inner">
                                        <h4 class="card-title mb-1">
                                            <em class="icon ni ni-chat-circle"></em> Give Us Your Feedback
                                        </h4>
                                        <div class="rating-wrap my-1">
                                            <span class="amount">Event: {{ $event->event_name }}</span>
                                        </div>
                                        <hr>
                                        <form action="{{ route('feedback.store') }}" method="POST"
                                            enctype="multipart/form-data" class="mt-2">
                                            @csrf <!-- Include CSRF token -->
                                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                                            <!-- Hidden Event ID -->
                                            <div class="form-group">
                                                <label class="form-label" for="review">How was your experience?</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control no-resize" name="review" id="review">I've been happy attending this event!, it's just becoming better. Thank you for such a great activity. Really love it</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="photos">Share Us Your Captured
                                                    Moments!</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" multiple accept="image/*"
                                                            class="form-file-input" id="photos" name="photos[]">
                                                        <label class="form-file-label" for="photos">Choose files</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="card-footer bg-light border-top d-flex align-center justify-content-end py-3">
                                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-12">
                                <hr>
                                <div class="card card-borderedx">
                                    <div class="card-inner">
                                        <div class="d-flex justify-content-between align-items-end mb-2">
                                            <ul class="pt-2 gy-1">
                                                <li><em class="icon ni ni-calender-date"></em><span>28th Sept, 2021</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <h4 class="card-title mb-1"><em
                                                class="icon ni ni-check-circle-cut text-success"></em>
                                            Thank
                                            You For Your Feedback!</h4>
                                        <hr>
                                        <p> <em class="icon ni ni-chat-circle"></em> <i>"I've been happy attending this
                                                event!,
                                                it's
                                                just becoming better. Thank you for such a great activity. Really love
                                                it"</i>
                                        </p>
                                        <hr>
                                        <div class="slider-init"
                                            data-slick='{"arrows": false, "dots": true, "slidesToShow": 3, "slidesToScroll": 1, "infinite":false, "responsive":[ {"breakpoint": 992,"settings":{"slidesToShow": 2}}, {"breakpoint": 768,"settings":{"slidesToShow": 1}} ]}'>
                                            @foreach (json_decode($feedback->file_names) as $photo)
                                                <div class="col">
                                                    <div class="card card-bordered">
                                                        <div class="image-container"
                                                            style="position: relative; overflow: hidden;">
                                                            <img src="{{ asset('uploads/photos/' . $photo) }}"
                                                                class="card-img-top zoomable-image" alt="Feedback Photo"
                                                                style="width: 100%; height: 300px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if (count(json_decode($feedback->file_names)) <= 4)
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="image-container" style=" display: none"
                                                            style="position: relative; overflow: hidden;">
                                                            <img src="/empty.png" class="card-img-top zoomable-image"
                                                                alt=""
                                                                style="width: 100%; height: 300px; object-fit: cover;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('attendance.modal')

@endsection
