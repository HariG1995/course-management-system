

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Courses</h1>
        <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary">Add New Course</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter Courses</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('filter_course')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-5">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="name" class="form-label">Course Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo e(request('name')); ?>" placeholder="Search by course name">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary" id="filterBtn">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Course List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Fee</th>
                            <th>Category</th>
                            <th>Enrollments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($course->id); ?></td>
                                <td><?php echo e($course->name); ?></td>
                                <td>₹<?php echo e(number_format($course->fee, 2)); ?></td>
                                <td><?php echo e($course->category->name); ?></td>
                                <td><?php echo e($course->enrollments_count); ?></td>
                                <td>
                                    
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/pages/courses.blade.php ENDPATH**/ ?>