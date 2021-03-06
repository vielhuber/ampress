<!doctype html>
<html amp lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    <script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>
    <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <meta name="description" content="<?php echo get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true); ?>">
    <title><?php echo wp_title('|', false); ?></title>
    <link rel="canonical" href="<?php echo get_permalink(); ?>">
    <?php
    echo '<style amp-custom>';
      foreach(['style.css'] as $css_files__value)
      {
        echo file_get_contents(dirname(__FILE__).'/'.$css_files__value);
      }
    echo '</style>';
    ?>

  </head>
  <body>

    <?php
    echo ampress::trackAnalytics();
    echo get_the_title();
    echo ampress::showImage('logo.svg','logo__image',300,40);
    echo ampress::showVideo('https://www.youtube.com/watch?v=wmsfvkmq09s');
    echo ampress::showVideo('https://vimeo.com/228075517');
    echo ampress::showAd();

    echo ampress::showCarouselBegin('image-1.jpg');
      echo ampress::showImage('image-1.jpg');
      echo ampress::showImage('image-2.jpg');
    echo ampress::showCarouselEnd();
    ?>

  </body>
</html>