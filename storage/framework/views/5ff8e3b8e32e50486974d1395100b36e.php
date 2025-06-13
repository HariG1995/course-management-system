<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <style>
            body {
                background: #f4f6f9;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            .login-card {
                width: 100%;
                max-width: 400px;
                border: none;
                border-radius: 1rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                padding: 2rem;
                background-color: #ffffff;
            }

            .login-card .form-control {
                border-radius: 0.5rem;
            }

            .login-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
            }

            .error_field {
                color: red;
                font-family: math;
                font-size: small;
            }
        </style>
    </head>
    <body>
        <div class="login-card">
            <div class="text-center login-title">Welcome Back 👋</div>
            <form action="/login" method="POST" id="loginForm">
                <div class="mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                    <span class="error_field" id="err_email"></span>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <span class="error_field" id="err_password"></span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Login</button>
                    <span class="error_field" id="login_error" style="text-align: center;"></span>
                </div>
            </form>
        </div>

        <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();
                var errEmail = false;
                var errPassword = false;

                var email = $("#email").val();
                var password = $("#password").val();

                if(!email){
                    errEmail = true;
                    show_error_alert("#err_email", "#email", "email field is required");
                }else{
                    errEmail = false;
                    hide_error_alert("#err_email", "#email", "");
                }

                if(!password){
                    errPassword = true;
                    show_error_alert("#err_password", "#password", "password field is required");
                }else{
                    errPassword = false;
                    hide_error_alert("#err_password", "#password", "");
                }

                if(errEmail == false && errPassword == false){
                    let formData = new FormData(this);
                    formData.append('_token', '<?php echo e(csrf_token()); ?>');

                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "<?php echo e(route('check_login')); ?>",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend:function(){
                            $("#submitBtn").prop("disabled", true).text("Logging in...");
                        },
                        success: function (response) {
                            if (response.status) {
                                window.location.href = response.redirect;
                            } else {
                                $("#login_error").html(response.message).show().delay(5000).fadeOut();
                                $("#submitBtn").prop("disabled", false).text("Login");
                            }
                        },
                        error: function (xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;

                                if (errors.email) {
                                    $("#err_email").text(errors.email[0]);
                                }

                                if (errors.password) {
                                    $("#err_password").text(errors.password[0]);
                                }
                            } else {
                                $("#login_error").html("Something went wrong.").show().delay(5000).fadeOut();
                                console.log(xhr.responseText);
                            }

                            $("#submitBtn").prop("disabled", false).text("Login");
                        }
                    });
                }
            });

            function show_error_alert(errorID, fieldID, message){
                $(errorID).html(message);
                $(fieldID).css("border", "solid 1px red");
            }

            function hide_error_alert(errorID, fieldID, message){
                $(errorID).html("");
                $(fieldID).css("border", "");
            }
        });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/auth/login.blade.php ENDPATH**/ ?>