<?php

if ( ! empty( $instance['title'] ) ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
}

if ( ! empty( $title ) ) {
	echo $before_title . $title . $after_title;
}

$thisWidgetID = $instance['thisWidgetID'];

$sortby = '';
if ( ! empty( $instance['sortby'] ) ) {
	$sortby = $instance['sortby'];
}

$autoplay = '';
$autoplayStr = '';
if ( ! empty( $instance['autoplay'] ) ) {
	// $autoplay = $instance['autoplay'];
	$autoplay = "true";
	$autoplayStr = "YES";
} else{
	$autoplay = "false";
	$autoplayStr = "NO";
}

$displaytime = '';
if ( ! empty( $instance['displaytime'] ) ) {
	$displaytime = $instance['displaytime'];
}

$animationstyle = '';
if ( ! empty( $instance['animationstyle'] ) ) {
	$animationstyle = $instance['animationstyle'];
}

$showfeaturedimg = '';
$showfeaturedimgStr = '';
if ( ! empty( $instance['showfeaturedimg'] ) ) {
	$showfeaturedimg = $instance['showfeaturedimg'];
	$showfeaturedimgStr = "YES";
} else{
	$showfeaturedimgStr = "NO";
}

$imgborderradius = '';
if ( ! empty( $instance['imgborderradius'] ) ) {
	$imgborderradius = $instance['imgborderradius'];
}

$bgcolor = 'transparent';
if ( ! empty( $instance['bgcolor'] ) ) {
	$bgcolor = $instance['bgcolor'];
}

$surroundquotes = '';
$surroundquotesStr = '';
if ( ! empty( $instance['surroundquotes'] ) ) {
	$surroundquotes = $instance['surroundquotes'];
	$surroundquotesStr = "YES";
} else{
	$surroundquotesStr = "NO";
}

$textalign = '';
if ( ! empty( $instance['textalign'] ) ) {
	$textalign = $instance['textalign'];
}

$textcolor = '';
if ( ! empty( $instance['textcolor'] ) ) {
	$textcolor = $instance['textcolor'];
}

$showarrows = '';
$showarrowsStr = '';
if ( ! empty( $instance['showarrows'] ) ) {
	// $showarrows = $instance['showarrows'];
	$showarrows = "true";
	$showarrowsStr = "YES";
} else{
	$showarrows = "false";
	$showarrowsStr = "NO";
}

$arrowiconstyle = '';
if ( ! empty( $instance['arrowiconstyle'] ) ) {
	$arrowiconstyle = $instance['arrowiconstyle'];
}

$arrow_left = "";
$arrow_right = "";

if ( $showarrowsStr == 'YES' ){
		$arrow_left = "fa-angle-left";	// default
		$arrow_right = "fa-angle-right";		// default

		if ( $arrowiconstyle == "style_zero" ){
			$arrow_left = "fa-angle-left";
			$arrow_right = "fa-angle-right";
		} else if ( $arrowiconstyle == "style_one" ){
			$arrow_left = "fa-angle-double-left";
			$arrow_right = "fa-angle-double-right";
		} else if ( $arrowiconstyle == "style_two" ){
			$arrow_left = "fa-arrow-circle-left";
			$arrow_right = "fa-arrow-circle-right";
		} else if ( $arrowiconstyle == "style_three" ){
			$arrow_left = "fa-arrow-circle-o-left";
			$arrow_right = "fa-arrow-circle-o-right";
		} else if ( $arrowiconstyle == "style_four" ){
			$arrow_left = "fa-arrow-left";
			$arrow_right = "fa-arrow-right";
		} else if ( $arrowiconstyle == "style_five" ){
			$arrow_left = "fa-caret-left";
			$arrow_right = "fa-caret-right";
		} else if ( $arrowiconstyle == "style_six" ){
			$arrow_left = "fa-caret-square-o-left";
			$arrow_right = "fa-caret-square-o-right";
		} else if ( $arrowiconstyle == "style_seven" ){
			$arrow_left = "fa-chevron-circle-left";
			$arrow_right = "fa-chevron-circle-right";
		} else if ( $arrowiconstyle == "style_eight" ){
			$arrow_left = "fa-chevron-left";
			$arrow_right = "fa-chevron-right";
		}
	}

$arrowcolor = '';
if ( ! empty( $instance['arrowcolor'] ) ) {
	$arrowcolor = $instance['arrowcolor'];
}

$arrowhovercolor = '';
if ( ! empty( $instance['arrowhovercolor'] ) ) {
	$arrowhovercolor = $instance['arrowhovercolor'];
}

$showdots = '';
$showdotsStr = '';
if ( ! empty( $instance['showdots'] ) ) {
	// $showdots = $instance['showdots'];
	$showdots = "true";
	$showdotsStr = "YES";
} else{
	$showdots = "false";
	$showdotsStr = "NO";
}

$dotscolor = '';
if ( ! empty( $instance['dotscolor'] ) ) {
	$dotscolor = $instance['dotscolor'];
}

$excinc = '';
$excincStr = '';
if ( ! empty( $instance['excinc'] ) ) {
	$excinc = $instance['excinc'];
	if ( $instance['excinc'] == 'in' ) {
		$excincStr = 'INCLUDE';
	} else if ( $instance['excinc'] == 'ex' ) {
		$excincStr = 'EXCLUDE';
	}
}

$excincIDs = '';
if ( ! empty( $instance['excincIDs'] ) ) {
	$excincIDs = $instance['excincIDs'];
}

ob_start();

$shared = new Social_Proof_Slider_Shared( $this->plugin_name, $this->version );

// Determine ORDERBY and ORDER args
if ( $sortby == "RAND" || $sortby == "rand" ) {
	$queryargs = array(
		'orderby' => 'rand',
	);
} else {
	$queryargs = array(
		'order' => $sortby,
		'orderby' => 'ID',
	);
}

$postLimiter = "";
$limiterIDs = "";
// Use Exclude/Include and IDs attributes, if present
if ( !empty( $excincIDs ) ) {

	$limiterIDs = $excincIDs;

	if ( $instance['excinc'] == 'ex' ) {
		// EXCLUDING
		$postLimiter = $instance['excinc'];
	} else {
		// INCLUDING
		$postLimiter = "";
	}

}


$items = $shared->get_testimonials( $queryargs, 'widget', $postLimiter, $limiterIDs, $showfeaturedimg, $surroundquotes );	// get_testimonials( $params, $src, $featimgs )

echo '<!-- // ********** SOCIAL PROOF SLIDER ********** // -->'."\n";
echo '<section id="' . $thisWidgetID . '" class="widget _socialproofslider-widget widget__socialproofslider ' . $animationstyle . ' ">'."\n";
echo '<div class="widget-wrap">'."\n";
echo '<div class="social-proof-slider-wrap ' . $textalign . '">'."\n";

echo $items."\n";

echo '</div><!-- // .social-proof-slider-wrap // -->'."\n";
echo '</div><!-- // .widget-wrap // -->'."\n";
echo '</section>'."\n";

//* Output styles
echo '<style>'."\n";
echo '#' . $thisWidgetID . ' .social-proof-slider-wrap{ background-color:' . $bgcolor . '; }'."\n";
echo '#' . $thisWidgetID . ' .social-proof-slider-wrap .testimonial-item.featured-image .testimonial-author-img img{ border-radius:' . $imgborderradius . '; }'."\n";
echo '#' . $thisWidgetID . ' .testimonial-item .testimonial-text{ color:' . $textcolor . '; }'."\n";
echo '#' . $thisWidgetID . ' .slick-arrow span { color:' . $arrowcolor . '; }'."\n";
echo '#' . $thisWidgetID . ' .slick-arrow:hover span{ color:' . $arrowhovercolor . '; }'."\n";
echo '#' . $thisWidgetID . ' .slick-dots li button::before, #' . $thisWidgetID . ' .slick-dots li.slick-active button:before { color:' . $dotscolor . ' }'."\n";
echo '</style>'."\n";

//* CUSTOM JS
$prev_button = '';
$next_button = '';
$thisWidgetJS = '<script type="text/javascript">'."\n";
$thisWidgetJS .= 'jQuery(document).ready(function($) {'."\n";
$thisWidgetJS .= '	$("#' . $thisWidgetID . ' .social-proof-slider-wrap").slick({'."\n";
$thisWidgetJS .= '		autoplay: ' . $autoplay . ','."\n";
if ( $autoplay == 'true' ) {
	$thisWidgetJS .= '		autoplaySpeed: ' . $displaytime . ','."\n";
}
$doFade = 'false';
if ( $animationstyle == 'fade' ) {
	$doFade = 'true';
}
$thisWidgetJS .= '		fade: ' . $doFade . ','."\n";
$thisWidgetJS .= '		arrows: ' . $showarrows . ','."\n";
if ( $showarrows == 'true' ) {

	$prev_button = '<button type="button" class="slick-prev"><span class="fa ' . $arrow_left . '"></span></button>';
	$next_button = '<button type="button" class="slick-next"><span class="fa ' . $arrow_right . '"></span></button>';

	$thisWidgetJS .= '		prevArrow: \'' . $prev_button . '\','."\n";
	$thisWidgetJS .= '		nextArrow: \'' . $next_button . '\','."\n";
}
$thisWidgetJS .= '		dots: ' . $showdots . ','."\n";
$thisWidgetJS .= '		infinite: true,'."\n";
$thisWidgetJS .= '		adaptiveHeight: true'."\n";
$thisWidgetJS .= '	});'."\n";
$thisWidgetJS .= '});'."\n";
$thisWidgetJS .= '</script>'."\n";
echo  $thisWidgetJS;
echo '<!-- // ********** // END SOCIAL PROOF SLIDER // ********** // -->'."\n";

$output = ob_get_contents();

ob_end_clean();

echo $output;
