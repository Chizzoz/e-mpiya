@extends('layouts.master')
@section('home')
	<?php
		$path = Request::path();
	?>
	<div class="fluid_container">
		<div class="camera_wrap camera_azure_skin" id="camera_random_">
			<?php
				$slides = array(
					'<div data-thumb="images/slides/thumbs/bridge.jpg" data-src="images/slides/bridge.jpg">
						<div class="camera_caption fadeFromBottom">
							Camera is a responsive/adaptive slideshow. <em>Try to resize the browser window</em>
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/leaf.jpg" data-src="images/slides/leaf.jpg">
						<div class="camera_caption fadeFromBottom">
							It uses a light version of jQuery mobile, <em>navigate the slides by swiping with your fingers</em>
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/road.jpg" data-src="images/slides/road.jpg">
						<div class="camera_caption fadeFromBottom">
							<em>It\'s completely free</em> (even if a donation is appreciated)
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/sea.jpg" data-src="images/slides/sea.jpg">
						<div class="camera_caption fadeFromBottom">
							Camera slideshow provides many options <em>to customize your project</em> as more as possible
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/shelter.jpg" data-src="images/slides/shelter.jpg">
						<div class="camera_caption fadeFromBottom">
							It supports captions, HTML elements and videos and <em>it\'s validated in HTML5</em> (<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fwww.pixedelic.com%2Fplugins%2Fcamera%2F&amp;charset=%28detect+automatically%29&amp;doctype=Inline&amp;group=0&amp;user-agent=W3C_Validator%2F1.2" target="_blank">have a look</a>)
						</div>
					</div>',
					'<div data-thumb="images/slides/thumbs/tree.jpg" data-src="images/slides/tree.jpg">
						<div class="camera_caption fadeFromBottom">
							Different color skins and layouts available, <em>fullscreen ready too</em>
						</div>
					</div>'
				);
				foreach ($slides as $slides) {
					//echo "$slides\n";
				}
			?>
		</div><!-- #camera_random -->
	</div><!-- .fluid_container -->
	<div class="large-9 medium-9 small-12 column contents">
		@if (!($heading == "Homepage" || str_contains($heading, 'User Profile') || str_contains($heading, "'s Checklist")))
			<div class="large-12 medium-12 small-12 columns my-callout">
				<h3>{{ $heading }}</h3>
			</div>
		@endif
		@if ($contents->count() > 0 && str_contains($heading, "'s Checklist"))
			@if ($user->id == Auth::user()->id)
				<div class="large-12 medium-12 small-12 columns my-callout">
					<h3>Your Checklist</h3>
				</div>
			@else
				<div class="large-12 medium-12 small-12 columns my-callout">
					<h3>{{ $heading }}</h3>
				</div>
			@endif
		@endif
		<div class="large-12 medium-12 small-12 main column">	
		<div class="grid" data-masonry='{ "itemSelector": ".grid-item" }'>
			@if (!is_null($contents))
				@if ($contents->count() > 0)
					@foreach ($contents as $content)
						<div class="large-6 medium-6 small-12 columns grid-item">
							<div class="large-12 medium-12 small-12 column my-callout">
								<div class="content-header">
									<div class="large-3 medium-3 small-3 column title-user-picture">
										<a class="user-profile-picture" href="{{ route('view-user-profile', $content->username_slug) }}"><img src="<?php
										if (!($content->user_profile_picture == "")) {
											echo Str::replace('users', 'small', $content->user_profile_picture);
										} else {
											echo asset('/images/small/default-user-profile-picture.png');
										} ?>"></a>
									</div>
									<div class="large-9 medium-9 small-9 column title">
										<h4><a href="{{ route('click-count', $content->title_slug) }}">{{ $content->title }}</a></h4>
									</div>
								</div>
								@if (!empty($content->empiya_content_video_url))
									@if (str_contains(base_path($content->empiya_content_video_url), 'youtube') && str_contains($content->empiya_content_video_url, 'watch'))
										<iframe width="100%" height="auto" src="{{ Str::replace('watch?v=', 'embed/', $content->empiya_content_video_url) }}" frameborder="0" allowfullscreen></iframe>
									@elseif (str_contains(base_path($content->empiya_content_video_url), 'youtube') && str_contains($content->empiya_content_video_url, 'playlist'))
										<iframe width="100%" height="auto" src="{{ Str::replace('playlist', 'embed/videoseries', $content->empiya_content_video_url) }}" frameborder="0" allowfullscreen></iframe>
									@elseif (str_contains(base_path($content->empiya_content_video_url), 'soundcloud'))
										<div id="player-{{ $content->content_id }}"></div>
										<script>
											SC.oEmbed("{{ $content->empiya_content_video_url }}", {maxheight: "100%", auto_play: false, color: "ffa500"},function(res) {
												var id = <?php echo $content->content_id ?>;
												$('#player-'+id).html(res.html);
											});
										</script>
									@endif
								@endif
								<p>{!! str_limit(preg_replace('/\<[\/]{0,1}a[^\>]*\>/i','', preg_replace('/\<[\/]{0,1}div[^\>]*\>/i', '<p>', $content->body)), 500) !!}</p>
								<p><small><a href="{{ route('click-count', $content->title_slug) }}">Read more...</a></small></p>
								@if (!empty($content->link))
									<p class="website">Website: <a href="{{ $content->link }}" title="{{ $content->title }}" target="_blank">{{ $content->link }}</a></p>
								@endif
								@if (!empty($content->image))
									<p><a href="{{ route('view-empiya-content', $content->title_slug) }}" ><img src="{{ $content->image }}" alt="{{ $content->title }}" title="{{ $content->title }}"></a></p>
								@endif
								<small>{{ $content->content_type }} | Posted by: <a href="{{ route('view-user-profile', $content->username_slug) }}" title="{{ $content->username }}'s Profile">{{ $content->username }}</a> on {{ date_format(date_create($content->created_at), "j F, Y. H:i:s") }} | Accessed via: <a href="{{ url('/') }}" title="Zambian Facts Web App">{{ $content->access_platform }} app</a></small>
								@include('layouts.share_links')
								@include('layouts.comments')
							</div>
						</div>
					@endforeach
				@else
					@if (str_contains($path, 'user'))
						@if (Auth::user()->id == $user->id)
							@if (str_contains($path, 'checklist'))
								<div class="large-12 medium-12 small-12 columns my-callout">
									<h3>This is your Checklist Page</h3>
								</div>
								<div class="large-12 medium-12 small-12 columns">
									<p>You currently haven't "checked" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > any e-Mpiya content. You can view e-Mpiya content posted by yourself and other users, and "check" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > the one's that you find interesting, they will appear here. Checking content is a good way to keep track of all the e-Mpiya content you like.</p>
								</div>
							@else
								<div class="large-12 medium-12 small-12 columns my-callout">
									<h3>Welcome to e-Mpiya</h3>
								</div>
								<div class="large-12 medium-12 small-12 columns">
									<p>You currently do not have any e-Mpiya transactions. Create a new e-Mpiya transaction to get started. Go to your <a href="{{ route('edit-user-profile', Auth::user()->username_slug) }}">Edit Profile</a> page to update your personal information.</p>
								</div>
							@endif
						@else
							@if (str_contains($path, 'checklist'))
								<div class="large-12 medium-12 small-12 columns my-callout">
									<h3>This is {{ $user->username }}'s Checklist Page</h3>
								</div>
								<div class="large-12 medium-12 small-12 columns">
									<p>{{ $user->username }} currently hasn't "checked" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > any e-Mpiya content. Encourage {{ $user->username }} to "check" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > some interesting e-Mpiya content and they will appear here. Checking content is a good way to keep track of all the e-Mpiya content you like.</p>
								</div>
							@else
								<div class="large-12 medium-12 small-12 columns my-callout">
									<h3>Welcome to {{ $user->username }}'s Profile</h3>
								</div>
								<div class="large-12 medium-12 small-12 columns">
									<p>{{ $user->username }} currently hasn't done any e-Mpiya transactions. Encourage {{ $user->username }} to transact using e-Mpiya.</p>
								</div>
							@endif
						@endif
					@else
						@if (Auth::guest())
							<div class="large-12 medium-12 small-12 columns my-callout">
								<h3>Welcome to e-Mpiya</h3>
							</div>
							<div class="large-12 medium-12 small-12 columns">
								<p>There are currently no e-Mpiya content posted. <a href="{{ url('register') }}" title="Sign up">Sign up</a>  to get started and share your e-Mpiya works.</p>
							</div>
						@else
							<div class="large-12 medium-12 small-12 columns my-callout">
								<h3>Welcome to e-Mpiya</h3>
							</div>
							<div class="large-12 medium-12 small-12 columns">
								<p>There are currently no e-Mpiya transactions. Get started by transacting using the various options in transactions section. Go to your <a href="{{ route('edit-user-profile', Auth::user()->username_slug) }}">Edit Profile</a> page to update your personal information.</p>
							</div>
						@endif
					@endif
				@endif
			@else
				@if (Auth::user()->id == $user->id)
					<div class="large-12 medium-12 small-12 columns my-callout">
						<h3>Welcome to Zambian e-Mpiyas</h3>
					</div>
					<div class="large-12 medium-12 small-12 columns">
						<p>You currently have no e-Mpiya content sources selected or "checked" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > content. Go to <a href="{{ route('edit-user-preferences', Auth::user()->username_slug) }}">Edit Preferences</a> and select one or more e-Mpiya content sources or "check" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > some e-Mpiya content that interest you.</p>
					</div>
				@else
					<div class="large-12 medium-12 small-12 columns my-callout">
						<h3>Welcome to {{ $user->username }}'s Profile</h3>
					</div>
					<div class="large-12 medium-12 small-12 columns">
						<p>{{ $user->username }} currently has no e-Mpiya content shared. Encourage {{ $user->username }} to "check" <img src="{{ asset('/img/check.png') }}" title="check" alt="check" > some e-Mpiya content or add some e-Mpiya content sources in their <a href="{{ route('edit-user-preferences', Auth::user()->username_slug) }}">Edit Preferences</a> section.</p>
					</div>
				@endif
			@endif
		</div>
		</div>
		@if (!is_null($contents))
			@if ($contents->count() > 15)
				<div class="large-12 medium-12 small-12 column footer-top">
					<center>
						Pages: 
						{!! $contents->render() !!}
					</center>
				</div>
			@endif
		@endif
	</div>
	@yield('right_sidebar')
@stop