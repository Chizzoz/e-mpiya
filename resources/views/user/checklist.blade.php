@extends('layouts.master')
@section('user_checklist')
	<div class="large-9 medium-9 small-12 column contents">
		@if ($user->id == Auth::user()->id)
			<div class="large-12 medium-12 small-12 columns my-callout">
				<h3>Your Checklist</h3>
			</div>
		@else
			<div class="large-12 medium-12 small-12 columns my-callout">
				<h3>{{ $heading }}</h3>
			</div>
		@endif
		<?php $checklists_count = $checklists_count - (($user_checklists->currentPage() - 1)*15) ?>
		@if ($user_checklists->count() > 0)
			@foreach ($user_checklists as $content)
				<div class="large-12 medium-12 small-12 columns">
					<div class="callout">
						<div class="large-10 medium-10 small-10 column">
							<h4><a href="{{ route('timeline-click-count', array($content->title_slug, $checklists_count)) }}">{{ $content->title }}</a></h4>
						</div>
						<div class="large-2 medium-2 small-2 column">
							@if (!Auth::guest())
								@if (Auth::user()->id == $content->user_id)
									<h4><a href="{{ route('edit-timeline-content', array($content->content_id, $content->title_slug)) }}" class="expanded button">Edit</a></h4>
								@endif
							@endif
						</div>
						<div class="large-12 medium-12 small-12 columns"><small>{{ $content->content_type }} | Posted by: {{ $content->username }} via {{ $content->access_platform }} app on {{ $content->start_date }} </small></div>
						<div class="large-12 medium-12 small-12 columns"><p>{!! $content->body !!}</p></div>
						<div class="large-12 medium-12 small-12 columns">
						@if (!($content->media == ""))
							<p><img src="{{ $content->media }}" alt="{{ $content->caption }}"></p>
							<small>{!! $content->credit !!}</small>
						@endif
						</div>
						<div class="social-share-links">
							<ul class="row medium-up-2">
								<div class="fb-share-button column" data-href="{{ $content->link }}" data-layout="button_count"></div>
								<div class="twitter column"><a href="https://twitter.com/share" class="twitter-share-button" target="_blank" data-url="{{ $content->link }}" data-text="{{ $content->title }}" data-via="oneziko" data-hashtags="ZedMusicTimeline">Share</a></div>
							</ul>
						</div>
						<div class="large-12 medium-12 small-12 columns">
							<h4>Comments</h4>
						</div>
					</div>
				</div>
				<?php $checklists_count -= 1; ?>
			@endforeach
		@else
			@if ($user->id == Auth::user()->id)
				<div class="large-12 medium-12 small-12 columns my-callout">
					<h3>{{ $heading }}</h3>
				</div>
				<p>You currently have no checked content.</p>
			@else
				<div class="large-12 medium-12 small-12 columns my-callout">
					<h3>{{ $heading }}</h3>
				</div>
				<p>{{ $user->username }} currently has no checked content.</p>
			@endif
		@endif
	</div>
	<div class="large-12 medium-12 small-12 column footer-top">
		<center>Pages: 
			@if (isset($user_checklists))
				{!! $user_checklists->render() !!}
			@else
				{{ "Loading Pages >>>" }}
			@endif
		</center>
	</div>
</div>
@stop