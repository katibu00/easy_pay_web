<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="/admin/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="/admin/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="/admin/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="/admin/css/pace.min.css" rel="stylesheet" />
	<script src="/admin/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="/admin/css/bootstrap.min.css" rel="stylesheet">
	<link href="/admin/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="/admin/css/app.css" rel="stylesheet">
	<link href="/admin/css/icons.css" rel="stylesheet">
	<title>Marvenus - Login</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							Marvenus
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										{{-- <p>Don't have an account yet? <a href="authentication-signup.html">Sign up here</a> --}}
										</p>
									</div>
									<div class="d-grid">
										<a class="btn my-4 shadow-sm btn-white" href="javascript:;"> <span class="d-flex justify-content-center align-items-center">
                          <img class="me-2" src="/admin/images/icons/search.svg" width="16" alt="Image Description">
                          <span>Sign in with Google</span>
											</span>
										</a> <a href="javascript:;" class="btn btn-facebook"><i class="bx bxl-facebook"></i>Sign in with Facebook</a>
									</div>
									<div class="login-separater text-center mb-4"> <span>OR SIGN IN WITH EMAIL</span>
										<hr/>
									</div>
									<div class="form-body">
										<form class="row g-3" id="login-form">
                                            @csrf
											<div class="col-12">
												<label for="email_or_phone" class="form-label">Email or Phone</label>
												<input type="text" class="form-control" id="email_or_phone" name="email_or_phone" placeholder="Email or Phone">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" id="inputChoosePassword" name="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="rememberMe" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div>
											<div class="col-md-6 text-end">	<a href="#">Forgot Password ?</a>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="/admin/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/admin/js/jquery.min.js"></script>
	<script src="/admin/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/admin/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->

    <script>
        $(document).ready(function() {
         $('#login-form').submit(function(event) {
             event.preventDefault();
             var submitButton = $(this).find('button[type="submit"]');
             submitButton.prop('disabled', true).html(
                 '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait...'
             );

             var formData = new FormData(this);
             $.ajax({
                 url: '/login',
                 type: 'POST',
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function(response) {
                     submitButton.prop('disabled', false).text('Sign in');

                     if (response.success) {
                         Swal.fire({
                             icon: 'success',
                             title: 'Login Successful',
                             text: 'Redirecting to dashboard...',
                             timer: 2000,
                             timerProgressBar: true,
                             showConfirmButton: false,
                             didOpen: () => {
                                 setTimeout(() => {
                                     window.location.href = response.redirect_url;
                                 }, 500);
                             }
                         });
                     } else {
                         Swal.fire({
                             icon: 'error',
                             title: 'Invalid Credentials',
                             text: 'Please check your email/phone and password.',
                         });
                     }
                 },
                 error: function(xhr, status, error) {
                     submitButton.prop('disabled', false).text('Sign in');

                     var response = xhr.responseJSON;
                     if (response && response.errors && response.errors.login_error) {
                         Swal.fire({
                             icon: 'warning',
                             title: 'Login Error',
                             text: response.errors.login_error[0]
                         });
                     } else if (response && response.message) {
                         Swal.fire({
                             icon: 'error',
                             title: 'Error',
                             text: response.message
                         });
                     } else {
                         Swal.fire({
                             icon: 'error',
                             title: 'An Error Occurred',
                             text: 'Please try again later.'
                         });
                     }
                 }
             });
         });
     });
 </script>

	<script src="/admin/js/app.js"></script>
</body>

</html>