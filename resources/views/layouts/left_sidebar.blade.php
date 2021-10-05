@section('left_sidebar')
	<div class="large-3 medium-4 small-12 columns left_sidebar">
		<div class="panel">
			<div class="large-12 medium-12 small-12 column weather my-callout">
				<h5>GENRES</h5>
				<ul class="vertical menu genres">
					@foreach ($genres as $genre)
						<li><a href="{{ route('get-lyrics-by-genre', $genre->genre_slug) }}" title="{{ $genre->genre_slug }}">{{ $genre->genre }}</a>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@show