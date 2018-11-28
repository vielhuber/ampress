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

	public static function showImage($url, $class = null, $width = null, $height = null, $layout = 'responsive')
	{
		if( strpos($url, 'http') !== 0 )
		{
			$url = get_bloginfo('template_directory').'/images/'.$url;
		}
        if( $width === null || $height === null )
        {
            // replace url with docroot
            $docroot = str_replace(site_url(),$_SERVER['DOCUMENT_ROOT'],$url);
            $size = getimagesize($docroot);
			if( $width === null )
			{
				$width = $size[0];
			}
			if( $height === null ) 
			{
				$height = $size[1];
			}
		}
		if( $width === null || $width == '' || $height === null || $height == '' ) { return; }
		return '<div class="amp-img-container"><amp-img'.(($class !== null)?(' class="'.$class.'"'):('')).' src="'.$url.'" width="'.$width.'" height="'.$height.'" layout="'.$layout.'"></amp-img></div>';
	}

	public static function showCarouselBegin($image)
	{
		// currently amp-carousel has not the ability to automatically preserve the aspect ratio
		// we therefore get the ratio of the image via php
		$carousel_ratio = 100;
		if( $image !== null )
		{
            // replace url with docroot
            $docroot = str_replace(site_url(),$_SERVER['DOCUMENT_ROOT'],$image);
            list($carousel_width, $carousel_height) = getimagesize($docroot);
			$carousel_ratio = (($carousel_height/$carousel_width)*100);
			// add some extra margin (for subtitles etc.)
			$carousel_ratio += 10;
		}
		return '<amp-carousel width="100" height="'.$carousel_ratio.'" layout="responsive" type="slides">';
	}

	public static function showCarouselEnd()
	{
		return '</amp-carousel>';
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
        // strip out empty paragraphs
        $text = str_replace('<p ><strong>'.html_entity_decode('&nbsp;').'</strong></p>','',$text);
        $text = str_replace('<p ><strong>&nbsp;</strong></p>','',$text);
        $text = str_replace('<p ><strong> </strong></p>','',$text);
        $text = str_replace('<p><strong>&nbsp;</strong></p>','',$text);
        $text = str_replace('<p><strong> </strong></p>','',$text);
        $text = str_replace('<p><strong>'.html_entity_decode('&nbsp;').'</strong></p>','',$text);
        $text = str_replace('<h2><strong>'.html_entity_decode('&nbsp;').'</strong></h2>','',$text);
        $text = str_replace('<h3>'.html_entity_decode('&nbsp;').'</h3>','',$text);
        $text = str_replace('<h3>&nbsp;</h3>','',$text);
        $text = str_replace('<h2>'.html_entity_decode('&nbsp;').'</h2>','',$text);
        $text = str_replace('<h2>&nbsp;</h2>','',$text);
        $text = str_replace('<pre>'.html_entity_decode('&nbsp;').'</pre>','',$text);
        $text = str_replace('<pre>&nbsp;</pre>','',$text);
        $text = str_replace('<pre> </pre>','',$text);
        $text = str_replace('<p>&nbsp;</p>','',$text);
        $text = str_replace('<p>'.html_entity_decode('&nbsp;').'</p>','',$text);
        $text = str_replace('<p></p>','',$text);
        // replace img with amp-img
        $text = str_replace('<img ','<amp-img ',$text);
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

	public static function trackAnalytics()
	{
		return '
			<amp-analytics type="googleanalytics">
				<script type="application/json">
					{
						"vars": {
							"account": "UA-XXXXX-Y"
						},
						"triggers": {
							"trackPageview": {
								"on": "visible",
								"request": "pageview"
							}
						}
					}
				</script>
			</amp-analytics>
		';
	}

}