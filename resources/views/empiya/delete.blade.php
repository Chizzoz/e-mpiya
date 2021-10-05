@extends('layouts.master')
@section('delete_creative_content')
<div class="row">
	<div class="large-6 column">
		<h1>Delete {{ $lyric->content_type }}</h1>
		{{ $lyric->content_type }} | 
		Posted by: {{ $lyric->username }} | 
		Accessed via: {{ $lyric->access_platform }}
	<section id="">
        <div class="row">
			<div class="small-12 medium-12 large-12 columns">
				<div class="anchor"></div>
				<p><a href="{{ route('view-lyric-content', $lyric->title_slug) }}" class="">View</a><a href="{{ route('edit-lyric-content', $lyric->content_id) }}" class="">Edit</a><a href="{{ route('delete-lyric-content', $lyric->content_id) }}" class="">Delete</a></p>
				<div class="medium-12 column text-center">
					<a href="{{ route('delete-lyric', $lyric->content_id) }}" class="small button">Delete</a>
					<a href="{{ route('user-creative') }}" class="small button">Cancel</a>
				</div>
			</div>
        </div>
    </section>
	</div>
</div>
@stop


			