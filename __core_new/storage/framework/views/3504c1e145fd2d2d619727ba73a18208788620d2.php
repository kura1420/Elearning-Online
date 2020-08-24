<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('assets/img/apple-icon.png')); ?>">
    <link rel="icon" type="image/png') }}" href="<?php echo e(asset('assets/img/favicon.png')); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title> <?php echo e(config('app.name', 'Laravel')); ?> <?php echo $__env->yieldContent('addTitle'); ?> </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/css/light-bootstrap-dashboard.css?v=2.0.1')); ?>" rel="stylesheet" />
    <?php echo $__env->yieldContent('addCss'); ?>

</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>
</body>

<script src="<?php echo e(asset('assets/js/core/jquery.3.2.1.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/core/popper.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/core/bootstrap.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/light-bootstrap-dashboard.js?v=2.0.1')); ?>" type="text/javascript"></script>
<?php echo $__env->yieldContent('addJs'); ?>

</html><?php /**PATH D:\xampp_7.2\htdocs\elearning-new\__core_new\resources\views/layouts/single_page.blade.php ENDPATH**/ ?>