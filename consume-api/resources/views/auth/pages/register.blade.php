@extends('auth/layout/template')
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <div class="login-brand">
                        <img src="../assets/img/stisla-fill.svg" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>

                        <div class="card-body">
                            <form id="registrationForm">
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input id="name" type="text" class="form-control" name="name" autofocus>
                                    <div class="invalid-feedback errorName">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    <div class="invalid-feedback errorEmail">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="password" class="d-block">Password</label>
                                        <input id="password" type="password" class="form-control"
                                            data-indicator="pwindicator" name="password">
                                        <div class="invalid-feedback errorPassword">
                                        </div>
                                        <div id="pwindicator" class="pwindicator">
                                            <div class="bar"></div>
                                            <div class="label"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="password_confirm" class="d-block">Password Confirmation</label>
                                        <input id="password_confirm" type="password" class="form-control"
                                            name="password_confirm">
                                        <div class="invalid-feedback errorPasswordConfirm">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#registrationForm').submit(function(e) {
            e.preventDefault()
            $.ajax({
                type: "post",
                url: "http://127.0.0.1:8000/api/register",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.name) {
                            $('#name').addClass('is-invalid')
                            $('.errorName').html(response.error.name)
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid')
                            $('.errorEmail').html(response.error.email)
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid')
                            $('.errorPassword').html(response.error.password)
                        }
                        if (response.error.password_confirm) {
                            $('#password_confirm').addClass('is-invalid')
                            $('.errorPasswordConfirm').html(response.error.password_confirm)
                        }
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        window.location.href = "{{ URL::to('/') }}";
                    }
                }
            });
        })
    </script>
@endsection
