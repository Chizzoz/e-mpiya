@extends('layouts.master')
@section('user_associates')
	<!-- user associates -->
<div class="large-9 medium-9 small-12 column contents">
	@if (!empty($relationships))
		<div class="large-12 medium-12 small-12 columns my-callout">
			<h3>Associates</h3>
		</div>
		@if (Auth::user()->id == $user->id)
			<?php $user_ids = array() ?>
			@foreach ($relationships as $relationship)
				@if ($relationship->user_relationship_status_id == 2)
					@if (!(in_array($relationship->associator_id, $user_ids) || in_array($relationship->associated_id, $user_ids)))
						@if(Auth::user()->id == $relationship->associated_id)
							<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}"><img src="<?php
											if (!($relationship->associator_profile_picture == "")) {
												echo Str::replace('users', 'small', $relationship->associator_profile_picture);
											} else {
												echo asset('/images/small/default-user-profile-picture.png');
											} ?>" title="{{ $relationship->associator_name }}" alt="{{ $relationship->associator_name }}"></a></p>
							<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}">{{ $relationship->associator_name }}</a></p>
							<?php $user_ids[] = $relationship->associator_id; ?>
						@else
							<p><a href="{{ route('view-user-profile', $relationship->associated_username_slug) }}"><img src="<?php
											if (!($relationship->associated_profile_picture == "")) {
												echo Str::replace('users', 'small', $relationship->associated_profile_picture);
											} else {
												echo asset('/images/small/default-user-profile-picture.png');
											} ?>" title="{{ $relationship->associated_name }}" alt="{{ $relationship->associated_name }}"></a></p>
							<p><a href="{{ route('view-user-profile', $relationship->associated_username_slug) }}">{{ $relationship->associated_name }}</a></p>
							<?php $user_ids[] = $relationship->associated_id; ?>
						@endif
					@endif
				@endif
			@endforeach
		@else
			<?php $user_ids = array() ?>
			@foreach ($relationships as $relationship)
				@if ($relationship->user_relationship_status_id == 2)
					@if (!(in_array($relationship->associator_id, $user_ids) || in_array($relationship->associated_id, $user_ids)))
						@if($user->id == $relationship->associated_id)
							<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}"><img src="<?php
											if (!($relationship->associator_profile_picture == "")) {
												echo Str::replace('users', 'small', $relationship->associator_profile_picture);
											} else {
												echo asset('/images/small/default-user-profile-picture.png');
											} ?>" title="{{ $relationship->associator_name }}" alt="{{ $relationship->associator_name }}"></a></p>
							<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}">{{ $relationship->associator_name }}</a></p>
							<?php $user_ids[] = $relationship->associator_id; ?>
						@else
							<p><a href="{{ route('view-user-profile', $relationship->associated_username_slug) }}"><img src="<?php
											if (!($relationship->associated_profile_picture == "")) {
												echo Str::replace('users', 'small', $relationship->associated_profile_picture);
											} else {
												echo asset('/images/small/default-user-profile-picture.png');
											} ?>" title="{{ $relationship->associated_name }}" alt="{{ $relationship->associated_name }}"></a></p>
							<p><a href="{{ route('view-user-profile', $relationship->associated_username_slug) }}">{{ $relationship->associated_name }}</a></p>
							<?php $user_ids[] = $relationship->associated_id; ?>
						@endif
					@endif
				@endif
			@endforeach
		@endif
	@else
		@if (Auth::user()->id == $user->id)
			<div class="large-12 medium-12 small-12 columns my-callout">
				<h3>This is your Associates List</h3>
			</div>
			<p>You currently haven't associated yourself with any users. Associate <img src="{{ asset('/img/add-associate.png') }}" title="Add Associate" alt="Add Associate" > yourself with one or more users to get started, your associates <img src="{{ asset('/img/associates.png') }}" title="Associate" alt="Associate" > will be listed here.</p>
		@else
			<div class="large-12 medium-12 small-12 columns my-callout">
				<h3>This is {{ $heading }}</h3>
			</div>
			<p>{{ $user->username }} currently hasn't got any Associates <img src="{{ asset('/img/associates.png') }}" title="Associate" alt="Associate" >. You can send {{ $user->username }} an association request by clicking the add associate button <img src="{{ asset('/img/add-associate.png') }}" title="Add Associate" alt="Add Associate" >.</p>
		@endif
	@endif
</div>
@stop