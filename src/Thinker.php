<?php namespace Nonoesp\Thinker;

use Illuminate\Support\Str;

class Thinker {


	/*
	 * Converts $title to Title Case, and returns the result.
	 * http://www.sitepoint.com/blogs/2005/03/15/title-case-in-php/
	 *
	 * Give it a Word Case Title

	 */

	public static function title($str) {
		// strtolower > all
		// $title = strtolower(str_replace('_', ' ', $title));

		// smallWordsArray which shouldn't be capitalised if they aren't the first word.
		//$smallWordsArray = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off','for','in','out','over','to','into','with' );
		$smallWordsArray = array( 'of', 'an','or','nor','but','is','if','then','else','at','from','by','off','for','in','out','over','to','into','with' );

		// Split the string into separate words
		$words = explode(' ', $str);
		foreach ($words as $key => $word) {

			// capitalize / ucwords > first or if not smallWordsArray
			//if ($key == 0 or !in_array($word, $smallwordsarray)) $words[$key] = ucwords($word);

			// strtolower > smallWordsArray
			if ( $key != 0 and in_array(strtolower($word), $smallWordsArray) ) $words[$key] = strtolower($word);

		}

		// Join the words back into a string
		$result = implode(' ', $words);

		return $result;
	}

	public static function uniqueSlugWithTableAndTitle($table, $title, $slug_row = 'slug') {
		$slug_original = Str::slug($title);
		$slug = $slug_original;
		$slugExists = true;
		$idx = 0;
		while($slugExists) {

			if(\DB::table($table)->where($slug_row, $slug)->count()) {
				$slug = $slug_original.'-'.($idx+2);
			} else {
				$slugExists = false;
			}
			$idx++;
		}

		return $slug;
	}

	public static function videoWithURL($video, $class) {

		$isYoutube = false;
		$isVimeo = false;

		if(strpos($video, "youtube.com") != false){
		$isYoutube = true;
		} else if (strpos($video, "youtu.be") != false) {
		$isYoutube = true;
		} else if (strpos($video, "vimeo.com") != false) {
		$isVimeo = true;
		}

		if ($isYoutube) {
		$o = '';
		$code = explode('v=', $video);
		$code = $code[1];

		if($code != ''){
			//TODO: Make a view template with blade View::make('c-video-thumb')->with([$args]) type youtube
		  return '<p class="[ '.$class.' ]  [ video-thumb  js-video-thumb ]" data-url="'.$code.'" data-service="youtube">'
				  .'<img class="video-thumb__mask" src="/img/video-mask-youtube.png">'
				  .'<img class="video-thumb__image video-thumb__image--youtube" src="http://img.youtube.com/vi/'.$code.'/0.jpg">'
			 	  .'</p>';
		} else {
		  return '';
		}
		}

		if ($isVimeo) {
		$code = explode('vimeo.com/', $video);
		$code = $code[1];

		if($code != ''){
			//TODO: Make a view template with blade View::make('c-video-thumb')->with([$args]) type vimeo
		  return '<p class="[ '.$class.' ]  [ video-thumb  js-video-thumb ]" data-url="'.$code.'" data-service="vimeo">'
		    .'<img class="video-thumb__mask" src="/img/video-mask-vimeo.png">'
		    .'<img class="video-thumb__image video-thumb__image--vimeo" src="'.Thinker::getVimeoThumb($code).'">'
		    .'</p>';
		} else {
		  return '';
		}
		}
	}

	public static function getVideoThumb($video) {

		$isYoutube = false;
		$isVimeo = false;

		if(strpos($video, "youtube.com") != false){
		$isYoutube = true;
		} else if (strpos($video, "youtu.be") != false) {
		$isYoutube = true;
		} else if (strpos($video, "vimeo.com") != false) {
		$isVimeo = true;
		}

		if ($isYoutube) {
	  		$code = explode('v=', $video);
	  		$code = $code[1];

	  		if($code != ''){
				return Thinker::getYoutubeThumb($code);
	  		} else {
	    		return '';
	  		}
		}

		if ($isVimeo) {
	  		$code = explode('vimeo.com/', $video);
	  		$code = $code[1];

	  		if($code != ''){
	  			return Thinker::getVimeoThumb($code);
	  		} else {
	    		return '';
	  		}
		}
	}

	public static function getYoutubeThumb($id) {
  		return 'http://img.youtube.com/vi/'.$id.'/0.jpg';
	}

	/**
	 * Gets a vimeo thumbnail url
	 * @param mixed $id A vimeo id (ie. 1185346)
	 * @return thumbnail's url
	*/

	public static function getVimeoThumb($id) {
	    $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
	    $data = json_decode($data);
	    return $data[0]->thumbnail_large;
	}

	public static function IsInstagramPostURL($URL) {
		if( count(explode("instagram.com/", $URL)) > 1 &&
			count(explode("media", $URL)) == 1) {
			return true;
		}
		return false;
	}

	/**
	 * Get the URL of an Instagram post
	 * @param $URL Instagram media URL
	 * @param $size Instagram media URL (l, m, s, t [thumbnail])
	 * @return Complete URL
	*/

	public static function InstagramImageURL($URL, $size = 'l') {
		$code = explode('instagram.com/p/', explode("?", $URL)[0])[1];
		return 'https://instagram.com/p/'.$code.'media/?size='.$size;
	}

	/*
	/
	/ limitMarkdownText v0.7
	/
	/ $text				String 	(text to limit)
	/ $limit 			String 	(maximum amount of characters)
	/ $ignored_tags		Array 	(tags to ignore, like ['figure', 'img'])
	/
	*/

	public static function limitMarkdownText($str, $limit, $ignored_tags = false) {

		// Remove content in $ignored_tags
		if ($ignored_tags) {
			$str = Thinker::removeTagsFromString($str, $ignored_tags);
		}

		// Shorten Markdown
		$str = preg_replace( "/\r|\n/", " ", strip_tags($str));
		$str_limited = Str::limit($str, $limit);

		// Text < Limit
		if (strlen($str) == strlen($str_limited)) return $str;

		// Text > Limit
		$str_limited_words = explode(" ", $str_limited);
		array_pop($str_limited_words);
		$str_limited = join($str_limited_words, " ").'…';

		return $str_limited;
	}

	public static function getLocaleDisplayed() {
		$accepted_locales = array('en', 'es');
		$browser_locale = \App::getLocale();
		if (in_array($browser_locale, $accepted_locales)) {
			return $browser_locale;
		} else {
			return \Config::get('app.fallback_locale');
		}
	}

	public static function array_rand_value($array) {
		if(count($array)) {
			return $array[array_rand($array, 1)];
		} else {
			return '';
		}
	}

	public static function HTMLFigure($URL, $caption = false, $class = false) {

		$result = '<figure class="'.$class.'">
  <img src="'.$URL.'" alt="'.$caption.'">';

        if($class) {
          $result .= '
  <figcaption>'.$caption.'</figcaption>';
        }

		$result .= '
</figure>';

		return $result;
	}

	public static function removeTagsFromString($str, $tags) {
		foreach ($tags as $tag) {
			$str = preg_replace('/<'.$tag.'[^>]*>.*?<\/'.$tag.'>/i', '', $str);
		}
		return $str;
	}

	public static function StringFromTagList($tagList, $lowerCase = true, $ShouldAddComma = false) {
		$index = 0;
		$str = "";
		foreach($tagList as $tag) {
			if($index > 0) {
				if($ShouldAddComma) $str .= ",";
				$str .= " ";
			}
			if($lowerCase) {
				$str .= strtolower($tag);
			} else {
				$str .= $tag;
			}
			$index++;
		}
		return $str;
	}

  public static function filesFrom($path) {

    if(!is_dir($path))
      return [];

    $files = scandir($path);
    unset($files[0]); // .
    unset($files[1]); // ..

    if(($key = array_search('emails', $files)) !== false) {
      unset($files[$key]);
    }

    return $files;
  }

}
