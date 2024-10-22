@extends('layouts.master')
@section('title')
    {{$match->teamHome->name}} - {{$match->teamAway->name}} Ngày  {{$match->start_time}}
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Trang chủ
        @endslot
        @slot('title')
            Trận đấu
        @endslot
    @endcomponent
    <div class="row">
        @csrf
        <!-- end col -->
        <div class="col">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <div class="mb-0 flex-grow-1">
                        <h4 class="card-title mb-0">{{$match->teamHome->name}} - {{$match->teamAway->name}} Ngày  {{$match->start_time}}</h4>
                        <p class="text-muted">{{$match->league->name}}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="input-group" >
                            <input type="text" class="form-control minuteSplit" placeholder="Xem theo phút" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-success watch-minute-split" type="button" id="button-addon2">Xem</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <input type="text" class="d-none matchId" value="{{$match->id}}">
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
