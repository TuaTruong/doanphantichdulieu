<?php $__env->startSection('title'); ?>
    Companies List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Trang chủ
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Tất cả các trận đấu
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="row job-list-row" id="companies-list">
                        <?php $__currentLoopData = $allMatches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xxl-3 col-md-6">
                                <div class="card companiesList-card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="/match-statistic/<?php echo e($match->id); ?>">
                                                <h5 class="mt-3 company-name"><?php echo e($match->teamHome->name); ?> - <?php echo e($match->teamAway->name); ?></h5>
                                            </a>
                                            <p class="text-muted industry-type">Lúc <?php echo e($match->start_time); ?></p>
                                            <p class="text-muted industry-type"><?php echo e($match->league->name); ?></p>
                                        </div>
                                        <div>
                                            <a href="/match-statistic/<?php echo e($match->id); ?>" type="button" class="btn btn-soft-primary w-100 viewcompany-list">Xem</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!--end row-->
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- job-candidate-grid js -->
    

    <!-- App js -->
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\tuan\Pictures\doanphantichdulieu\resources\views/pages/all-matches.blade.php ENDPATH**/ ?>