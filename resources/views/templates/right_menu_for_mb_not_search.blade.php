<!-- Right menu for tablet & Mobile -->
<div id="mySidenav" class="sidenav">
    <div class="list-action-mb">
        <a href="{{ url('/faq') }}" class="action-header">{{trans('toppage.FAQ')}}</a>&nbsp|&nbsp
        <a href="#" class="action-header">{{trans('toppage.SERVICE_INTRODUCTION')}}</a>&nbsp|&nbsp
        <a href="{{ url('/contact') }}" class="action-header">{{trans('toppage.CONTACT')}}</a>
    </div>
    <div class="menu-side-right">
        @if( ! Auth::check() ) 
            <form method="POST" class="form-horizontal" role="form" accept-charset="utf-8" action="{{url('/account/login')}}" autocomplete="off">
                {{csrf_field()}}
                @if (!$errors->loginErrors->isEmpty())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->loginErrors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                 @endif
                @if(Session::has('error_session_expired'))
                    <div class="alert alert-danger">
                        {{Session::get('error_session_expired')}}
                    </div>
                @endif
                <div class="login-mb">
                    <input type="email" id="login_email" name="login_email" placeholder="{{trans('account.placeholder_register_email')}}" class="form-control input-login" value="{{ (old('login_email', '') != '') ? old('login_email','') : ( (isset($get_data_login['login_email']) && trim($get_data_login['login_email']) != '') ? trim($get_data_login['login_email']) : '') }}">
                    <input type="password" id="login_passwd" name="login_passwd" value="{{ (old('login_passwd', '') != '') ? old('login_passwd','') : ( (isset($get_data_login['login_passwd']) && trim($get_data_login['login_passwd']) != '') ? trim($get_data_login['login_passwd']) : '') }}" placeholder="{{trans('account.placeholdern_register_password')}}" class="form-control input-login mt8">
                    <p class="mt6 txr"><a href="{{ url('/account/pwd_email') }}" class=" italic fs11 underline  txt-77">{{trans('toppage.forget_password')}}</a></p>
                    <button class="btn btn-login-mb">{{trans('toppage.LOGIN')}}</button>
                    <a href='{{ url('/account/register') }}' class="btn btn-signup-mb mt15">{{trans('toppage.SIGNUP')}}</a>
                </div>
            </form>
        @endif
    </div>
    @if ( isset($categories) && count($categories) > 0 )
        <div class="cate-list-mb">
            @foreach($categories as $value => $category)
                @if(isset($caterogy_id) && $caterogy_id == $category->id )
                    <a class="cate-item-mb active" href="/category/{{$category->id}}"> {{$category->category_vn}}</a>
                @else
                    <a class="cate-item-mb" href="/category/{{$category->id}}"> {{$category->category_vn}}</a>
                @endif
            @endforeach
        </div>
    @endif
</div>
<!-- End Right menu for tablet & Mobile -->