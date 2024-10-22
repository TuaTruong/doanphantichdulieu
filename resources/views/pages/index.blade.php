@extends('layouts.master')
@section('title')
    @lang('translation.grid-js')
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/gridjs/theme/mermaid.min.css') }}">

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Trang chủ
        @endslot
        @slot('title')
            Phân tích chỉ số các trận đấu của xôi lạc
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control match-url" placeholder="Thêm link xôi lạc" aria-describedby="add_link_xoi_lac">
                <button class="btn btn-outline-success" type="button" id="add_link_xoi_lac">Thêm link</button>
            </div>
        </div>
    </div>
    <br>

    <div class="row row-container">
    </div>

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/gridjs.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
