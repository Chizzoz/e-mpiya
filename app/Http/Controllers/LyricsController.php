<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\models\AccessPlatform;
use App\models\Content;
use App\models\ContentType;
use App\models\FactsContent;
use App\models\Genre;
use App\models\LyricsContent;
use App\Models\User;
use DB;
use Illuminate\Http\Request AS Requested;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Image;

class LyricsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index/ homepage
	public function index()
    {
        return view('layouts.content');
    }

    // create new Lyric form
	public function newLyricsContent()
    {
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(3);
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user->username;
		$data['heading'] = "New Lyric";
		// get genres list
		$genres_list = Genre::orderBy('genre', 'asc')->lists('genre');
		$genres_list->toJson();
		$data['genres_list'] = $genres_list;
		// get albums
		$albums = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('album', 'album_slug')->get();
		$data['albums'] = $albums;
		// get artists
		$artists = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('artist', 'artist_slug')->get();
		$data['artists'] = $artists;
		// get contributers
		$contributers = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('users', 'contents.user_id', '=', 'users.id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('users.username', 'ASC')->select('username', 'username_slug')->get();
		$data['contributers'] = $contributers;
		// get all genres
		$genres = Genre::all();
		$data['genres'] = $genres;
		
		// get random Zambian Headline
		$data['random_headline'] = Content::where('content_type_id', 7)->where('created_at', '>', date('Y-m-d G:i:s', time()-8640000))->get()->random(1);
		// get random Zambian fact
		$random_fact = FactsContent::all()->random(1);
		$data['random_fact'] = Content::find($random_fact->content_id);
		
        return view('lyrics.post', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }
	
	// Post lyrics content
	public function postLyricsContent(Requested $request)
	{
		$this->validate($request, [
			'artist' => 'required|max:255',
			'title' => 'required|max:255',
			'album' => 'required|max:255',
			'genre' => 'required|max:255',
			'lyric' => 'required',
			'lyrics_media_url' => 'url',
			'image' => 'url',
			'website' => 'url',
		]);
		
		// Create lyrics Content and assign defaults
		$content = new Content;
		$content->content_type_id = 3;
		$content->title = $request->title;
		$user = auth()->user();
		$content->user_id = $user->id;
		$content->access_platform_id = 3;
		$content->body = $request->lyric;
		// lyric image
		if (Request::has('image')) {
			if (!($content->image == $request->image)) {
				if (str_contains($request->image, 'oneziko.com/public')) {
					$content->image = $request->image;
				} else {
					$image_url = Str::replace('"', "'", $request->image);
					$basename  = basename($image_url);
					$file_ext = pathinfo($basename, PATHINFO_EXTENSION);
					$filename  = $user->id . '-' . date("dmY-His.") . $file_ext;
					$path = public_path('images/lyrics/' . $filename);
					$image = Image::make($image_url)->save($path);
					$content->image = url('public/images/lyrics/' . $filename);
				}
			}
		}
		if (Request::hasFile('image_upload')) {
			$file = $request->file('image_upload');
			$file_ext = Str::replace('image/', '', $file->getMimeType());
			$filename  = $user->id . '-' . date("dmY-His.") . $file_ext;
			$path = public_path('images/lyrics/' . $filename);
			$image = Image::make($file->getRealPath())->save($path);
			$content->image = url('public/images/lyrics/' . $filename);
		}
		$content->link = $request->website;
		$content->is_draft = 0;
		$content->is_approved = 1;
		$content->is_published = 1;
		$content->title_slug = Str::slug($content->title, "-");
		$content->save();
		
		// Capture lyrics Form Data
		$lyric = new LyricsContent;
		$lyric->content_id = $content->id;
		// Genre ID
		$genres = Genre::orderBy('genre', 'asc')->select('genre')->get();
		$genres_array = array();
		foreach ($genres as $genre) {
			$genres_array[] = $genre->genre;
		}
		if (in_array($request->genre, $genres_array)) {
			$select_genre = Genre::where('genre', $request->genre)->first();
			$lyric->genre_id = $select_genre->id;
		} else {
			if ($request->genre != "") {
				$new_genre = new Genre;
				$new_genre->genre = $request->genre;
				$new_genre->genre_slug = Str::slug($new_genre->genre, "-");
				$new_genre->save();
				$lyric->genre_id = $new_genre->id;
			}
		}
		$lyric->artist = $request->artist;
		$lyric->artist_slug = Str::slug($lyric->artist, "-");
		$lyric->album = $request->album;
		$lyric->album_slug = Str::slug($lyric->album, "-");
		$lyric->lyrics_media_url = $request->lyrics_media_url;
		$lyric->save();

		return redirect(route('view-lyrics-content', $content->title_slug));
	}

	// view single lyrics content
	public function viewLyricsContent(Content $content_title_slug)
	{
		// get authenticated user
		$data['user'] = auth()->user();
		// get lyrics content
		$content = DB::table('contents')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('genres', 'lyrics_contents.genre_id', '=', 'genres.id')->where('contents.content_type_id', 3)->where('contents.access_platform_id', 3)->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->where('contents.title_slug', $content_title_slug->title_slug)->first();
		$data['content'] = $content;
		// get albums
		$albums = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('album', 'album_slug')->get();
		$data['albums'] = $albums;
		// get artists
		$artists = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('artist', 'artist_slug')->get();
		$data['artists'] = $artists;
		// get contributers
		$contributers = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('users', 'contents.user_id', '=', 'users.id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('users.username', 'ASC')->select('username', 'username_slug')->get();
		$data['contributers'] = $contributers;
		// get all genres
		$genres = Genre::all();
		$data['genres'] = $genres;
		// heading
		$data['heading'] = $content->title . ' by ' . $content->artist;
		
		// Comments
		$comments = DB::table('comments')->join('contents', 'comments.content_id', '=', 'contents.id')->join('users', 'comments.user_id', '=', 'users.id')->where('contents.content_type_id', 3)->where('comments.is_approved', 1)->orderBy('comments.created_at', 'asc')->select('comments.id AS id', 'comments.comment AS comment', 'comments.created_at AS created_at', 'comments.content_id AS content_id', 'comments.user_id AS user_id', 'users.username AS username', 'users.username_slug AS username_slug', 'users.user_profile_picture AS user_profile_picture');
		$data['comments_count'] = count($comments->get());
		$data['comments'] = $comments->get();
		
		// get random Zambian Headline
		$data['random_headline'] = Content::where('content_type_id', 7)->where('created_at', '>', date('Y-m-d G:i:s', time()-8640000))->get()->random(1);
		// get random Zambian fact
		$random_fact = FactsContent::all()->random(1);
		$data['random_fact'] = Content::find($random_fact->content_id);
		
		return view('lyrics.view', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
	}
	// edit single lyrics content
	public function editLyricsContent(Content $content_title_slug)
	{
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(3);
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user->username;
		// Lyrics content
		$data['content'] = Content::find($content_title_slug->id);
		$lyrics_content = LyricsContent::whereContentId($content_title_slug->id)->get()->first();
		$data['lyrics_content'] = $lyrics_content;
		$data['genre'] = Genre::find($lyrics_content->genre_id);
		// get albums
		$albums = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('album', 'album_slug')->get();
		$data['albums'] = $albums;
		// get artists
		$artists = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('lyrics_contents.artist', 'ASC')->select('artist', 'artist_slug')->get();
		$data['artists'] = $artists;
		// get contributers
		$contributers = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('users', 'contents.user_id', '=', 'users.id')->distinct()->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('users.username', 'ASC')->select('username', 'username_slug')->get();
		$data['contributers'] = $contributers;
		// get all genres
		$genres = Genre::all();
		$data['genres'] = $genres;
		// heading
		$data['heading'] = "Edit - " . $content_title_slug->title . ' by ' . $lyrics_content->artist;
		
		// get random Zambian Headline
		$data['random_headline'] = Content::where('content_type_id', 7)->where('created_at', '>', date('Y-m-d G:i:s', time()-8640000))->get()->random(1);
		// get random Zambian fact
		$random_fact = FactsContent::all()->random(1);
		$data['random_fact'] = Content::find($random_fact->content_id);
		
		return view('lyrics.edit', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
	}

	// edit single lyrics content
	public function updateLyricsContent(Requested $request, Content $content_title_slug)
	{
		$this->validate($request, [
			'artist' => 'required|max:255',
			'title' => 'required|max:255',
			'album' => 'required|max:255',
			'genre' => 'required|max:255',
			'lyric' => 'required',
			'lyrics_media_url' => 'url',
			'image' => 'url',
			'website' => 'url',
		]);
		
		// Create lyrics Content and assign defaults
		$content = Content::find($content_title_slug->id);
		$content->title = $request->title;
		$content->title_slug = Str::slug($content->title, "-");
		$content->body = $request->lyric;
		$user = auth()->user();
		// lyric image
		if (Request::has('image')) {
			if (!($content->image == $request->image)) {
				if (str_contains($request->image, 'oneziko.com/public')) {
					$content->image = $request->image;
				} else {
					$image_url = Str::replace('"', "'", $request->image);
					$basename  = basename($image_url);
					$file_ext = pathinfo($basename, PATHINFO_EXTENSION);
					$filename  = $user->id . '-' . date("dmY-His.") . $file_ext;
					$path = public_path('images/lyrics/' . $filename);
					$image = Image::make($image_url)->save($path);
					$content->image = url('public/images/lyrics/' . $filename);
				}
			}
		} else {
			$content->image = "";
		}
		if (Request::hasFile('image_upload')) {
			$file = $request->file('image_upload');
			$file_ext = Str::replace('image/', '', $file->getMimeType());
			$filename  = $user->id . '-' . date("dmY-His.") . $file_ext;
			$path = public_path('images/lyrics/' . $filename);
			$image = Image::make($file->getRealPath())->save($path);
			$content->image = url('public/images/lyrics/' . $filename);
		}
		$content->link = $request->website;
		$content->save();
		
		// Capture lyrics Form Data
		$lyric = LyricsContent::whereContentId($content->id)->first();
		// Genre ID
		$genres = Genre::orderBy('genre', 'asc')->select('genre')->get();
		$genres_array = array();
		foreach ($genres as $genre) {
			$genres_array[] = $genre->genre;
		}
		if (in_array($request->genre, $genres_array)) {
			$select_genre = Genre::where('genre', $request->genre)->first();
			$lyric->genre_id = $select_genre->id;
		} else {
			if ($request->genre != "") {
				$new_genre = new Genre;
				$new_genre->genre = $request->genre;
				$new_genre->genre_slug = Str::slug($new_genre->genre, "-");
				$new_genre->save();
				$lyric->genre_id = $new_genre->id;
			}
		}
		$lyric->artist = $request->artist;
		$lyric->artist_slug = Str::slug($lyric->artist, "-");
		$lyric->album = $request->album;
		$lyric->album_slug = Str::slug($lyric->album, "-");
		$lyric->lyrics_media_url = $request->lyrics_media_url;
		$lyric->save();
		
		return redirect(route('view-lyrics-content', $content->title_slug));
	}

	// delete single lyrics content
	public function deleteLyricsContent(User $user, Content $content_title_slug)
	{
		// check if logged in user same as profile page owner
		if ($user->id != $content_title_slug->user_id) {
			abort(404);
		}
		Content::find($content_title_slug->id)->delete();
		LyricsContent::where('content_id', $content_title_slug->id)->first()->delete();
		
		return redirect(route('new-lyrics-content'));
	}
}
