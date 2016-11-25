@extends('...templates.admin_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <div class="panel-body">
                    @if (isset($msg_permission))
                        <span style="color: red">{{ $msg_permission }}</span>
                    @else
                        Your Application's  Point History Page.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection