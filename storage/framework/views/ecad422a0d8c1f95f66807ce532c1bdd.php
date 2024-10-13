<?php $__env->startSection('title'); ?>
    Companies List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Companies
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Companies List
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form>
                        <div class="row g-3">
                            <div class="col-xxl-5 col-sm-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search bg-light border-light"
                                           id="searchCompany" placeholder="Search for company, industry type...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-sm-6">
                                <input type="text" class="form-control bg-light border-light" id="datepicker"
                                       data-date-format="d M, Y" placeholder="Select date">
                            </div>
                            <!--end col-->
                            <div class="col-xxl-2 col-sm-4">
                                <div class="input-light">
                                    <select class="form-control" data-choices data-choices-search-false
                                            name="choices-single-default" id="idType">
                                        <option value="all" selected>All</option>
                                        <option value="Full Time">Full Time</option>
                                        <option value="Part Time">Part Time</option>
                                        <option value="Internship">Internship</option>
                                        <option value="Freelance">Freelance</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-xxl-2 col-sm-4">
                                <button type="button" class="btn btn-secondary w-100" onclick="filterData();">
                                    <i class="ri-equalizer-fill me-1 align-bottom"></i> Filters
                                </button>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </form>
                </div>
            </div>

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

                    <div class="row g-0 justify-content-end mb-4" id="pagination-element">
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div
                                class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <div class="page-item disabled">
                                    <a href="javascript:void(0);" class="page-link" id="page-prev">Previous</a>
                                </div>
                                <span id="page-num" class="pagination"><div class="page-item active"><a
                                            class="page-link clickPageNumber" href="javascript:void(0);">1</a></div><div
                                        class="page-item"><a class="page-link clickPageNumber"
                                                             href="javascript:void(0);">2</a></div></span>
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="page-link" id="page-next">Next</a>
                                </div>
                            </div>
                        </div><!-- end col -->
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