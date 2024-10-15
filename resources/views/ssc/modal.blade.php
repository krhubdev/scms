<div class="modal fade zoom" tabindex="-1" id="modalDefault">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>

            <form action="{{ route('event.save') }}" method="POST" autocomplete="off" class="mb-0">
                <div class="modal-header">
                    <h5 class="modal-title">Create Event</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_et">Event Title <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Event Title here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-info"></em>
                                </div>
                                <input type="text" required class="form-control" id="inp_et" name="inp_et"
                                    placeholder="Enter (required) Event Title here.. ">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_ed">Event Description <small
                                        class="text-secondary">(Optional)</small></label>
                                <span class="form-note">Specify the Event Description here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-group">
                                <textarea class="form-control" rows="2" name="inp_ed" placeholder="Enter Description here..">-</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_esd">Event Start Date <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Event Start Date here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap focused">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-calendar-alt"></em>
                                </div>
                                <input type="text" name="inp_esd" id="inp_esd" onchange="checkDate(this.value)"
                                    required data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD"
                                    class="form-control date-picker">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_eed">Event End Date <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Event End Date here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap focused">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-calendar-alt"></em>
                                </div>
                                <input type="text" name="inp_eed" id="inp_eed" onchange="checkEndDate(this.value)"
                                    required data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD"
                                    class="form-control date-picker">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_el">Event Location <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Event Location here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-info"></em>
                                </div>
                                <input type="text" required class="form-control" id="inp_el" name="inp_el"
                                    placeholder="Enter (required) Event Location here.. ">
                            </div>

                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_ca">Course Assign <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Course Assign here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">
                            <select class="form-select" name="inp_ce">
                                <option value="" data-select2-id="3"
                                    style="text-transform: uppercase !important;">-- SELECT COURSE ASSIGN --</option>                                    
                                    <option value="999">All Department</option>
                                @foreach ($courses as $data)
                                    <option value="{{ $data['id'] }}">{{ $data['course_name'] }} {{ $data['course_major'] ? '(' . $data['course_major'] . ')'  : '' }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>


                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group mb-2 justify-end">
                        <button type="reset" class="btn btn-danger btn-lg bg-danger mx-3">
                            <em class="icon ni ni-repeat"></em>
                            &nbsp; Reset
                        </button>
                        <button type="submit" class="btn btn-success btn-lg bg-success">
                            <em class="icon ni ni-save"></em>
                            &nbsp; Register Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function checkDate(date) {
        const start_date = document.getElementById('inp_esd');
        const current_date = "{{ date('Y-m-d') }}";
        if (date <= current_date) {
            Swal.fire({
                title: "Invalid Date",
                text: "You can't select the previous date. Try again.",
                icon: "warning"
            });
            start_date.value = '';
        }
    }

    function checkEndDate(date) {

        const start_date = document.getElementById('inp_esd').value;
        const current_date = "{{ date('Y-m-d') }}";

        // Compare the end date with the start date and the current date
        if (date <= current_date || date <= start_date) {
            Swal.fire({
                title: "Invalid Date",
                text: "End date must be after the start date and the current date.",
                icon: "warning"
            });
            document.getElementById('inp_eed').value = ''; // Clear the end date input
        }
    }
</script>
