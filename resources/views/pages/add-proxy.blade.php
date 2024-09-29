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
            Thêm proxy
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <form action="/update-proxy" method="POST">
                @csrf
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

@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
