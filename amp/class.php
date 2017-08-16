<?php
class ampress
{
	public static function init()
	{
		self::addCustomRoutes();
		self::addCanonicalTags();
		self::showTemplate();
	}

	public static function addCustomRoutes()
	{
	    add_action('init', function()
	    {
	        add_rewrite_endpoint( 'amp', EP_PERMALINK );
	    });
	}

	public static function addCanonicalTags()
	{
		add_action('wp_head', function()
		{
			if( is_single() && !self::isAmpPage() )
			{
				echo '<link rel="amphtml" href="'.get_permalink().'amp/">';
			}
		});
	}

	public static function showTemplate()
	{
		add_action( 'template_redirect', function()
		{
			if( !self::isAmpPage() )
			{
				return;
			}
			include dirname(__FILE__).'/template.php';
			die();
		});
	}

	public static function isAmpPage()
	{
		global $wp_query;
		if( isset($wp_query->query_vars['amp']) && is_single() )
		{
			return true;
		}		
		return false;
	}

	public static function showImage($url, $class = null, $width = null, $height = null)
	{
		if( strpos($url, 'http') !== 0 )
		{
			$url = get_bloginfo('template_directory').'/images/'.$url;
		}
		if( $width === null || $height === null )
		{
		$size = getimagesize($url);
			$width = $size[0];
			$height = $size[1];
		}
		return '<div class="amp-img-container"><amp-img'.(($class !== null)?(' class="'.$class.'"'):('')).' src="'.$url.'" width="'.$width.'" height="'.$height.'" layout="responsive"></amp-img></div>';
	}

	public static function showVideo($url)
	{
		if( strpos($url, 'vimeo') !== false )
		{
			$video_id = filter_var($url, FILTER_SANITIZE_NUMBER_INT);
			$video_tag = 'amp-vimeo';

		}
		elseif( strpos($url, 'youtube') !== false )
		{
			$video_id = substr($url, strrpos($url,'watch?v=')+strlen('watch?v='));
			$video_tag = 'amp-youtube';
		}
		return '<div class="'.$video_tag.'-container"><'.$video_tag.' data-videoid="'.$video_id.'" layout="responsive" width="480" height="270"></'.$video_tag.'></div>';
	}

	public static function showText($text)
	{
		// strip out style tags
		$text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
		return $text;
	}

	public static function showAd()
	{
		return '<div class="amp-ad-container"><amp-ad
			type="adsense"
			layout="responsive"
			width="320"
			height="50"
			data-ad-client="xxx"
			data-ad-slot="xxx"
		></amp-ad></div>';
	}

}