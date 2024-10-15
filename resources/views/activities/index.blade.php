@extends('theme.layout')
@section('content')
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Acitvity (Student Body Organization)</h3>
                        <p>Activity management is the process of monitoring and maintaining an activity.</p>
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
                                @if ($dsas)
                                    <select class="form-select" style="float: right; width: 31%"
                                        onclick="filter(this.value)">
                                        <option value="" data-select2-id="3"
                                            style="text-transform: uppercase !important;">Filter Courses</option>
                                        @foreach ($courses as $data)
                                            <option value="{{ $data['id'] }}">{{ $data['course_name'] }}
                                                {{ $data['course_major'] ? '(' . $data['course_major'] . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                <table class="datatable-init-export nowrap table table-hover" data-export-title="Export">
                                    <thead>
                                        <tr>
                                            <th width="20">#</th>
                                            <th>Activities</th>
                                            <th>Departments</th>
                                            <th width="150">Date Start</th>
                                            <th width="150">Date End</th>
                                            <th width="150">Status</th>
                                            <th width="50">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $num = 1;
                                        @endphp
                                        @foreach ($events as $event)
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
                                                    $bg_status = 'bg-success';
                                                } elseif ($current_date < $start_date) {
                                                    // Upcoming event
                                                    $days_until_event = $start_date->diff($current_date)->days;
                                                    $days_until_event == 0
                                                        ? ($status = 'Event is already started.')
                                                        : ($status = "$days_until_event day(s) until the event starts");

                                                    $days_until_event == 0
                                                        ? ($bg_status = 'bg-success')
                                                        : ($bg_status = 'bg-warning');
                                                } else {
                                                    // Event has passed
                                                    $days_since_event = $current_date->diff($end_date)->days;
                                                    $days_since_event == 0
                                                        ? ($status = '1 day(s) since the event ended')
                                                        : ($status = "$days_since_event day(s) since the event ended");
                                                    $bg_status = 'bg-light text-dark';
                                                }

                                            @endphp
                                            <tr style="cursor: pointer" onclick="link({{ $event->eid }})">
                                                <td>{{ $num++ }}.</td>
                                                <td>{{ $event->event_name }}</td>
                                                <td><em class="asterisk-off icon ni ni-star-fill text-warning""></em>&ensp;
                                                    {{ $event->course_name ?? '-' }}</td>
                                                <td>{{ date_format(date_create($event->event_start_date), 'M. d Y') }}</td>
                                                <td>{{ date_format(date_create($event->event_end_date), 'M. d Y') }}</td>
                                                <td>
                                                    <span style="width: 100%"
                                                        class="badge badge-sm badge-dot has-bg {{ $bg_status }} d-none d-sm-inline-flex">
                                                        {{ $status }}
                                                    </span>
                                                </td>
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

            function filter(id) {
                if (id) {
                    window.location.href = '/activity/list/filter/' + id;
                }
            }
        </script>

    </div>

@endsection
