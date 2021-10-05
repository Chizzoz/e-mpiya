@extends('layouts.master')
@section('view_creative_content')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents my-callout">
			<div class="large-12 medium-12 small-12 column content-header">
				<div class="large-2 medium-2 small-2 column title-user-picture">
					<a class="user-profile-picture" href="{{ route('view-user-profile', $content->username_slug) }}"><img src="<?php
					if (!($content->user_profile_picture == "")) {
						echo Str::replace('users', 'small', $content->user_profile_picture);
					} else {
						echo asset('/images/small/default-user-profile-picture.png');
					} ?>"></a>
				</div>
				<div class="large-10 medium-10 small-10 column title">
					<h4><a href="{{ route('click-count', $content->title_slug) }}">{{ $content->title }}</a> by <a href="{{ route('get-creative-by-artist', $content->artist_slug) }}">{{ $content->artist }}</a>
						@if (Auth::user()->id == $content->user_id)
							<a href="{{ route('edit-creative-content', $content->title_slug) }}" class="button edit-content">Edit</a>
						@endif
					</h4>
				</div>
			</div>
			<div class="large-12 medium-12 small-12 column">
				<label><h4>Album: <a href="{{ route('get-creative-by-album', $content->album_slug) }}">{{ $content->album }}</a></h4></label>
			</div>
			<div class="large-12 medium-12 small-12 column">
				<label><h4>Genre: <a href="{{ route('get-creative-by-genre', $content->genre_slug) }}" title="{{ $content->genre }}">{{ $content->genre }}</a></h4></label>
			</div>
			<div class="large-12 medium-12 small-12 column">
				@if (!empty($content->creative_media_url))
					@if (str_contains(base_path($content->creative_media_url), 'youtube') && str_contains($content->creative_media_url, 'watch'))
						<iframe width="100%" height="auto" src="{{ Str::replace('watch?v=', 'embed/', $content->creative_media_url) }}" frameborder="0" allowfullscreen></iframe>
					@elseif (str_contains(base_path($content->creative_media_url), 'youtube') && str_contains($content->creative_media_url, 'playlist'))
						<iframe width="100%" height="auto" src="{{ Str::replace('playlist', 'embed/videoseries', $content->creative_media_url) }}" frameborder="0" allowfullscreen></iframe>
					@elseif (str_contains(base_path($content->creative_media_url), 'soundcloud'))
						<div id="player-{{ $content->content_id }}"></div>
						<script>
							SC.oEmbed("{{ $content->creative_media_url }}", {maxheight: "100%", auto_play: false, color: "ffa500"},function(res) {
								var id = <?php echo $content->content_id ?>;
								$('#player-'+id).html(res.html);
							});
						</script>
					@endif
				@endif
			</div>
			<div class="medium-12 column">
				<p>{!! preg_replace('/\<[\/]{0,1}a[^\>]*\>/i','', $content->body) !!}</p>
			</div>
			<div class="large-12 medium-12 small-12 column">
				@if (!empty($content->link))
					Website: <a href="{{ $content->link }}" title="{{ $content->title }}" target="_blank">{{ $content->link }}</a>
				@endif
			</div>
			<div class="large-12 medium-12 small-12 column">
				@if (!empty($content->image))
					<img src="{{ Str::replace('creative/', 'medium/', $content->image)  }}" alt="{{ $content->title }}">
				@endif
			</div>
			<div class="large-12 medium-12 small-12 column">
				<small>{{ $content->content_type }} | Posted by: <a href="{{ route('view-user-profile', $content->username_slug) }}" title="{{ $content->username }}'s Profile">{{ $content->username }}</a> on {{ date_format(date_create($content->created_at), "j F, Y. H:i:s") }} | Accessed via: <a href="{{ url('/') }}" title="Zambian Creatives Web App">{{ $content->access_platform }} app</a></small>
			</div>
			<div class="social-share-links row medium-up-4">
				<div class="one-ziko-check column">
					<?php $checks = App\models\ContentUserFavourite::whereContentId($content->content_id)->count() ?>
					<div id="check-content-<?php echo $content->content_id; ?>">
						<input type="hidden" id="checks-<?php echo $content->content_id; ?>" value="{{ $checks }}">
						<?php
						$user_checked = '';
						if (!Auth::guest()) {
							$user_id = Auth::user()->id;
							$user_checked = App\models\ContentUserFavourite::whereContentId($content->content_id)->whereUserId($user_id)->count();
						}
						$str_check = "check";
						if(!empty($user_checked)) {
						$str_check = "uncheck";
						}
						?>
						<div class="checks-button">
							<div><input type="button" title="<?php echo ucwords($str_check); ?>" class="<?php echo $str_check; ?>" onClick="addChecks(<?php echo $content->content_id; ?>,'<?php echo $str_check; ?>',<?php if (Auth::user()) { echo 1; } else { echo 0; } ?>)" /></div>
						</div>
						<div class="checks-label"><?php if(!empty($checks)) {
							if($checks==1) {
								echo $checks . " check";
							} else {
								echo $checks . " check(s)";
							}
						} else { echo "Check"; } ?></div>
					</div>
				</div>
				<div class="fb-share-button column" data-href="{{ route('view-creative-content', $content->title_slug) }}" data-layout="button_count"></div>
				<div class="twitter column"><a href="https://twitter.com/share" class="twitter-share-button" target="_blank" data-url="{{ route('view-creative-content', $content->title_slug) }}" data-text="{{ $content->title }}" data-via="oneziko" data-hashtags="ZambianCreatives">Share</a>
				</div>
				<div class="whatsapp-share-button column">
					<a href="whatsapp://send" data-text="{{ $content->title }}" data-href="{{ route('view-creative-content', $content->title_slug) }}" class="wa_btn wa_btn_m" style="display:none">Share</a>
				</div>
			</div>
			<div class="large-12 medium-12 small-12 column comments my-callout">
				<h4>Comments</h4>
				<form class="comments-form" name="comment" method="post" action="{{ route('new-comment') }}">
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<input type="hidden" name="content_id" value="{{ $content->content_id }}" />
					<div class="large-12 medium-12 small-12 column">
						<textarea name="comment" placeholder="Enter comment">@if (old('text')) "{{ old('text') }}" @endif</textarea>
						<?php $comment_content_id = old('content_id') ?>
						@if (count($errors) > 0)
							@if ($comment_content_id == $content->content_id)
								@foreach ($errors->get('comment') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
						@endif
					</div>
					<div class="large-12 medium-12 small-12 column">
						<input type="submit" value="Comment" class="expanded button" />
					</div>
				</form>
				<div class="large-12 medium-12 small-12 column comments-wrapper">
					@if (!empty($comments))
						<?php $content_comment_count = 0; ?>
						<table>
							<tbody>
								@foreach($comments as $comment)
									@if ($comment->content_id == $content->content_id)
										<tr>
											<td>
												<div class="content-comment content-{{ $comment->content_id }}-comment">
													<div class="comment comment-{{ $comment->id }}"><a class="user-profile-picture" href="{{ route('view-user-profile', $comment->username_slug) }}"><img src="<?php
														if (!($comment->user_profile_picture == "")) {
															echo Str::replace('users', 'small', $comment->user_profile_picture);
														} else {
															echo asset('/images/small/default-user-profile-picture.png');
														} ?>"></a>{{ $comment->comment }}</div>
													@if (!Auth::guest())
														@if (Auth::user()->id == $comment->user_id)
															<div class="reveal" id="deleteComment-{{$comment->id}}" data-reveal>
																<p>Are you sure you want to Delete this comment?</p>
																<div class="expanded button-group">
																	<a class="button" href="{{ route('delete-comment', array($comment->id, $comment->username_slug)) }}" title="Yes">Yes</a>
																	<a class="button" data-close aria-label="Close modal" title="No">No</a>
																</div>
																<button class="close-button" data-close aria-label="Close modal" type="button">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="comment-actions"><small>Edit | <a data-open="deleteComment-{{$comment->id}}" title="Delete Comment">Delete</a></small></div>
														@endif
													@endif
													<div class="comment-timestamp"><small><i>Commented on {{ $comment->created_at }}</i></small></div>
												</div>
											</td>
										</tr>
										<?php ++$content_comment_count; ?>
									@endif
								@endforeach
							</tbody>
						</table>
						@if ($content_comment_count == 0)
							<div class="large-12 medium-12 small-12 column my-callout">No comments here. Be the first to comment.</div>
						@endif
					@endif
				</div>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			