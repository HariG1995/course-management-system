<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CMS</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap4.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <style>
        body {
            background-image: url('/bg/bg-1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            /* height: auto; */
            margin: 0;
            padding: 0;
        }

        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        .error_field {
            color: red;
            font-family: math;
            font-size: small;
        }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="<?php echo e(route('home')); ?>" class="navbar-brand" href="">CMS</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                            <a href="<?php echo e(route('home')); ?>" class="nav-link" href="">Home</a>
                        </li>

                        <li class="nav-item <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('categories.index')); ?>">Categories</a>
                        </li>

                        <li class="nav-item <?php echo e(request()->routeIs('students.*') ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('students.index')); ?>">Students</a>
                        </li>

                        <li class="nav-item <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('courses.index')); ?>">Courses</a>
                        </li>

                        <li class="nav-item <?php echo e(request()->routeIs('enrollments.*') ? 'active' : ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('enrollments.index')); ?>">Enrollments</a>
                        </li>

                        <li class="nav-item">
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="nav-link" href="<?php echo e(route('logout')); ?>" style="border: none; background: none;">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container mt-4">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <script>
        $(document).ready(function() {
            $('#data-table').DataTable();
        });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
        
    </body>
</html><?php /**PATH E:\Interview Machine Tests\Ipix Technologies\course-management\resources\views/layouts/app.blade.php ENDPATH**/ ?>