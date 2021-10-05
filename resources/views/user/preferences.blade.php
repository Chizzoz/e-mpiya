@extends('layouts.master')
@section('user_profile_preferences')
	<div class="large-9 medium-9 small-12 columns main">
		<div class="user-preferences-edit">
			<p><h4>Select your prefered headline sources</h4></p>
			<form action="{{ route('update-user-preferences', Auth::user()->username_slug) }}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<input type="checkbox" name="kitwetimes" value="1" <?php if ($user_headline_source_preference->is_kitwetimes == 1) echo 'checked' ?> /> Kitwe Times <br>
				<input type="checkbox" name="lusakavoice" value="1" <?php if ($user_headline_source_preference->is_lusakavoice == 1) echo 'checked' ?> /> Lusaka Voice <br>
				<input type="checkbox" name="mwebantu" value="1" <?php if ($user_headline_source_preference->is_mwebantu == 1) echo 'checked' ?> /> Mwebantu Media <br>
				<input type="checkbox" name="techtrends" value="1" <?php if ($user_headline_source_preference->is_techtrends == 1) echo 'checked' ?> /> Tech Trends <br>
				<input type="checkbox" name="tumfweko" value="1" <?php if ($user_headline_source_preference->is_tumfweko == 1) echo 'checked' ?> /> Tumfweko <br>
				<input type="checkbox" name="zambianintelligencenews" value="1" <?php if ($user_headline_source_preference->is_zambianintelligencenews) echo 'checked' ?> /> Zambian Intelligence News <br>
				<input type="checkbox" name="zambianwatchdog" value="1" <?php if ($user_headline_source_preference->is_zambianwatchdog == 1) echo 'checked' ?> /> Zambian Watchdog <br>
				<input type="checkbox" name="zambiadailynation" value="1" <?php if ($user_headline_source_preference->is_zambiadailynation == 1) echo 'checked' ?> /> Zambia Daily Nation <br>
				<input type="checkbox" name="zambianeye" value="1" <?php if ($user_headline_source_preference->is_zambianeye == 1) echo 'checked' ?> /> Zambian Eye <br>
				<div class="medium-12 column text-center">
					<input type="submit" value="Save" class="small button" />
					<a href="{{ route('view-user-profile', Auth::user()->username_slug) }}" class="small button">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@stop