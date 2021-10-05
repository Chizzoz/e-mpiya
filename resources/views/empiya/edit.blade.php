@extends('layouts.master')
@section('edit_creative_content')
	<div class="large-12 medium-12 small-12 column edit-creative-content">
		<div class="large-9 medium-9 small-12 column contents">
			<h1>Edit {{ $content_type->content_type }}</h1>
			<span>{{ $content_type->content_type }} | 
			Posted by: {{ $user }} | 
			Accessed via: {{ $platform->access_platform }}</span>
			<form action="{{ route('update-creative-content', $content->title_slug) }}" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
				<!-- Artist -->
				<div class="large-12 medium-12 small-12 columns">
					<div class="row collapse prefix-radius">
						<div class="medium-3 columns">
							<span class="prefix"><strong>Artist*</strong></span>
						</div>
						<div class="medium-9 column">
							<input type="text" name="artist" placeholder="Artist Name" value="{{ $creative_content->artist }}" />
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
							<input type="text" name="title" placeholder="Song Title" value="{{ $content->title }}" />
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
							<input type="text" name="album" placeholder="Album" value="{{ $creative_content->album }}" />
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
							<span class="prefix"><strong>Genre</strong></span>
						</div>
						<div class="medium-9 column">
							<input id="genre" type="text" name="genre" placeholder="Genre" value="{{ $genre->genre }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('genre') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="required">(Required) The song genre, e.g. Dancehall, Folk, Hip Hop, Kalindula, etc.</span>
				</div>
				<!-- Creative Content -->
				<div class="medium-12 column">
					<textarea id="richtext" name="creative-content" rows="10" placeholder="(Required) Enter creative.">{{ $content->body }}</textarea>
					<script>
						CKEDITOR.replace( 'richtext' )
					</script>
					@if (count($errors) > 0)
						@foreach ($errors->get('creative-content') as $error)
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
							<input type="text" name="creative_media_url" placeholder="Media Link" value="{{ $creative_content->creative_media_url }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('creative_media_url') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Media Link to embed from YouTube, SoundCloud, etc.</span>
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
								<input type="text" name="image"  placeholder="Image link (http://*.* or www.*.*)" value="{{ $content->image }}" />
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
							<input type="text" name="website" placeholder="Media Link" value="{{ $content->link }}" />
						</div>
					</div>
					@if (count($errors) > 0)
						@foreach ($errors->get('website') as $error)
							<span class="error">{{ $error }}</span>
						@endforeach
					@endif
					<span class="optional">(Optional) Related Website.</span>
				</div>
				<div class="small-12 medium-12 column">
					@if (!empty($content->image))
						<img src="{{ Str::replace('creative/', 'medium/', $content->image)  }}" alt="{{ $content->title }}">
					@endif
				</div>
				<div class="expanded button-group">
					<input type="submit" value="Save" class="button" />
					<div class="reveal" id="deleteCreativeContent" data-reveal>
						<p>Are you sure you want to delete this creative content?</p>
						<div class="expanded button-group">
							<a class="button" href="{{ route('delete-creative-content', array(Auth::user()->username_slug, $content->title_slug)) }}" title="Delete Creative Content">Yes</a>
							<a class="button" data-close aria-label="Close modal" title="No">No</a>
						</div>
						<button class="close-button" data-close aria-label="Close modal" type="button">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<a class="button" data-open="deleteCreativeContent" title="Delete Creative Content">Delete</a>
					<a href="{{ route('view-creative-content', $content->title_slug) }}" class="button">Cancel</a>
				</div>
			</form>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			