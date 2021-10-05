@extends('layouts.master')
@section('user_profile_card')
	<div class="large-3 medium-3 small-12 column">
		<div class="user-profile">
			<div class="text-center">
				<a class="user-profile-picture" title="{{ $user->username }}" alt="{{ $user->username }}" href="<?php
						if (!($user->user_profile_picture == "")) {
							echo Str::replace('users', 'original', $user->user_profile_picture);
						} else {
							echo asset('/images/large/default-user-profile-picture.png');
						} ?>"><img src="<?php
						if (!($user->user_profile_picture == "")) {
							echo Str::replace('users', 'medium', $user->user_profile_picture);
						} else {
							echo asset('/images/medium/default-user-profile-picture.png');
						} ?>" title="{{ $user->username }}" alt="{{ $user->username }}"></a>
				<h3><a href="{{ route('view-user-profile', $user->username_slug) }}">{{ $user->username }}</a></h3>
				<span>{{ $user->slogan }}</span>
				<p>{{ $user->about }}</p>
			</div>
			<div>
				<ul class="menu">
					<li><a href="{{ route('associates-list', $user->username_slug) }}">Associates List</a></li>
					<li><a href="{{ route('user-checklist', $user->username_slug) }}">Checklist</a></li>
					<li></li>
				</ul>
			</div>
			<div>
				<ul class="vertical menu">
					<!-- user association handling -->
					@if (Auth::user()->id != $user->id)
						@if (!empty($user_relationships))
							<?php $current_user_associated = 0 ?>
							@foreach ($user_relationships as $user_relationship)
								@if (($user_relationship->associator_id == Auth::user()->id) || ($user_relationship->associated_id == Auth::user()->id))
									<?php $current_user_associated++ ?>
									@if ($user_relationship->associator_id == Auth::user()->id)
										@if ($user_relationship->user_relationship_status_id == 1)
											<div class="reveal" id="pendingAssociation" data-reveal>
												<p>Are you sure you want to cancel pending association request with {{ $user->username }}?</p>
												<div class="expanded button-group">
													<a class="button" href="{{ route('delete-pending-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Cancel Pending Association Request">Yes</a>
													<a class="button" data-close aria-label="Close modal" title="No">No</a>
												</div>
												<button class="close-button" data-close aria-label="Close modal" type="button">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<li class="pending-associate"><a data-open="pendingAssociation" title="Cancel Pending Association Request"></a></li>
											@break
										@elseif ($user_relationship->user_relationship_status_id == 2)
											<div class="reveal" id="deleteAssociationRequest" data-reveal>
												<p>Are you sure you want to send a delete association request to {{ $user->username }}?</p>
												<div class="expanded button-group">
													<a class="button" href="{{ route('delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Yes">Yes</a>
													<a class="button" data-close aria-label="Close modal" title="No">No</a>
												</div>
												<button class="close-button" data-close aria-label="Close modal" type="button">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<li class="associates"><a data-open="deleteAssociationRequest" title="Delete Association Request"></a></li>
											@break
										@elseif ($user_relationship->user_relationship_status_id == 3)
											@if ($user_relationship->initiated_by_id == Auth::user()->id)
												<div class="reveal" id="deleteAssociation" data-reveal>
													<p>Are you sure you want to cancel your delete association request sent to {{ $user->username }}?</p>
													<div class="expanded button-group">
														<a class="button" href="{{ route('cancel-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Yes">Yes</a>
														<a class="button" data-close aria-label="Close modal" title="No">No</a>
													</div>
													<button class="close-button" data-close aria-label="Close modal" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<li class="pending-associate"><a data-open="deleteAssociation" title="Delete Association Request"></a></li>
												@break
											@else
												<p><a href="{{ route('accept-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}">Accept Delete Request</a> | <a href="{{ route('cancel-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}">Decline Delete Request</a></p>
												@break
											@endif
										@elseif ($user_relationship->user_relationship_status_id == 4)
											<li>Old Associates</li>
											@break
										@endif
									@elseif ($user_relationship->associated_id == Auth::user()->id)
										@if ($user_relationship->user_relationship_status_id == 1)
											<p><a href="{{ route('accept-pending-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}">Accept Association</a> | <a href="{{ route('delete-pending-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Delete Pending Association Request">Decline Association</a></p>
											@break
										@elseif ($user_relationship->user_relationship_status_id == 2)
											<div class="reveal" id="deleteAssociationRequest" data-reveal>
												<p>Are you sure you want to send a delete association request to {{ $user->username }}?</p>
												<div class="expanded button-group">
													<a class="button" href="{{ route('delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Yes">Yes</a>
													<a class="button" data-close aria-label="Close modal" title="No">No</a>
												</div>
												<button class="close-button" data-close aria-label="Close modal" type="button">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<li class="associates"><a data-open="deleteAssociationRequest" title="Delete Association Request"></a></li>
											@break
										@elseif ($user_relationship->user_relationship_status_id == 3)
											@if ($user_relationship->initiated_by_id == Auth::user()->id)
												<div class="reveal" id="deleteAssociation" data-reveal>
													<p>Are you sure you want to cancel your delete association request sent to {{ $user->username }}?</p>
													<div class="expanded button-group">
														<a class="button" href="{{ route('cancel-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Yes">Yes</a>
														<a class="button" data-close aria-label="Close modal" title="No">No</a>
													</div>
													<button class="close-button" data-close aria-label="Close modal" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<li class="pending-associate"><a data-open="deleteAssociation" title="Cancel Delete Association Request"></a></li>
												@break
											@else
												<p><a href="{{ route('accept-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Accept Delete Request">Accept Delete Request</a> | <a href="{{ route('cancel-delete-association-request', array(Auth::user()->username_slug, $user_relationship->id)) }}" title="Decline Delete Request">Decline Delete Request</a></p>
												@break
											@endif
										@elseif ($user_relationship->user_relationship_status_id == 4)
											<li>Old Associates</li>
											@break
										@endif
									@endif
								@endif
							@endforeach
							@if ($current_user_associated == 0)
							<div class="reveal" id="addAssociate" data-reveal>
								<p>Are you sure you want to associate with {{ $user->username }}?</p>
								<div class="expanded button-group">
									<a class="button" href="{{ route('request-association', array($user->username_slug, Auth::user()->username_slug)) }}" title="Yes">Yes</a>
									<a class="button" data-close aria-label="Close modal" title="No">No</a>
								</div>
								<button class="close-button" data-close aria-label="Close modal" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<li class="add-associate"><a data-open="addAssociate" title="Associate {{ $user->username }}"></a></li>
							@endif
						@else
							<div class="reveal" id="addAssociate" data-reveal>
								<p>Are you sure you want to associate with {{ $user->username }}?</p>
								<div class="expanded button-group">
									<a class="button" href="{{ route('request-association', array($user->username_slug, Auth::user()->username_slug)) }}" title="Yes">Yes</a>
									<a class="button" data-close aria-label="Close modal" title="No">No</a>
								</div>
								<button class="close-button" data-close aria-label="Close modal" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<li class="add-associate"><a data-open="addAssociate" title="Associate {{ $user->username }}"></a></li>
						@endif
					@endif
					<!-- pending association requests -->
					@if (!empty($pending_relationships))
						@if (Auth::user()->id == $user->id)
							<p>{{Auth::user()->username }}, you have pending association requests:</p>
							@foreach ($pending_relationships as $pending_relationship)
								<p><a class="association-user-profile-picture" href="{{ route('view-user-profile', $pending_relationship->associator_username_slug) }}"><img src="<?php
									if (!($pending_relationship->associator_profile_picture == "")) {
										echo Str::replace('users', 'small', $pending_relationship->associator_profile_picture);
									} else {
										echo asset('/images/small/default-user-profile-picture.png');
									} ?>" title="{{ $pending_relationship->associator_name }}" alt="{{ $pending_relationship->associator_name }}"></a></p>
								<p><a href="{{ route('accept-pending-association-request', array(Auth::user()->username_slug, $pending_relationship->id)) }}">Accept {{ $pending_relationship->associator_name }}</a> | <a href="{{ route('delete-pending-association-request', array(Auth::user()->username_slug, $pending_relationship->id)) }}">Deny {{ $pending_relationship->associator_name }}</a></p>
							@endforeach
						@endif
					@endif
					<!-- pending delete association request -->
					@if (!empty($pending_delete_relationships))
						@if (Auth::user()->id == $user->id)
							<p>{{Auth::user()->username }}, you have pending delete association requests:</p>
							@foreach ($pending_delete_relationships as $pending_delete_relationship)
								<p><a class="association-user-profile-picture" href="{{ route('view-user-profile', $pending_delete_relationship->initiator_username_slug) }}"><img src="<?php
									if (!($pending_relationship->associator_profile_picture == "")) {
										echo Str::replace('users', 'medium', $pending_relationship->associator_profile_picture);
									} else {
										echo asset('/images/small/default-user-profile-picture.png');
									} ?>" title="{{ $pending_relationship->initiator_name }}" alt="{{ $pending_relationship->initiator_name }}"></a></p>
								<p><a href="{{ route('accept-delete-association-request', array(Auth::user()->username_slug, $pending_delete_relationship->id)) }}">Delete Association</a> | <a href="{{ route('cancel-delete-association-request', array(Auth::user()->username_slug, $pending_delete_relationship->id)) }}">Keep Association</a></p>
							@endforeach
						@endif
					@endif
					<!-- user associates -->
					@if (!empty($relationships))
						<li>Associates</li>
						@if (Auth::user()->id == $user->id)
							<?php $user_ids = array() ?>
							@foreach ($relationships as $relationship)
								@if ($relationship->user_relationship_status_id == 2)
									@if (!(in_array($relationship->associator_id, $user_ids) || in_array($relationship->associated_id, $user_ids)))
										@if(Auth::user()->id == $relationship->associated_id)
											<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}">{{ $relationship->associator_name }}</a></p>
											<?php $user_ids[] = $relationship->associator_id; ?>
										@else
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
											<p><a href="{{ route('view-user-profile', $relationship->associator_username_slug) }}">{{ $relationship->associator_name }}</a></p>
											<?php $user_ids[] = $relationship->associator_id; ?>
										@else
											<p><a href="{{ route('view-user-profile', $relationship->associated_username_slug) }}">{{ $relationship->associated_name }}</a></p>
											<?php $user_ids[] = $relationship->associated_id; ?>
										@endif
									@endif
								@endif
							@endforeach
						@endif
					@endif
				</ul>
			</div>
		</div>
	</div>
@stop