@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Add New Student</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to Students</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="" method="POST" id="studentsForm">
                @csrf
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                                <span class="error_field" id="err_name"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <span class="error_field" id="err_email"></span>
                            </div>
                        </div>
                        <span class="error_field ml-3" id="response_error"></span>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">Save Student</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#studentsForm').on('submit', function (e) {
            e.preventDefault();
            var errName = false;
            var errEmail = false;

            var name = $("#name").val();
            var email = $("#email").val();

            if(!name){
                errName = true;
                show_error_alert("#err_name", "#name", "name field is required");
            }else{
                errName = false;
                hide_error_alert("#err_name", "#name", "");
            }

            if(!email){
                errEmail = true;
                show_error_alert("#err_email", "#email", "email field is required");
            }else{
                errEmail = false;
                hide_error_alert("#err_email", "#email", "");
            }

            if(errName == false && errEmail == false){
                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "{{ route('students.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        $("#submitBtn").prop("disabled", true).text("Loading...");
                    },
                    success: function (response) {
                        if (response.status) {
                            window.location = "{{ route('students.index') }}";
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $("#err_name").text(errors.name[0]);
                            }

                            if (errors.email) {
                                $("#err_email").text(errors.email[0]);
                            }
                        } else {
                            $("#response_error").html("Something went wrong.").show().delay(5000).fadeOut();
                            console.log(xhr.responseText);
                        }

                        $("#submitBtn").prop("disabled", false).text("Save Student");
                    }
                });
            }
        });
    });

    function show_error_alert(errorID, fieldID, message){
        $(errorID).html(message);
        $(fieldID).css("border", "solid 1px red");
    }

    function hide_error_alert(errorID, fieldID, message){
        $(errorID).html("");
        $(fieldID).css("border", "");
    }
    </script>
@endsection