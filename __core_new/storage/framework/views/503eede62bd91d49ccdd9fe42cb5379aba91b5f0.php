<?php $__env->startSection('addTitle'); ?> | Selamat Datang <?php $__env->stopSection(); ?>

<?php $__env->startSection('addCss'); ?>
<link href="<?php echo e(asset('assets/css/demo.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('addJs'); ?>
<script src="<?php echo e(asset('assets/js/demo.js')); ?>"></script>
<script>
$(function () {
    demo.checkFullPageBackgroundImage();
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="wrapper wrapper-full-page">
    <div class="full-page  section-image" data-color="blue" data-image="<?php echo e(asset('assets/img/full-screen-image-2.jpg')); ?>" ;>
        <div class="content">
            <div class="container">
            
            <div class="row">
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-2" style="padding-right:1%">
                    <a href="<?php echo e(url('sch/' . $row->id . '/login')); ?>">
                        <div class="card h-100">
                            <?php
                            $logo = isset($row->logo) ? 'uploads/sekolah/logo/' . $row->logo : 'assets/img/nologo.jpg';
                            ?>
                            <img src="<?php echo e(asset($logo)); ?>" class="card-img-top" style="width:100%;height:150px;">
                            <div class="card-body">
                                <h5 class="card-title" align="center"><?php echo e(strtoupper($row->pendidikan) . ' ' . $row->nama); ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <nav>
                <p class="copyright text-center">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="#">APC Tim</a>, made with love for a better web
                </p>
            </nav>
        </div>
    </footer>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.single_page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp_7.2\htdocs\elearning-new\__core_new\resources\views/welcome.blade.php ENDPATH**/ ?>