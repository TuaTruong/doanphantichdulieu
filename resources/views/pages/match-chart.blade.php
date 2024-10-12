@extends('layouts.master')
@section('title')
    @lang('translation.echarts')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Charts
        @endslot
        @slot('title')
            Echarts
        @endslot
    @endcomponent
    <div class="row">
        @csrf
        <!-- end col -->
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Stacked Line Chart</h4>
                </div>
                <div class="card-body">
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
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/echarts/echarts.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/match-chart.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
