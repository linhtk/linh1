<!-- Main content -->
<div class="header">
    <div class="top_header">
        <div class="list_action_header">
            <a href="{{ url('/faq') }}" class="action_header">{{trans('toppage.FAQ')}}</a>
            <a href="#" class="action_header">{{trans('toppage.SERVICE_INTRODUCTION')}}</a>
            <a href="{{ url('/contact') }}" class="action_header">{{trans('toppage.CONTACT')}}</a>
        </div>
        @if( Auth::check() ) 
            <div class="top-header-logged">
                <a class="" href="{{ url('/account/mypage') }}"><i class="fa fa-user mr5 fs16 txt-orange" aria-hidden="true"></i> {{Auth::user()->name}}</a>
                <a class="ml14" href="{{ url('/account/point') }}"> <i class="fa fa-star mr5 fs16 txt-orange" aria-hidden="true"></i> <span class="font600">{{number_format(trim(Auth::user()->points), 0,' ' , '.')}}</span> points</a> | <a href="{{ url('/account/logout') }}">{{trans('toppage.Logout')}}
            </div>
        @endif
        
    </div>
    <div class="clearfix"></div>
    <div class="mid-header container">
        <a class="logo" href="/">
            <i class="img-logo"></i>
        </a>
        <div class="menu-mb txr">
            <i class="fa fa-bars fs42" id="open-nav" aria-hidden="true" onclick="openNav()"></i>
            <a href="javascript:void(0)" id="close-nav" class="closebtn fa fa-times" onclick="closeNav()"></a>
        </div>
        
        <div class="box-search">
            <div class="div-search">
                
            </div>
        </div>
        
        <div class="header-login">
            @if( Auth::check() ) 
                <div class="top-header-logged-pc">
                    <a class="" href="{{ url('/account/mypage') }}"><i class="fa fa-user mr5 fs20 txt-orange" aria-hidden="true"></i>{{Auth::user()->name}}</a>
                    <a class="ml16" href="{{ url('/account/point') }}"> <i class="fa fa-star mr5 fs20 txt-orange" aria-hidden="true"> </i> <span class="font600">{{number_format(trim(Auth::user()->points), 0,' ' , '.')}}</span> points</a> | <a href="{{ url('/account/logout') }}">{{trans('toppage.Logout')}}</a>
                </div>
            @else
                @include('templates.login_form')
            @endif
        </div>
        
    </div>
    @if(isset($categories))
        <div class="header-menu container p0">
            <nav class="">
                <ul class="nav navbar-nav">
                    @if ( count($categories) > 0 )
                        @foreach($categories as $value => $category)
                            <li><a href="/category/{{$category->id}}">{{$category->category_vn}}</a></li> 
                            @if($value == 4) @break;@endif
                        @endforeach
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div> 
<div class="clearfix"></div>