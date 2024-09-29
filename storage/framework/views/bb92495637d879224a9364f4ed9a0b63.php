<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.grid-js'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/gridjs/theme/mermaid.min.css')); ?>">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Trang chủ
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Thêm proxy
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-12">
            <form action="/update-proxy" method="POST">
                <?php echo csrf_field(); ?>
                <div class="input-group">
                    <textarea type="text" class="form-control" name="proxy" aria-describedby="add_link_xoi_lac"></textarea>
                    <button class="btn btn-outline-success" type="submit" id="add_link_xoi_lac">Thêm proxy</button>
                </div>
            </form>

        </div>
    </div>
    <br>

    <div class="row row-container">
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\tuan\Pictures\doanphantichdulieu\resources\views/pages/add-proxy.blade.php ENDPATH**/ ?>