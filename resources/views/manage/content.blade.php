@extends('layouts.master')
@section('manage_content')
	<div class="large-9 medium-9 small-12 column contents">
		<?php
			$content_count = count($contents);
			$user_admin_access = App\models\UserAccess::whereUserRoleId(1)->whereUserId(Auth::user()->id)->orderBy('user_role_id', 'ASC')->first()
		?>
		@if ($content_count > 0)
		<table class="stack hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Content Type</th>
					<th>Published By</th>
					<th>Summary</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($contents as $content)
					<tr>
						<td>{{ $content_count }}</td>
						<td><a href="{{ route('view-creative-content', $content->title_slug) }}">{{ $content->title }}</a></td>
						<td>{{ $content->content_type }}</td>
						<td>{{ $content->username }}</td>
						<td>{!! str_limit($content->body, 250) !!}</td>
						<td>
							@if (isset($user_admin_access))
								<!-- Approve -->
								@if ($content->is_approved == 1)
									<div class="reveal" id="unApprove-{{$content->content_id}}" data-reveal>
										<p>Are you sure you want to UnApprove this Lyric?</p>
										<div class="expanded button-group">
											<a class="button" href="{{ route('unapprove-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Yes">Yes</a>
											<a class="button" data-close aria-label="Close modal" title="No">No</a>
										</div>
										<button class="close-button" data-close aria-label="Close modal" type="button">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<a class="button alert small" data-open="unApprove-{{$content->content_id}}" title="UnApprove Lyric">UnApprove</a>
								@else
									<div class="reveal" id="approve-{{$content->content_id}}" data-reveal>
										<p>Are you sure you want to Approve this Lyric?</p>
										<div class="expanded button-group">
											<a class="button" href="{{ route('approve-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Yes">Yes</a>
											<a class="button" data-close aria-label="Close modal" title="No">No</a>
										</div>
										<button class="close-button" data-close aria-label="Close modal" type="button">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<a class="button success small" data-open="approve-{{$content->content_id}}" title="Approve Lyric">Approve</a>
								@endif
							@endif
							<!-- Publish -->
							@if ($content->is_published == 1)
								<div class="reveal" id="unpublish-{{$content->content_id}}" data-reveal>
									<p>Are you sure you want to Unpublish this Lyric?</p>
									<div class="expanded button-group">
										<a class="button" href="{{ route('unpublish-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Yes">Yes</a>
										<a class="button" data-close aria-label="Close modal" title="No">No</a>
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<a class="button alert small" data-open="unpublish-{{$content->content_id}}" title="Unpublish Lyric">Unpublish</a>
							@else
								<div class="reveal" id="publish-{{$content->content_id}}" data-reveal>
									<p>Are you sure you want to Publish this Lyric?</p>
									<div class="expanded button-group">
										<a class="button" href="{{ route('publish-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Yes">Yes</a>
										<a class="button" data-close aria-label="Close modal" title="No">No</a>
									</div>
									<button class="close-button" data-close aria-label="Close modal" type="button">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<a class="button success small" data-open="publish-{{$content->content_id}}" title="Publish Lyric">Publish</a>
							@endif
							<!-- Edit -->
							<a class="button small" href="{{ route('edit-creative-content', $content->title_slug) }}" title="Edit Lyric">Edit</a>
							<!-- Delete -->
							<div class="reveal" id="delete-{{ $content->title_slug }}" data-reveal>
								<p>Are you sure you want to delete this Lyric?</p>
								<div class="expanded button-group">
									<a class="button" href="{{ route('delete-creative-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Delete Lyric">Yes</a>
									<a class="button" data-close aria-label="Close modal" title="No">No</a>
								</div>
								<button class="close-button" data-close aria-label="Close modal" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<a class="button small alert" data-open="delete-{{ $content->title_slug }}" title="Delete Lyric">Delete</a>
						</td>
						<?php $content_count--; ?>
					</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p>You currently have no content to manage. <a href="{{ route('new-creative-content') }}" title="Post New Lyric">Post a new lyric</a> to get started.</p>
		@endif
	</div>
</div>
@stop