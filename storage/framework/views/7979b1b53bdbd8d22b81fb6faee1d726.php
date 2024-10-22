<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.echarts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Trang chủ
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Trận đấu
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <?php echo csrf_field(); ?>
        <!-- end col -->
        <div class="col">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <div class="mb-0 flex-grow-1">
                        <h4 class="card-title mb-0"><?php echo e($match->teamHome->name); ?> - <?php echo e($match->teamAway->name); ?> Ngày  <?php echo e($match->start_time); ?></h4>
                        <p class="text-muted"><?php echo e($match->league->name); ?></p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="input-group" >
                            <input type="text" class="form-control minuteSplit" placeholder="Xem theo phút" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-success watch-minute-split" type="button" id="button-addon2">Xem</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <input type="text" class="d-none matchId" value="<?php echo e($match->id); ?>">
                    <div id="chart-line-stacked"
                         data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                         class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->


    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/echarts/echarts.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/match-chart.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\tuan\Pictures\doanphantichdulieu\resources\views/pages/match-chart.blade.php ENDPATH**/ ?>