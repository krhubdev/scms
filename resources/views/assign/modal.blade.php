<div class="modal fade zoom" tabindex="-1" id="modalDefault">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>

            <form action="{{ route('assign.save') }}" method="POST" autocomplete="off" class="mb-0">
                <div class="modal-header">
                    <h5 class="modal-title">Assign User Incharge</h5>
                </div>
                <div class="modal-body">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="180" class="text-end">Student ID # :</td>
                                    <td><b class="text-dark" id="student_id">-</b></td>
                                </tr>
                                <tr>
                                    <td width="180" class="text-end">Student Name :</td>
                                    <td><b class="text-dark" id="student_name">-</b></td>
                                </tr>
                                <tr>
                                    <td width="180" class="text-end">Course & Year Level :</td>
                                    <td><b class="text-dark" id="student_course_yr">-</b></td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_et"> Student ID <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Student ID here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-search"></em>
                                </div>
                                <input type="numer" required class="form-control" id="inp_sid"
                                    name="inp_sid" placeholder="Search (required) Student ID here.. ">

                                <input type="hidden" value="" required class="form-control" id="inp_name"
                                    name="inp_name" placeholder="Search (required) Student ID here.. ">

                                <input type="hidden" value="" required class="form-control" id="inp_course"
                                    name="inp_course" placeholder="Search (required) Student ID here.. ">
                            </div>

                        </div>
                    </div>

                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_et">User Type <b class="text-danger">*</b></label>
                                <span class="form-note">Specify the User Type here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <select name="inp_assign" id="inp_assign" required class="form-select">
                                    <option value="" disabled selected>-</option>
                                    <option>Suprime Student Counsel</option>
                                    <option>Student Body Organization</option>
                                </select>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer bg-light">
                    <button type="button" id="search_id" onclick="search(0)" class="btn btn-primary btn-lg bg-primary">
                        <em class="icon ni ni-search"></em>
                    </button>
                    <button type="submit" id="submit" style="display: none;"
                        class="btn btn-success btn-lg bg-success">
                        <em class="icon ni ni-save"></em>
                    </button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>

<div class="modal fade zoom" tabindex="-1" id="view">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Incharge Information</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr>
                                <td width="180" class="text-end">Student ID # :</td>
                                <td><b class="text-dark" id="student_id_x">-</b></td>
                            </tr>
                            <tr>
                                <td width="180" class="text-end">Student Name :</td>
                                <td><b class="text-dark" id="student_name_x">-</b></td>
                            </tr>
                            <tr>
                                <td width="180" class="text-end">Course :</td>
                                <td><b class="text-dark" id="student_course_yr_x">-</b></td>
                            </tr>
                            <tr>
                                <td width="180" class="text-end">User Role :</td>
                                <td>
                                    <div class="form-control-wrap">
                                        <select name="inp_assign" id="inp_assign_x" required class="form-select">
                                            <option value="Suprime Student Counsel">Suprime Student Counsel</option>
                                            <option value="Student Body Organization">Student Body Organization
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" id="search_id" onclick="remove()" class="btn btn-danger btn-lg bg-danger">
                    <em class="icon ni ni-trash"></em>
                </button>
                <button type="submit" id="submit" onclick="update()" class="btn btn-success btn-lg bg-success">
                    <em class="icon ni ni-save"></em>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function remove() {
        const id = document.getElementById('student_id_x').innerHTML;
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/api/delete',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Record has been deleted.",
                            icon: "success"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            }
        });
    }

    function update() {
        const id = document.getElementById('student_id_x').innerHTML;
        const type = document.getElementById('inp_assign_x').value;
        Swal.fire({
            title: "Are you sure?",
            text: "You can able to revert this anyway.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '/api/update',
                    data: {
                        id: id,
                        type: type
                    },
                    success: function(response) {
                        Swal.fire({
                            title: "Updated!",
                            text: "Record has been updated.",
                            icon: "success"
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    }
                });
            }
        });
    }

    function details(id) {
        $.ajax({
            type: 'POST',
            url: '/api/details',
            data: {
                id: id
            },
            success: function(response) {
                document.getElementById('student_id_x').innerHTML = response['student_id']
                document.getElementById('student_name_x').innerHTML = response['student_name']
                document.getElementById('student_course_yr_x').innerHTML = response['course_name']
                document.getElementById('inp_assign_x').value = response['assign_type']
            }
        });
    }

    function search(id) {
        const student_id = document.getElementById('inp_sid').value;

        default_result()

        $.ajax({
            type: 'POST',
            url: '/api/search',
            data: {
                id: student_id,
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
    }

    function success_result(response) {
        document.getElementById('student_id').innerHTML = response['id']

        document.getElementById('submit').style.display = 'block';
        document.getElementById('search_id').style.display = 'none';

        document.getElementById('student_name').innerHTML = response['name']
        document.getElementById('inp_name').value = response['name']
        document.getElementById('inp_course').value = response['course_id']

        document.getElementById('student_course_yr').innerHTML = response['course'] + ' (' +
            response['year_level'] + ')'

    }

    function error_result() {
        console.log('Sorry, you have unauthorized access.');
        document.getElementById('student_id').innerHTML =
            '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
        document.getElementById('student_name').innerHTML =
            '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
        document.getElementById('student_course_yr').innerHTML =
            '<em class="icon ni ni-history"></em> <i>Please try again.</i>'
        document.getElementById('inp_name').value = ""
    }
</script>
