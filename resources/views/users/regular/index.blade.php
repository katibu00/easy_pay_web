@extends('layouts.app')
@section('pageTitle', 'Regular Users')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Regular Users</h5>
                </div>
                <div class="card-body p-4">
                    <hr />


                    <div class="table-responsive">
                        @include('users.regular.table')
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="manualFundingModal" tabindex="-1" aria-labelledby="manualFundingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="block-title" id="manualFundingModalLabel">Manual Funding for <span id="userName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="manualFundingForm">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitManualFunding">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="manualFundingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="block-title" id="changePasswordModalLabel">Change Password for <span id="changePasswordUsername"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitChangePassword">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    <script src="/jquery-3.3.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();

            $('.manual-funding').on('click', function(e) {
                e.preventDefault();

                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');

                $('#userName').text(userName);
                $('#manualFundingModal').modal('show');

                // Store the userId and userName in the submit button's data attributes
                $('#submitManualFunding').data('user-id', userId);
                $('#submitManualFunding').data('user-name', userName);

            });

            $('#submitManualFunding').on('click', function() {
                var amount = $('#amount').val();
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');
                var $button = $(this);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('manual-funding') }}',
                    method: 'POST',
                    data: {
                        userId: userId,
                        userName: userName,
                        amount: amount
                    },
                    beforeSend: function() {
                        $button.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        $button.prop('disabled', true);
                    },
                    success: function(response) {

                        $('#manualFundingForm')[0].reset();
                        $('#manualFundingModal').modal('hide');
                        $('.table').load(location.href + ' .table');

                        $button.html('Done');
                        $button.prop('disabled', false);
                        toastr.success('Manual funding submitted successfully');

                    },
                    error: function(xhr, status, error) {
                        // Handle the error case (if any)                            

                    }
                });

            });

            // Click event for "Change Password" button
            $('.change-password').on('click', function() {
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');

                $('#changePasswordUsername').text(userName);
                $('#submitChangePassword').data('user-id', userId);
                $('#changePasswordModal').modal('show');

                // Store the userId in the submit button's data attribute
                $('#submitChangePassword').data('user-id', userId);
            });

            // Click event for "Submit" button in Change Password modal
            $('#submitChangePassword').on('click', function() {
                var userId = $(this).data('user-id');
                var newPassword = $('#newPassword').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // AJAX request to change password
                $.ajax({
                    url: '{{ route('change-password') }}', // Replace with your actual backend endpoint
                    method: 'POST',
                    data: {
                        userId: userId,
                        newPassword: newPassword
                    },
                    beforeSend: function() {
                        // Disable the submit button
                        $('#submitChangePassword').prop('disabled', true);
                    },
                    success: function(response) {
                        // Reset the form and close the modal
                        $('#changePasswordForm')[0].reset();
                        $('#changePasswordModal').modal('hide');

                        // Enable the submit button
                        $('#submitChangePassword').prop('disabled', false);

                        // Display a success message
                        toastr.success('Password changed successfully');
                    },
                    error: function(xhr, status, error) {
                        // Enable the submit button
                        $('#submitChangePassword').prop('disabled', false);

                        // Display validation errors if available
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    toastr.error(errors[key][0]);
                                }
                            }
                        } else {
                            // Display a generic error message
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });

        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.deleteItem').on('click', function() {
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete user "${userName}". This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed the deletion, perform the delete operation
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/users/' +
                            userId, // Replace with your actual delete endpoint
                            method: 'DELETE',
                            success: function(response) {
                                // Handle the success case, e.g., show a success message
                                Swal.fire({
                                    title: 'User Deleted',
                                    text: `User "${userName}" has been successfully deleted.`,
                                    icon: 'success'
                                }).then(() => {
                                    // Refresh the page or update the table as needed
                                    location
                                .reload(); // Reload the page to update the user list
                                    // $('.table').load(location.href + ' .table'); // Update the table content
                                });
                            },
                            error: function(xhr, status, error) {
                                // Handle the error case, e.g., show an error message
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred while deleting the user.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>


@endsection
