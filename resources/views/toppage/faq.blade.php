@extends('templates.master')

@section('content')
@include('templates.right_menu_for_mb_not_search')
<div id="main" class="bg-signup">
    @include('templates.header_not_search')
    <div class="main-content">
        <div class="container p0">
            @include('templates.sidebar')
            <div class='col-lg-9 col-md-9 col-sm-12 col-xs-12 categories-right'>
                <div class="box-white">
                    <div class='signup-title'> <span class="title-bor">{{trans('toppage.title_faq')}}</span></div>
                    <div id="accordion" class="mt30">
                        @foreach(Config::get('const_faq.faqs') as $index=>$faq)
                        <div>
                            <div class="faq-title">
                                <h4 class="panel-title">
                                    <img src="img/non-expand.png" id="faq-expand-{{ $index }}" width="12" height="12" />
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" data-qnum="{{ $index }}" href="#collapse_{{ $index }}">{!! $faq['question'] !!}</a>
                                </h4>
                            </div>
                            <div id="collapse_{{ $index }}" class="collapse">
                                <div class="panel-body">
                                    {!! $faq['answer'] !!}
                                </div>
                            </div>
                            <hr>
                        </div>
                        @endforeach
                        <div class="txc"><a href="/" class="btn btn-white-00"> {{ trans('toppage.back') }} </a></div>
                    </div>
                </div> 
            </div>
        </div><!-- ./container -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".accordion-toggle").on("click", function(){
            var qnum = $(this).data("qnum")*1;
            if($("#collapse_" + qnum).hasClass("in")) {
                console.log("non expand");
                $("#faq-expand-" + qnum).attr("src", "img/non-expand.png");
                $(this).attr("style", "color: #444444;");
            } else {
                console.log("expand");
                $("#faq-expand-" + qnum).attr("src", "img/expand.png");
                $(this).attr("style", "color: #f66a1d;");
            }
        });

    });
</script>
@endsection