<div class="message-area">
	@if(\Session::get('msg'))
	<div class="col-lg-3 col-md-4 col-sm-4 col-6 message">
		{{-- <div class="card-header bg-{{json_decode(\Session::get('msg'))->type}}" id="mobile-title">
			<label for="collapse-message">
				<h4 class="card-title">
					<i class="fa fa-{{json_decode(\Session::get('msg'))->icon}}"></i>
				</h4>
			</label>
		</div> --}}
		<div class="card bg-{{json_decode(\Session::get('msg'))->type}}">
			<div class="card-header bg-{{json_decode(\Session::get('msg'))->type}}" id="mobile-title">
				<label for="collapse-message">
					<i class="fa fa-{{json_decode(\Session::get('msg'))->icon}}"></i>
				</label>
			</div>
			<div class="card-header" id="pc-title">
				<h4 class="card-title">
					<i class="fa fa-{{json_decode(\Session::get('msg'))->icon}}"></i>
					<span>{{json_decode(\Session::get('msg'))->title}}</span>
				</h4>
				<div class="card-tools">
					<button type="button" id="collapse-message" class="btn btn-tool" data-widget="collapse">
						<i class="fa fa-window-minimize"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<ul>
					@foreach(json_decode(\Session::get('msg'))->content as $msg)
					<li>{{$msg}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	@endif
</div>