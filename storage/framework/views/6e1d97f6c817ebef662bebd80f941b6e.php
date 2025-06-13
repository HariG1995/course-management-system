

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>All Enrollments</h1>
        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-secondary">Back to Courses</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrolled At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($enrollment->id); ?></td>
                                <td><?php echo e($enrollment->student->name); ?></td>
                                <td><?php echo e($enrollment->course->name); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y H:i')); ?></td>
                                <td>
                                    <form action="<?php echo e(route('enrollments.destroy', $enrollment->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/pages/view_enrollments.blade.php ENDPATH**/ ?>