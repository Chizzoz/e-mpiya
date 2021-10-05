<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use Illuminate\Http\Request;
use App\models\Content;
use App\models\FactsContent;
use App\models\Genre;

class GenreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }
	// Get specific genre lyrics
	public function getLyricsByGenre(Genre $genre)
	{
		$contents = DB::table('contents')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('genres', 'lyrics_contents.genre_id', '=', 'genres.id')->where('contents.content_type_id', 3)->where('contents.access_platform_id', 3)->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->where('genres.genre_slug', $genre->genre_slug)->orderBy('contents.created_at', 'DESC');
		// get albums
		$albums = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('album', 'album_slug')->get();
		$data['albums'] = $albums;
		// get artists
		$artists = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('artist', 'artist_slug')->get();
		$data['artists'] = $artists;
		// get contributers
		$contributers = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('users', 'contents.user_id', '=', 'users.id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('users.username', 'ASC')->select('username', 'username_slug')->get();
		$data['contributers'] = $contributers;
		// get genres
		$genres = Genre::all();
		$data['genres'] = $genres;
		// get current genre
		$genre = $genre->genre;
		
		// get random Zambian Headline
		$data['random_headline'] = Content::where('content_type_id', 7)->where('created_at', '>', date('Y-m-d G:i:s', time()-8640000))->get()->random(1);
		// get random Zambian fact
		$random_fact = FactsContent::all()->random(1);
		$data['random_fact'] = Content::find($random_fact->content_id);
		
		/* pass variables to view */
		$data['contents_count'] = count($contents->get());
		$data['contents'] = $contents->paginate(15);
		$data['heading'] = $genre . " Lyrics";
		
		return view('layouts.content', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
	}
}
