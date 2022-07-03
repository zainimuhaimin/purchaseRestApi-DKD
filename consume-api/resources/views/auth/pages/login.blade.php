@extends('auth/layout/template')
@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="../assets/img/stisla-fill.svg" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>

                        <div class="card-body">
                            <form id="loginForm">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                        required autofocus>
                                    <div class="invalid-feedback errorEmail">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2" required>
                                    <div class="invalid-feedback errorPassword">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Don't have an account? <a href={{ url()->current() . '/register' }}>Create One</a>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault()
                $.ajax({
                    type: "post",
                    url: "http://127.0.0.1:8000/api/login",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.invalid) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'warning',
                                title: response.invalid,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            let isToken = response.token
                            let username = response.user.name
                            $.ajax({
                                type: "post",
                                url: "/setToken",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": isToken,
                                    "username": username
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                dataType: "json",
                                success: function(response) {
                                    window.location.href =
                                        "{{ URL::to('/dashboard') }}";
                                }

                            });
                        }
                    }
                });
            })
        });
    </script>
@endsection
