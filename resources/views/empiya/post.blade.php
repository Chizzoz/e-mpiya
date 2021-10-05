@extends('layouts.master')
@section('post_creative_content')
	<div class="large-12 medium-12 small-12 column new-lyric">
		<div class="large-9 medium-9 small-12 column contents">
			<h1>New {{ $content_type->content_type }}</h1>
			<span>{{ $content_type->content_type }} | 
			Posted by: {{ $user }} | 
			Accessed via: {{ $platform->access_platform }}</span>
			<form action="{{ route('post-creative-content') }}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<!-- Artist -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Artist*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="artist" placeholder="Artist" value="{{ old('artist') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('artist') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Artist, Composer or Poet Name</span>
				</div>
				<!-- Title -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Title*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="title" placeholder="Song Title" value="{{ old('title') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('title') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Song, Performace or Poem Title</span>
				</div>
				<!-- Album -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Album*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="album" placeholder="Album" value="{{ old('album') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('album') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) Album, Performace or Poem Title</span>
				</div>
				<!-- Genre -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Genre*</strong></span>
						</div>
						<div class="medium-9 column">
							<input id="genre" type="text" name="genre" placeholder="Genre" value="{{ old('genre') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('genre') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) The song genre, e.g. Dancehall, Folk, Hip Hop, Kalindula, etc.</span>
				</div>
				<!-- Lyrics -->
				<div class="medium-12 column">
					<textarea id="richtext" name="lyric" rows="10" placeholder="(Required) Enter creative.">{{ old('lyric') }}</textarea>
					<script>
						CKEDITOR.replace( 'richtext' )
					</script>
					@if (count($errors) > 0)
						@foreach ($errors->get('lyric') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
				</div>
				<!-- Media Link -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Media Link</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="creative_media_url" placeholder="Media Link" value="{{ old('creative_media_url') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('creative_media_url') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Media Link to embed from YouTube or Sound Cloud.</span>
				</div>
				<!-- Image -->
				<div class="small-12 medium-12 columns">
					<fieldset>
						<legend>Image</legend>
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>Image Link</strong></span>
							</div>
							<div class="medium-9 column">
								<input type="text" name="image"  placeholder="Image link (http://*.* or www.*.*)" value="{{ old('image') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('image') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="optional">(Optional 1) Enter a web link to your image</span>
						<h5>~ OR ~</h5>
						<div class="medium-12 column">
							<input type="file" name="image_upload"  accept="image/*" />
						<span class="optional">(Optional 2) Upload an image</span>
						</div>
						<p></p>
					</fieldset>
				</div>
				<!-- Website -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Website</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="website" placeholder="Website" value="{{ old('website') }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('website') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Related Website.</span>
				</div>
				<div class="expanded button-group">
					<input type="submit" value="Post" class="button" />
					<!-- <input type="submit" value="Save As Draft" class="button" /> -->
					<a href="{{ route('new-creative-content') }}" class="button">Cancel</a>
				</div>
			</form>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			