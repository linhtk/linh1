<html>
	<head>
		<meta charset="UTF-8" />
        <meta content="IE=edge" http-equiv="X-UA-Compatible" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1.0, user-scalable=no" name="viewport" />

        <title><?php echo (isset($title_page)) ? $title_page : trans('toppage.earn_points');?></title>
        <meta name="description" content="Cash back mall" />
        <meta name="keywords" content="Cash back mall" />
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font -->
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=vietnamese" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/css/slick.css">
		<link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
		<!-- style plugin -->

        <link rel="stylesheet" href="/css/fonts.css">

        <!-- Style -->
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" media="all" href="/css/default.css" />
        <link rel="stylesheet" media="all" href="/css/media_all.css" />
        <link rel="stylesheet" media="all" href="/css/bootstrap-datetimepicker.css" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="/js/moment-with-locales.js"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>
	</head>
	<body>
		@yield('content')
		<div class="footer">
			<div class="container p0">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 p0 hidden-xs">
					<div class="txt-copyright">
						&copy 2016 Logo. All Rights Reserved.
					</div>
				</div>
				
				<div class="col-xs-12 visible-xs">
					<div class="txt-copyright">
						&copy 2016 Logo. All Rights Reserved.
					</div>
				</div>
			</div>
		</div>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="/js/bootstrap.min.js"></script>
		<script src="/js/slick.js" type="text/javascript" charset="utf-8"></script>
	    <!-- js plugin -->

	    <!-- js main -->
		<script>
		$(document).on('ready', function() {
			
			$("#open-cate").click(function(){
				if($("#cate-list").hasClass("hoacti")){
					$("#cate-list").removeClass("hoacti");
					$("#open-cate").addClass("fa-plus");
					$("#open-cate").removeClass("fa-minus");
					
				}else{
					$("#cate-list").addClass("hoacti");
					$("#open-cate").removeClass("fa-plus");
					$("#open-cate").addClass("fa-minus");
				}
			})
			$('input#login_email, input#login_passwd').focus(function(){
				$('div.message-error, .icon-warning').hide();
				$('input#login_email').removeClass('error');
                $('input#login_passwd').removeClass('error');

			});

           $( ".btn_give_effect" ).click(function() {
           @if(!Auth::check() )
            if ($(window).width() <=992) {
               openNav();
               $("#mb_alert_login_err").html( "" );
               $("#mb_alert_login_err").html("@lang('account.please_login_before')");
                $("#mb_alert_login_err").show();
                $('input#login_email,input#login_passwd').addClass('error');
            } else {
                $("#detail_message-error").html( "" );
                $('div#alert_login_err').removeClass('alert_login_err');
                $('input#login_email').addClass('error_detail_login');
                $("#detail_message-error").html("@lang('account.please_login_before')");
                $("#alert_login_err").show();
                $("input#login_email" ).focus();
            }
             return false;
             @endif
           });

           $( "input#login_email, input#login_passwd" ).keypress(function() {
             if ($("#alert_login_err").is(':visible')) {
                 $('input#login_email').removeClass('error_detail_login');
                 $('#alert_login_err').hide();
                 $("#detail_message-error").html( "" );
             }

           });


	    });
		
		</script>
		<script>
		function openNav() {
			if($(window).width() <=992 && $(window).width() >= 768 ){
				document.getElementById("mySidenav").style.width = "300px";
				document.getElementById("main").style.right = "300px";
				document.getElementById("open-nav").style.display = "none";
				document.getElementById("close-nav").style.display = "block";
			}else{
				document.getElementById("mySidenav").style.width = "256px";
				document.getElementById("main").style.right = "256px";
				document.getElementById("open-nav").style.display = "none";
				document.getElementById("close-nav").style.display = "block";
			}
		}

		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
			document.getElementById("main").style.right= "0";
			document.getElementById("close-nav").style.display = "none";
			document.getElementById("open-nav").style.display = "block";
		}
		</script>
	</body>
</html>
