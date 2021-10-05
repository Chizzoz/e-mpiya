<!-- Comments -->
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
												<div class="comment-actions"><small><a data-open="deleteComment-{{$comment->id}}" title="Delete Comment">Delete</a></small></div>
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
		@else
			<div class="large-12 medium-12 small-12 column my-callout">No comments here. Be the first to comment.</div>
		@endif
	</div>
</div>
