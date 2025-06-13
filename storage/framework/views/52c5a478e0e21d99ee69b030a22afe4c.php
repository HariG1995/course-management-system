<!-- resources/views/courses/show.blade.php -->


<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo e($course->name); ?> - Course Details</h1>
        <div>
            <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-secondary">Back to Courses</a>
            <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-info">View All Enrollments</a>
        </div>
    </div>

    <!-- Course Information Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Course Information</h5>
                    <p><strong>ID:</strong> <?php echo e($course->id); ?></p>
                    <p><strong>Name:</strong> <?php echo e($course->name); ?></p>
                    <p><strong>Fee:</strong> $<?php echo e(number_format($course->fee, 2)); ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Category</h5>
                    <p><strong>Category:</strong> <?php echo e($course->category->name); ?></p>
                    <p><strong>Total Enrollments:</strong> <?php echo e($course->students->count()); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Enrollments Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Currently Enrolled Students (<?php echo e($enrolledStudents->count()); ?>)</h5>
        </div>
        <div class="card-body">
            <?php if($enrolledStudents->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Enrolled At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $enrolledStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($student->id); ?></td>
                                    <td><?php echo e($student->name); ?></td>
                                    <td><?php echo e($student->email); ?></td>
                                    <td><?php echo e($student->pivot->enrolled_at->format('M j, Y g:i A')); ?></td>
                                    <td>
                                        <form action="<?php echo e(route('enrollments.destroy', $student->pivot->id)); ?>" 
                                              method="POST" 
                                              class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Remove this student from the course?')">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No students enrolled in this course yet.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Enrollment Form Section -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Enroll New Student</h5>
        </div>
        <div class="card-body">
            <?php if($availableStudents->count() > 0): ?>
                
                <form action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label for="student_id" class="form-label">Select Student</label>
                            <select name="student_id" id="student_id" class="form-select" required>
                                <option value="">-- Choose a student --</option>
                                <?php $__currentLoopData = $availableStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>">
                                        <?php echo e($student->name); ?> (<?php echo e($student->email); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i> Enroll Student
                            </button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    All students are already enrolled in this course.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/pages/show.blade.php ENDPATH**/ ?>