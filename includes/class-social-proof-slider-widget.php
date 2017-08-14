<?php

/**
 * The widget functionality of the plugin.
 *
 * @link       https://thebrandiD.com
 * @since      2.0.0
 *
 * @package    Social_Proof_Slider
 * @subpackage Social_Proof_Slider/includes
 */

/**
 * The widget functionality of the plugin.
 *
 * @package    Social_Proof_Slider
 * @subpackage Social_Proof_Slider/includes
 */
class Social_Proof_Slider_Widget extends WP_Widget {

	/**
	 * The ID of this plugin.
	 *
	 * @since 		2.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		2.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		$this->plugin_name = 'social-proof-slider';
		$this->version = '2.0.5';

		$name = esc_html__( 'Social Proof Slider', 'social-proof-slider' );
		$opts['classname'] = '';
		$opts['description'] = esc_html__( 'Display a Social Proof Slider', 'social-proof-slider' );
		$control = array( 'width' => '', 'height' => '' );

		parent::__construct( false, $name, $opts, $control );

		add_action( 'admin_footer-widgets.php', array( $this, 'print_custom_admin_scripts' ), 9999 );

	} // __construct()

	public function print_custom_admin_scripts() {
	?>
		<script>
			( function( $ ){

				function showItem(item) {
					return $(item).show();
				}

				function hideItem(item) {
					return $(item).hide();
				}

				function showItemsWithIDs(ids) {
					$(ids).each(function(index, id) {
						showItem(id);
					});
				}

				function hideItemsWithIDs(ids) {
					$(ids).each(function(index, id) {
						hideItem(id);
					});
				}

				function hideUncheckedOptions(){

					/* ********** Auto-Play ********** */
					$( "input[id*='autoplay']" ).each(function(){
						// Assign elements
						var autoplayElems = $( this ).closest( ".widget-content" ).find( ".spslider_options_displaytime" );
						// Check first
						if( $(this).is( ':checked' ) ) {
							$( autoplayElems ).show();
						} else {
							$( autoplayElems ).hide();
						}
						// Click function
						$(this).click(function () {
							if( $( this ).is( ':checked' ) ) {
								$( autoplayElems ).show();
							} else {
								$( autoplayElems ).hide();
							}
						})
					})

					/* ********** Featured Image ********** */
					$( "input[id*='showfeaturedimg']" ).each(function(){
						// Assign elements
						var showfeaturedimgElems = $( this ).closest( ".widget-content" ).find( ".spslider_options_imgborderradius" );
						// Check first
						if( $(this).is( ':checked' ) ) {
							$( showfeaturedimgElems ).show();
						} else {
							$( showfeaturedimgElems ).hide();
						}
						// Click function
						$(this).click(function () {
							if( $( this ).is( ':checked' ) ) {
								$( showfeaturedimgElems ).show();
							} else {
								$( showfeaturedimgElems ).hide();
							}
						})
					})

					/* ********** Arrows ********** */
					$( "input[id*='showarrows']" ).each(function(){
						// Assign elements
						var showarrowsElems = [
							$( this ).closest( ".widget-content" ).find( ".spslider__options_arrowiconstyle" ),
							$( this ).closest( ".widget-content" ).find( ".spslider_options_arrowiconstyle" ),
							$( this ).closest( ".widget-content" ).find( ".radio-group.arrowiconstyle" ),
							$( this ).closest( ".widget-content" ).find( ".spslider_options_arrowcolor" ),
							$( this ).closest( ".widget-content" ).find( ".spslider_options_arrowhovercolor" )
						];
						// Check first
						if( $(this).is( ':checked' ) ) {
							showItemsWithIDs(showarrowsElems);
						} else {
							hideItemsWithIDs(showarrowsElems);
						}
						// Click function
						$(this).click(function () {
							if( $( this ).is( ':checked' ) ) {
								showItemsWithIDs(showarrowsElems);
							} else {
								hideItemsWithIDs(showarrowsElems);
							}
						})
					})

					/* ********** Dots ********** */
					$( "input[id*='showdots']" ).each(function(){
						// Assign elements
						var showdotsElems = $( this ).closest( ".widget-content" ).find( ".spslider_options_dotscolor" );
						// Check first
						if( $(this).is( ':checked' ) ) {
							$( showdotsElems ).show();
						} else {
							$( showdotsElems ).hide();
						}
						// Click function
						$(this).click(function () {
							if( $( this ).is( ':checked' ) ) {
								$( showdotsElems ).show();
							} else {
								$( showdotsElems ).hide();
							}
						})
					})

				}

				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						<?php if ( is_customize_preview() ) { ?>
							change: _.throttle( function () { $(this).trigger('change'); }, 1000, {leading: false} )
						<?php } ?>
					});
				}

				function updateCBoxes(){

					/* ********** Styling Radio Buttons Without Dots ********** */
					//$('input:radio[data-radio-id*="socialproofslider_arrow_icon_type"], input:radio[data-radio-id*="textalign"]').hide();
					$( 'input:radio[data-radio-id*="textalign"], input:radio[data-radio-id*="arrowiconstyle"]' ).hide();

					$('.radio-group a.icon').on('click', function(e) {
						// don't follow anchor link
						e.preventDefault();

						// the clicked item
						var unique = $(this).attr('data-radio-id');

						//console.log( 'clicked: ' + $(this).prev('input:radio').attr('value') );

						// change all span elements class to 'radio'
						$("a[data-radio-id='"+unique+"'] span").attr('class','radio');

						// change all radio buttons to unchecked
						$(":radio[data-radio-id='"+unique+"']").attr('checked',false);

						// find this span item and give it 'radio-checked' class
						$(this).find('span').attr('class','radio-checked');

						// find this radio button and make it 'checked'
						$(this).prev('input:radio').attr('checked',true);

						$(this).prev('input:radio').trigger('change');

					}).on('keydown', function(e) {
						// on keyboard entry, trigger click event
						if ((e.keyCode ? e.keyCode : e.which) == 32) {
							$(this).trigger('click');
						}
					});

				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
					updateCBoxes();
					hideUncheckedOptions();
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {

					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );

					updateCBoxes();
					hideUncheckedOptions();

				} );

			}( jQuery ) );

		</script>
	<?php
	}


	/**
	 * Back-end widget form.
	 *
	 * @see		WP_Widget::form()
	 *
	 * @uses	wp_parse_args
	 * @uses	esc_attr
	 * @uses	get_field_id
	 * @uses	get_field_name
	 * @uses	checked
	 *
	 * @param	array	$instance	Previously saved values from database.
	 */
	function form( $instance ) {

		// DEFAULTS
		$defaults['title'] = '';
		$defaults['sortby'] = 'rand';
		$defaults['autoplay'] = 1;
		$defaults['displaytime'] = 3000;
		$defaults['animationstyle'] = 'fade';
		$defaults['showfeaturedimg'] = 1;
		$defaults['imgborderradius'] = '0px';
		$defaults['bgcolor'] = '';
		$defaults['surroundquotes'] = '';
		$defaults['textalign'] = 'align_center';
		$defaults['textcolor'] = '#333333';
		$defaults['showarrows'] = 1;
		$defaults['arrowiconstyle'] = 'style_zero';
		$defaults['arrowcolor'] = '#000000';
		$defaults['arrowhovercolor'] = '#999999';
		$defaults['showdots'] = 1;
		$defaults['dotscolor'] = '#333333';
		$defaults['excinc'] = 'in';
		$defaults['excincIDs'] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		// WIDGET TITLE
		$field_widgetTitle = 'title'; // name of the field
		$field_widgetTitle_id = $this->get_field_id( $field_widgetTitle );
		$field_widgetTitle_name = $this->get_field_name( $field_widgetTitle );
		$field_widgetTitle_value = esc_attr( $instance[$field_widgetTitle] );
		echo '<div class="spslider_options_widgettitle"><label for="' . $field_widgetTitle_id . '">' . __('Widget Title: ') . '<input class="widefat" id="' . $field_widgetTitle_id . '" name="' . $field_widgetTitle_name . '" type="text" value="' . $field_widgetTitle_value . '" /></label></div>';


		// SORT BY
		$field_sortby = 'sortby'; // name of the field
		$field_sortby_id = $this->get_field_id( $field_sortby );
		$field_sortby_name = $this->get_field_name( $field_sortby );
		$field_sortby_value = esc_attr( $instance[$field_sortby] );

		echo '<div class="spslider_options_sortby"><label for="' . $field_sortby_id . '">' . __('Sort By: ') . '';
		?>
		<select name="<?php echo $field_sortby_name; ?>">
			<option value="rand" <?php echo $field_sortby_value == 'rand' ? 'selected="selected"' : ''; ?> >Random (default)</option>
			<option value="desc" <?php echo $field_sortby_value == 'desc' ? 'selected="selected"' : ''; ?> >Date - Descending</option>
			<option value="asc" <?php echo $field_sortby_value == 'asc' ? 'selected="selected"' : ''; ?> >Date - Ascending</option>
		</select>
		<?php
		echo '</label></div>';


		// AUTO PLAY
		$field_autoplay = 'autoplay'; // name of the field
		$field_autoplay_id = $this->get_field_id( $field_autoplay );
		$field_autoplay_name = $this->get_field_name( $field_autoplay );
		$field_autoplay_value = esc_attr( $instance[$field_autoplay] );

		$checked = ( (int)$field_autoplay_value == 1 ) ? 'checked' : '';

		echo '<div class="spslider_options_autoplay"><label for="' . $field_autoplay_id . '">' . __('Auto Play: ') . '';
		?>
		<input aria-role="checkbox"
				<?php echo $checked; ?>
				class=""
				id="<?php echo $field_autoplay_id; ?>"
				name="<?php echo $field_autoplay_name; ?>"
				type="checkbox"
				value="1" />
		<?php
		echo '</label></div>';


		// DISPLAY TIME
		$field_displaytime = 'displaytime'; // name of the field
		$field_displaytime_id = $this->get_field_id( $field_displaytime );
		$field_displaytime_name = $this->get_field_name( $field_displaytime );
		$field_displaytime_value = esc_attr( $instance[$field_displaytime] );

		echo '<div class="spslider_options_displaytime"><label for="' . $field_displaytime_id . '">' . __('Display Time: ') . '';
		?>
			<input
				class=""
				id="<?php echo $field_displaytime_id; ?>"
				name="<?php echo $field_displaytime_name; ?>"
				type="text"
				value="<?php echo $field_displaytime_value; ?>"
			/>
			<?php
		echo '</label></div>';


		// ANIMATION STYLE
		$field_animationstyle = 'animationstyle'; // name of the field
		$field_animationstyle_id = $this->get_field_id( $field_animationstyle );
		$field_animationstyle_name = $this->get_field_name( $field_animationstyle );
		$field_animationstyle_value = esc_attr( $instance[$field_animationstyle] );

		echo '<div class="spslider_options_animationstyle"><label for="' . $field_displaytime_id . '">' . __('Animation Style: ') . '';
		?>
		<select name="<?php echo $field_animationstyle_name; ?>" id="<?php echo $field_animationstyle_id; ?>">
			<option value="fade" <?php echo $field_animationstyle_value == 'fade' ? 'selected="selected"' : ''; ?> >Fade (default)</option>
			<option value="slide" <?php echo $field_animationstyle_value == 'slide' ? 'selected="selected"' : ''; ?> >Slide</option>
		</select>
		<?php
		echo '</label></div>';


		// SHOW FEATURED IMAGE
		$field_showfeaturedimg = 'showfeaturedimg'; // name of the field
		$field_showfeaturedimg_id = $this->get_field_id( $field_showfeaturedimg );
		$field_showfeaturedimg_name = $this->get_field_name( $field_showfeaturedimg );
		$field_showfeaturedimg_value = esc_attr( $instance[$field_showfeaturedimg] );

		$checked = ( (int)$field_showfeaturedimg_value == 1 ) ? 'checked' : '';

		echo '<div class="spslider_options_showfeaturedimg"><label for="' . $field_showfeaturedimg_id . '">' . __('Show Featured Images: ') . '';
		?>
		<input aria-role="checkbox"
				<?php echo $checked; ?>
				class=""
				id="<?php echo $field_showfeaturedimg_id; ?>"
				name="<?php echo $field_showfeaturedimg_name; ?>"
				type="checkbox"
				value="1" />
		<?php
		echo '</label></div>';


		// IMAGE BORDER RADIUS
		$field_imgborderradius = 'imgborderradius'; // name of the field
		$field_imgborderradius_id = $this->get_field_id( $field_imgborderradius );
		$field_imgborderradius_name = $this->get_field_name( $field_imgborderradius );
		$field_imgborderradius_value = esc_attr( $instance[$field_imgborderradius] );

		echo '<div class="spslider_options_imgborderradius"><label for="' . $field_imgborderradius_id . '">' . __('Image Border Radius: ') . '';
		?>
			<input
				class=""
				id="<?php echo $field_imgborderradius_id; ?>"
				name="<?php echo $field_imgborderradius_name; ?>"
				type="text"
				value="<?php echo $field_imgborderradius_value; ?>"
			/>
			<?php
		echo '</label></div>';


		// BG COLOR
		$field_bgcolor = 'bgcolor'; // name of the field
		$field_bgcolor_id = $this->get_field_id( $field_bgcolor );
		$field_bgcolor_name = $this->get_field_name( $field_bgcolor );
		$field_bgcolor_value = esc_attr( $instance[$field_bgcolor] );

		echo '<div class="spslider_options_bgcolor"><label for="' . $field_bgcolor_id . '">' . __('Background Color: ') . '';
		?>
			<input
			class="color-picker"
			id="<?php echo $field_bgcolor_id; ?>"
			name="<?php echo $field_bgcolor_name; ?>"
			type="text"
			value="<?php echo $field_bgcolor_value; ?>" />
		<?php
		echo '</label></div>';


		// SURROUND WITH SMART QUOTES
		$field_surroundquotes = 'surroundquotes'; // name of the field
		$field_surroundquotes_id = $this->get_field_id( $field_surroundquotes );
		$field_surroundquotes_name = $this->get_field_name( $field_surroundquotes );
		$field_surroundquotes_value = esc_attr( $instance[$field_surroundquotes] );

		$checked = ( (int)$field_surroundquotes_value == 1 ) ? 'checked' : '';

		echo '<div class="spslider_options_surroundquotes"><label for="' . $field_surroundquotes_id . '">' . __('Smart Quotes: ') . '';
		?>
		<input aria-role="checkbox"
				<?php echo $checked; ?>
				class=""
				id="<?php echo $field_surroundquotes_id; ?>"
				name="<?php echo $field_surroundquotes_name; ?>"
				type="checkbox"
				value="1" />
		<?php
		echo '</label></div>';


		// TEXT ALIGN
		$field_textalign = 'textalign'; // name of the field
		$field_textalign_id = $this->get_field_id( $field_textalign );
		$field_textalign_name = $this->get_field_name( $field_textalign );
		$field_textalign_value = esc_attr( $instance[$field_textalign] );

		echo '<div class="spslider_options_textalign"><label for="' . $field_textalign_id . '">' . __('Text Align: ') . '';
		?>
		<div class="radio-group textalign">
			<div class="item">
				<input type="radio" name="<?php echo $field_textalign_name; ?>" value="align_left" data-radio-id="<?php echo $field_textalign_id; ?>" <?php echo $field_textalign_value == 'align_left' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_textalign_id; ?>" class="icon" href="#"><span class="<?php echo $field_textalign_value == 'align_left' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-align-left"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_textalign_name; ?>" value="align_center" data-radio-id="<?php echo $field_textalign_id; ?>" <?php echo $field_textalign_value == 'align_center' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_textalign_id; ?>" class="icon" href="#"><span class="<?php echo $field_textalign_value == 'align_center' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-align-center"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_textalign_name; ?>" value="align_right" data-radio-id="<?php echo $field_textalign_id; ?>" <?php echo $field_textalign_value == 'align_right' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_textalign_id; ?>" class="icon" href="#"><span class="<?php echo $field_textalign_value == 'align_right' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-align-right"></i></span></a>
			</div>
		</div>
		<?php
		echo '</label></div>';


		// TEXT COLOR
		$field_textcolor = 'textcolor'; // name of the field
		$field_textcolor_id = $this->get_field_id( $field_textcolor );
		$field_textcolor_name = $this->get_field_name( $field_textcolor );
		$field_textcolor_value = esc_attr( $instance[$field_textcolor] );

		echo '<div class="spslider_options_textcolor"><label for="' . $field_textcolor_id . '">' . __('Text Color: ') . '';
		?>
			<input
			class="color-picker"
			id="<?php echo $field_textcolor_id; ?>"
			name="<?php echo $field_textcolor_name; ?>"
			type="text"
			value="<?php echo $field_textcolor_value; ?>" />
		<?php
		echo '</label></div>';


		// SHOW ARROWS
		$field_showarrows = 'showarrows'; // name of the field
		$field_showarrows_id = $this->get_field_id( $field_showarrows );
		$field_showarrows_name = $this->get_field_name( $field_showarrows );
		$field_showarrows_value = esc_attr( $instance[$field_showarrows] );

		$checked = ( (int)$field_showarrows_value == 1 ) ? 'checked' : '';

		echo '<div class="spslider_options_showarrows"><label for="' . $field_showarrows_id . '">' . __('Show Arrows: ') . '';
		?>
		<input aria-role="checkbox"
				<?php echo $checked; ?>
				class=""
				id="<?php echo $field_showarrows_id; ?>"
				name="<?php echo $field_showarrows_name; ?>"
				type="checkbox"
				value="1" />
		<?php
		echo '</label></div>';


		// ARROW ICON STYLE
		$field_arrowiconstyle = 'arrowiconstyle'; // name of the field
		$field_arrowiconstyle_id = $this->get_field_id( $field_arrowiconstyle );
		$field_arrowiconstyle_name = $this->get_field_name( $field_arrowiconstyle );
		$field_arrowiconstyle_value = esc_attr( $instance[$field_arrowiconstyle] );

		echo '<div class="spslider_options_arrowiconstyle"><label for="' . $field_arrowiconstyle_id . '">' . __('Arrow Icons: ') . '</label></div>';
		?>
		<div class="radio-group arrowiconstyle">
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_zero" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_zero' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_zero' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-angle-left"></i> <i class="fa fa-angle-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_one" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_one' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_one' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-angle-double-left"></i> <i class="fa fa-angle-double-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_two" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_two' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_two' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-arrow-circle-left"></i> <i class="fa fa-arrow-circle-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_three" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_three' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_three' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-arrow-circle-o-left"></i> <i class="fa fa-arrow-circle-o-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_four" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_four' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_four' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-arrow-left"></i> <i class="fa fa-arrow-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_five" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_five' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_five' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-caret-left"></i> <i class="fa fa-caret-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_six" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_six' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_six' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-caret-square-o-left"></i> <i class="fa fa-caret-square-o-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_seven" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_seven' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_seven' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-chevron-circle-left"></i> <i class="fa fa-chevron-circle-right"></i></span></a>
			</div>
			<div class="item">
				<input type="radio" name="<?php echo $field_arrowiconstyle_name; ?>" value="style_eight" data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" <?php echo $field_arrowiconstyle_value == 'style_eight' ? 'checked="checked"' : ''; ?> />
				<a data-radio-id="<?php echo $field_arrowiconstyle_id; ?>" class="icon" href="#"><span class="<?php echo $field_arrowiconstyle_value == 'style_eight' ? 'radio-checked' : 'radio'; ?>"><i class="fa fa-chevron-left"></i> <i class="fa fa-chevron-right"></i></span></a>
			</div>
		</div>
		<?php


		// ARROW COLOR
		$field_arrowcolor = 'arrowcolor'; // name of the field
		$field_arrowcolor_id = $this->get_field_id( $field_arrowcolor );
		$field_arrowcolor_name = $this->get_field_name( $field_arrowcolor );
		$field_arrowcolor_value = esc_attr( $instance[$field_arrowcolor] );

		echo '<div class="spslider_options_arrowcolor"><label for="' . $field_arrowcolor_id . '">' . __('Arrow Color: ') . '';
		?>
			<input
			class="color-picker"
			id="<?php echo $field_arrowcolor_id; ?>"
			name="<?php echo $field_arrowcolor_name; ?>"
			type="text"
			value="<?php echo $field_arrowcolor_value; ?>" />
		<?php
		echo '</label></div>';


		// ARROW HOVER COLOR
		$field_arrowhovercolor = 'arrowhovercolor'; // name of the field
		$field_arrowhovercolor_id = $this->get_field_id( $field_arrowhovercolor );
		$field_arrowhovercolor_name = $this->get_field_name( $field_arrowhovercolor );
		$field_arrowhovercolor_value = esc_attr( $instance[$field_arrowhovercolor] );

		echo '<div class="spslider_options_arrowhovercolor"><label for="' . $field_arrowhovercolor_id . '">' . __('Arrow Hover Color: ') . '';
		?>
			<input
			class="color-picker"
			id="<?php echo $field_arrowhovercolor_id; ?>"
			name="<?php echo $field_arrowhovercolor_name; ?>"
			type="text"
			value="<?php echo $field_arrowhovercolor_value; ?>" />
		<?php
		echo '</label></div>';


		// SHOW DOTS
		$field_showdots = 'showdots'; // name of the field
		$field_showdots_id = $this->get_field_id( $field_showdots );
		$field_showdots_name = $this->get_field_name( $field_showdots );
		$field_showdots_value = esc_attr( $instance[$field_showdots] );

		$checked = ( (int)$field_showdots_value == 1 ) ? 'checked' : '';

		echo '<div class="spslider_options_showdots"><label for="' . $field_showdots_id . '">' . __('Show Dots: ') . '';
		?>
		<input aria-role="checkbox"
				<?php echo $checked; ?>
				class=""
				id="<?php echo $field_showdots_id; ?>"
				name="<?php echo $field_showdots_name; ?>"
				type="checkbox"
				value="1" />
		<?php
		echo '</label></div>';


		// DOTS COLOR
		$field_dotscolor = 'dotscolor'; // name of the field
		$field_dotscolor_id = $this->get_field_id( $field_dotscolor );
		$field_dotscolor_name = $this->get_field_name( $field_dotscolor );
		$field_dotscolor_value = esc_attr( $instance[$field_dotscolor] );

		echo '<div class="spslider_options_dotscolor"><label for="' . $field_dotscolor_id . '">' . __('Dots Color: ') . '';
		?>
			<input
			class="color-picker"
			id="<?php echo $field_dotscolor_id; ?>"
			name="<?php echo $field_dotscolor_name; ?>"
			type="text"
			value="<?php echo $field_dotscolor_value; ?>" />
		<?php
		echo '</label></div>';


		// INCLUDE/EXCLUDE SELECT
		$field_excinc = 'excinc'; // name of the field
		$field_excinc_id = $this->get_field_id( $field_excinc );
		$field_excinc_name = $this->get_field_name( $field_excinc );
		$field_excinc_value = esc_attr( $instance[$field_excinc] );

		echo '<div class="spslider_options_excinc"><label for="' . $field_excinc_id . '">' . __('Include/Exclude: ') . '</label><br>';
		?>
		<select name="<?php echo $field_excinc_name; ?>">
			<option value="in" <?php echo $field_excinc_value == 'in' ? 'selected="selected"' : ''; ?> >Include</option>
			<option value="ex" <?php echo $field_excinc_value == 'ex' ? 'selected="selected"' : ''; ?> >Exclude</option>
		</select>
		<?php
		echo '</div>';


		// INCLUDE/EXCLUDE IDS TEXTBOX
		$field_excincIDs = 'excincIDs'; // name of the field
		$field_excincIDs_id = $this->get_field_id( $field_excincIDs );
		$field_excincIDs_name = $this->get_field_name( $field_excincIDs );
		$field_excincIDs_value = esc_attr( $instance[$field_excincIDs] );

		echo '<div class="spslider_options_excincIDs"><label for="' . $field_excincIDs_id . '">' . __('IDs: ') . '';
		?>
			<input
				class=""
				id="<?php echo $field_excincIDs_id; ?>"
				name="<?php echo $field_excincIDs_name; ?>"
				type="text"
				value="<?php echo $field_excincIDs_value; ?>"
			/>
			<?php
		echo '</label></div>';

	} // form()

	/**
	 * Front-end display of widget.
	 *
	 * @see		WP_Widget::widget()
	 *
	 * @uses	apply_filters
	 * @uses	get_widget_layout
	 *
	 * @param	array	$args		Widget arguments.
	 * @param 	array	$instance	Saved values from database.
	 */
	function widget( $args, $instance ) {

		$cache = wp_cache_get( $this->plugin_name, 'widget' );

		if ( ! is_array( $cache ) ) {

			$cache = array();

		}

		if ( ! isset ( $args['widget_id'] ) ) {

			$args['widget_id'] = $this->plugin_name;

		}

		if ( isset ( $cache[ $args['widget_id'] ] ) ) {

			return print $cache[ $args['widget_id'] ];

		}

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// Manipulate widget's values based on their input fields here

		$instance['thisWidgetID'] = $args['widget_id']."-wrap";

		ob_start();

		echo '<div class="'. $args["widget_id"] .'">';

		include( plugin_dir_path( __FILE__ ) . 'partials/social-proof-slider-display-widget.php' );

		echo '</div>';

		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->plugin_name, $cache, 'widget' );

		print $widget_string;

	} // widget()

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see		WP_Widget::update()
	 *
	 * @param	array	$new_instance	Values just sent to be saved.
	 * @param	array	$old_instance	Previously saved values from database.
	 *
	 * @return 	array	$instance		Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['sortby'] = $new_instance['sortby'];
		$instance['autoplay'] = $new_instance['autoplay'];
		$instance['displaytime'] = $new_instance['displaytime'];
		$instance['animationstyle'] = $new_instance['animationstyle'];
		$instance['showfeaturedimg'] = $new_instance['showfeaturedimg'];
		$instance['imgborderradius'] = $new_instance['imgborderradius'];
		$instance['bgcolor'] = $new_instance['bgcolor'];
		$instance['surroundquotes'] = $new_instance['surroundquotes'];
		$instance['textalign'] = $new_instance['textalign'];
		$instance['textcolor'] = $new_instance['textcolor'];
		$instance['showarrows'] = $new_instance['showarrows'];
		$instance['arrowiconstyle'] = $new_instance['arrowiconstyle'];
		$instance['arrowcolor'] = $new_instance['arrowcolor'];
		$instance['arrowhovercolor'] = $new_instance['arrowhovercolor'];
		$instance['showdots'] = $new_instance['showdots'];
		$instance['dotscolor'] = $new_instance['dotscolor'];
		$instance['excinc'] = $new_instance['excinc'];
		$instance['excincIDs'] = $new_instance['excincIDs'];

		return $instance;

	} // update()

} // class
