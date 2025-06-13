

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Categories</h1>
        <button class="btn btn-primary" id="openModal" data-bs-toggle="modal" data-bs-target="#categoryModal">Add New Category</button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-striped" id="data-table">
                    <thead>
                        <tr>
                            <th>SL.No</th>
                            <th>Name</th>
                            <th>Course Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($category->name); ?></td>
                                <td><?php echo e($category->courses_count); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="<?php echo e($category->id); ?>" data-url="<?php echo e(route('categories.edit', $category->id)); ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo e($category->id); ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST" id="categoryForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category" name="name" autocomplete="off" placeholder="Enter category name">
                            <span class="error_field" id="err_category"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="submitBtn">Save Category</button>
                        <button type="button" class="btn btn-success d-none" id="updateBtn">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();
            var errCategory = false;

            var category = $("#category").val();

            if(!category){
                errCategory = true;
                show_error_alert("#err_category", "#category", "category field is required");
            }else{
                errCategory = false;
                hide_error_alert("#err_category", "#category", "");
            }

            if(errCategory == false){
                let formData = new FormData(this);
                formData.append('_token', '<?php echo e(csrf_token()); ?>');

                $.ajax({
                    method: "POST",
                    dataType: "json",
                    url: "<?php echo e(route('categories.store')); ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        $("#submitBtn").prop("disabled", true).text("Loading...");
                    },
                    success: function (response) {
                        if (response.status) {
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.name) {
                                $("#err_category").text(errors.name[0]);
                            }
                        } else {
                            $("#err_category").html("Something went wrong.").show().delay(5000).fadeOut();
                            console.log(xhr.responseText);
                        }

                        $("#submitBtn").prop("disabled", false).text("Save Category");
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

    <script>
    $(document).on("click", ".edit-btn", function(){
        var $this = $(this);
        var editURL = $this.data('url');

        if(editURL){
             $.ajax({
                url: editURL,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        let category = response.data;

                        $("#submitBtn").addClass("d-none");
                        $("#updateBtn").removeClass("d-none");
                        $('#category').val(category.name);
                        $('#updateBtn').attr('category_id', category.id);
                        $('#categoryModal').modal('show');
                    } else {
                        alert("Category not found.");
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert("Something went wrong");
                }
            });
        }
    });
    </script>

    <script>
    const updateCategoryUrl = "<?php echo e(route('categories.update', ':id')); ?>";

    $(document).on("click", "#updateBtn", function(e){
        e.preventDefault();
        var errCategory = false;

        var catID = $(this).attr("category_id");
        var category = $("#category").val();

        let url = updateCategoryUrl.replace(":id", catID);

        if(!category){
            errCategory = true;
            show_error_alert("#err_category", "#category", "category field is required");
        }else{
            errCategory = false;
            hide_error_alert("#err_category", "#category", "");
        }

        if(errCategory == false){
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    name: category,
                    _token: "<?php echo e(csrf_token()); ?>",
                    _method: "PUT"
                },
                beforeSend: function () {
                    $("#updateBtn").prop("disabled", true).text("Updating...");
                },
                success: function (response) {
                    window.location.reload();
                },
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.name) {
                            $("#err_category").text(errors.name[0]);
                        }
                    } else {
                        $("#err_category").html("Something went wrong.").show().delay(5000).fadeOut();
                        console.log(xhr.responseText);
                    }

                    $("#updateBtn").prop("disabled", false).text("Update Category");
                        
                }
            });
        }
    });
    
    $(document).on("click", ".delete-btn", function(){
        var $this = $(this);
        var catID = $this.data('id');
        const deleteCategoryUrl = "<?php echo e(route('categories.destroy', ':id')); ?>";

        if(confirm("Are you sure you want to delete this category?")){
            let url = deleteCategoryUrl.replace(":id", catID);

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "<?php echo e(csrf_token()); ?>"
                },
                beforeSend: function () {
                    $this.prop("disabled", true);
                },
                success: function (response) {
                    window.location.reload();
                },
                error: function (xhr) {
                    alert("Something went wrong.");
                    console.error(xhr.responseText);
                }
            });
        }
    });

    $(document).ready(function () {
        $('#categoryModal').on('hidden.bs.modal', function () {
            $("#submitBtn").removeClass("d-none");
            $("#updateBtn").addClass("d-none");
            $("#err_category").text("");
            $("#category").css("border", "");
            $('#categoryForm')[0].reset();
        });
    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/pages/view_categories.blade.php ENDPATH**/ ?>