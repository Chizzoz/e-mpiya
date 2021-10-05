@extends('layouts.master')
@section('manage_users')
	<div class="large-9 medium-9 small-12 column contents">
		<?php $user_count = count($all_users); ?>
		@if ($user_count > 0)
		<table class="stack hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>User Type</th>
					<th>eMail</th>
					<th>Created</th>
					<th>Is Active</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($all_users as $user)
					<tr>
						<td>{{ $user_count }}</td>
						<td><a href="{{ route('view-user-profile', $user->username_slug) }}">{{ $user->username }}</a></td>
						<td>{{ $user->user_type }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->created_at }}</td>
						<td>
							@if ($user->is_active == 1)
								Yes
							@else
								No
							@endif
						</td>
						<td>
							@if ($user->is_active == 1)
								<div class="reveal" id="deactivateUser-{{$user->username_slug}}" data-reveal>
									<p>Are you sure you want to De-activate this User?</p>
									<div class="expanded button-group">
										<a class="button" href="{{ route('deactivate-user', $user->username_slug) }}" title="Yes">Yes</a>
										<a class="button" data-close aria-label="Close modal" title="No">No</a>
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<a class="button alert small" data-open="deactivateUser-{{$user->username_slug}}" title="De-activate User">De-activate</a>
							@else
								<div class="reveal" id="activateUser-{{$user->username_slug}}" data-reveal>
									<p>Are you sure you want to Activate this User?</p>
									<div class="expanded button-group">
										<a class="button" href="{{ route('activate-user', $user->username_slug) }}" title="Yes">Yes</a>
										<a class="button" data-close aria-label="Close modal" title="No">No</a>
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<a class="button success small" data-open="activateUser-{{$user->username_slug}}" title="Activate User">Activate</a>
							@endif
						</td>
					</tr>
					<?php --$user_count; ?>
				@endforeach
			</tbody>
		</table>
		@else
			<p>You currently have no users to manage.</p>
		@endif
	</div>
</div>
@stop