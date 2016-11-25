@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
<!-- Main content -->

<div class="main-content">
    <div class="container p0">
        <div class="box-white">
            <div class="title"> <h3 class='padding-lr-10'>{{ trans('account.404_text_1') }}</h3></div>
        </div>
    </div>
</div>

<!-- End Main content -->
</div>
@endsection
