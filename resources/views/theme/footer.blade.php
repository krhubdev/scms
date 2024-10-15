<script>
    function confirmation(id, type) {
        var userResponse = confirm("Are you sure?\nOnce deleted, you will not be able to recover this record!");
        if (userResponse) {
            $.ajax({
                url: '/api/delete',
                type: 'POST',
                data: {
                    push_id: id,
                    push_type: type
                },
                success: function(data) {
                    window.location.href = data;
                },
                error: function(err) {
                    alert(err);
                }
            });
        } else {

        }
    }
</script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Saved Successfully',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ $errors->first() }}',
            text: '',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="modalDefault">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update.password') }}" method="POST">
                    @csrf
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_cp">Current Password <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Current Password here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-info"></em>
                                </div>
                                <input required type="password" class="form-control" id="inp_cp" name="inp_cp"
                                    placeholder="Enter Current Password here.. ">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_np">New Password <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the New Password here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-info"></em>
                                </div>
                                <input required type="password" class="form-control" id="inp_np" name="inp_np"
                                    placeholder="Enter New Password here.. ">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-2 align-center">
                        <div class="col-lg-5">

                            <div class="form-group">
                                <label class="form-label" for="inp_rp">Repeat Password <b
                                        class="text-danger">*</b></label>
                                <span class="form-note">Specify the Repeat Password here.</span>
                            </div>

                        </div>
                        <div class="col-lg-7">

                            <div class="form-control-wrap">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-info"></em>
                                </div>
                                <input required type="password" class="form-control" id="inp_rp" name="inp_rp"
                                    placeholder="Enter Repeat Password here.. ">
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-5">
                    </div>
                    <div class="col-lg-7" style="float: right">
                        <hr>
                    </div>

                    <div class="col-lg-5">
                    </div>
                    <div class="col-lg-7 justify-end" style="float: right">
                        <hr>
                        <div class="form-group mt-2 mb-2 justify-end">
                            <button type="reset" class="btn btn-light bg-white mx-3">
                                <em class="icon ni ni-repeat"></em>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-light bg-white">
                                <em class="icon ni ni-save"></em>
                                Submit Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="nk-footer">
    <div class="container-fluid">
        <div class="nk-footer-wrap">
            -
            <div class="nk-footer-copyright">Department of Information Technology &copy; 2024 <a
                    href="https://tcc.edu.ph/" target="_blank" style="color: #b4543d">Tagoloan Community College</a> ❤️
                All Rights Reserved.</div>

        </div>
    </div>
</div>
