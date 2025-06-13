

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Update Course</h1>
        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-secondary">Back to Courses</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="" method="POST" id="courseForm">
                <?php echo csrf_field(); ?>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e($course->name); ?>">
                                <span class="error_field" id="err_name"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="fee" class="form-label">Course Fee</label>
                                <input type="number" step="0.01" class="form-control" id="fee" name="fee" value="<?php echo e($course->fee); ?>">
                                <span class="error_field" id="err_fee"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($course->category_id == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="error_field" id="err_category"></span>
                            </div>
                        </div>
                        <span class="error_field ml-3" id="response_error"></span>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Update Course</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#courseForm').on('submit', function (e) {
            e.preventDefault();
            var errName = false;
            var errFee = false;
            var errCategory = false;

            var name = $("#name").val();
            var fee = $("#fee").val();
            var category = $("#category_id").val();

            if(!name){
                errName = true;
                show_error_alert("#err_name", "#name", "name field is required");
            }else{
                errName = false;
                hide_error_alert("#err_name", "#name", "");
            }

            if(!fee){
                errFee = true;
                show_error_alert("#err_fee", "#fee", "fee field is required");
            }else{
                errFee = false;
                hide_error_alert("#err_fee", "#fee", "");
            }

            if(!category){
                errCategory = true;
                show_error_alert("#err_category", "#category_id", "category field is required");
            }else{
                errCategory = false;
                hide_error_alert("#err_category", "#category_id", "");
            }

            if(errName == false && errFee == false && errCategory == false){
                let formData = new FormData(this);
                formData.append('_token', '<?php echo e(csrf_token()); ?>');
                formData.append('_method', 'PUT');

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('courses.update', $course->id)); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        $("#submitBtn").prop("disabled", true).text("Loading...");
                    },
                    success: function (response) {
                        if (response.status) {
                            window.location = "<?php echo e(route('courses.index')); ?>";
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $("#err_name").text(errors.name[0]);
                            }

                            if (errors.fee) {
                                $("#err_fee").text(errors.fee[0]);
                            }

                            if (errors.category_id) {
                                $("#err_category").text(errors.category_id[0]);
                            }
                        } else {
                            $("#response_error").html("Something went wrong.").show().delay(5000).fadeOut();
                            console.log(xhr.responseText);
                        }

                        $("#submitBtn").prop("disabled", false).text("Update Course");
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/pages/edit_courses.blade.php ENDPATH**/ ?>