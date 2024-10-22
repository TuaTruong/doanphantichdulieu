@extends('layouts.master')
@section('title')
    Companies List
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Trang chủ
        @endslot
        @slot('title')
            Tất cả các trận đấu
        @endslot
    @endcomponent

    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="row job-list-row" id="companies-list">
                        @foreach($allMatches as $match)
                            <div class="col-xxl-3 col-md-6">
                                <div class="card companiesList-card">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <a href="/match-statistic/{{$match->id}}">
                                                <h5 class="mt-3 company-name">{{$match->teamHome->name}} - {{$match->teamAway->name}}</h5>
                                            </a>
                                            <p class="text-muted industry-type">Lúc {{$match->start_time}}</p>
                                            <p class="text-muted industry-type">{{$match->league->name}}</p>
                                        </div>
                                        <div>
                                            <a href="/match-statistic/{{$match->id}}" type="button" class="btn btn-soft-primary w-100 viewcompany-list">Xem</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                    <!--end row-->
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
@endsection
@section('script')
    <!-- job-candidate-grid js -->
    {{--    <script src="{{URL::asset('build/js/pages/job-companies-lists.init.js')}}"></script>--}}

    <!-- App js -->
    <script src="{{URL::asset('build/js/app.js')}}"></script>
@endsection
