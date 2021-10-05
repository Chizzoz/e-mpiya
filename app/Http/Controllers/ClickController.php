<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\models\Content;
use Illuminate\Http\Request;
use Redirect;

class ClickController extends Controller
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
	
	public function clickCount(Content $content_title_slug)
	{
		$content = Content::find($content_title_slug->id);
		$content->increment('clicks');
		$content->save();
		$url = $content_title_slug->link;
		
		return redirect(route('view-lyrics-content', $content_title_slug->title_slug));
	}
}
