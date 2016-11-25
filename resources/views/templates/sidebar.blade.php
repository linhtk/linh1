<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 categories-left">
	<div class="cate-banner">
		<a class="" href="#"><div class="service-banner"></div></a>
	</div>
	<div class="cate-menu">
		@if(isset($categories))
			<div class="title-2">
				<div class="title-cate-af"></div>
				<div class="title-cate"> {{ trans('toppage.categories') }}
					<i class="icon-plus fa fa-plus" id="open-cate" aria-hidden="true"></i>
				</div>
			</div>
			<div class="cate-list" id="cate-list">
				@if ( count($categories) > 0 )
					@foreach($categories as $category)
						@if(isset($caterogy_id) && $caterogy_id == $category->id )
							<a class="cate-item active" href="/category/{{$category->id}}"><i class="fa fa-link mr5" aria-hidden="true"></i> {{$category->category_vn}}</a>
						@else
							<a class="cate-item" href="/category/{{$category->id}}"><i class="fa fa-link mr5" aria-hidden="true"></i> {{$category->category_vn}}</a>
						@endif
					@endforeach
				@else
					{{ trans('toppage.not_categories') }}
				@endif
			</div>
		@endif
	</div>
</div>