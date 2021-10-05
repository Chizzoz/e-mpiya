@extends('layouts.master')
@section('user_profile_view')
<div class="row">
	<div class="large-3 medium-3 small-12 columns">
		<div class="user-profile">
			<div class="text-center">
				<a href="http://localhost/timeline.oneziko.com/public/images/small/android-6-512.png"><img src="http://localhost/timeline.oneziko.com/public/images/small/android-6-512.png" alt="{{ $user->username }}"></a>
				<h3>{{ $user->username }}</h3>
				<span>{{ $user->slogan }}</span>
				<p>{{ $user->about }}</p>
			</div>
			<div>
				<div class="row medium-up-4">
					<div class="column"><span class="secondary badge">1</span></div>
					<div class="column"><span class="warning badge">2</span></div>
					<div class="column"><span class="alert badge">3</span></div>
					<div class="column"><span class="warning badge">4</span></div>
				</div>
			</div>
			<div>
				<ul class="vertical menu">
					<li>Associates</li>
					<li>Edit Profile</li>
					<li>Preferences</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@stop


			