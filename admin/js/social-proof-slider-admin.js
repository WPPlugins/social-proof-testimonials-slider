jQuery(document).ready(function($) {

	// SHORTCODE SETTINGS PAGE - Add Color Picker to all inputs that have 'color-picker' class
	$( '.form-table .color-picker' ).wpColorPicker();


	/* ********** Add CSS Classes to <tr> ********** */
	$("div.displaytime").closest("tr").addClass("display_time");
	$("div.imgborderradius").closest("tr").addClass("img_border_radius");
	$("div.imgborderradius").closest("tr").addClass("img_border_radius");
	$("div.textalign").closest( "tr" ).addClass("text_align");
	$("div.arrowiconstyle").closest( "tr" ).addClass("arrow_icon_type");
	$("div.arrowcolor").closest( "tr" ).addClass("arrow_color");
	$("div.arrowhovercolor").closest( "tr" ).addClass("arrow_hover_color");
	$("div.dotscolor").closest( "tr" ).addClass("dots_color");

	/* ********** Show Auto-Play Options on checkbox check ********** */
	/* Check and see if field should be hidden by default */
	if($('input#social_proof_slider_autoplay').is(':checked')) {
		$(".form-table tr.display_time").show();
	} else {
		$(".form-table tr.display_time").hide();
	}

	$('input#social_proof_slider_autoplay').click(function () {
		if($(this).is(':checked')) {
			$(".form-table tr.display_time").show("slow");
		} else {
			$(".form-table tr.display_time").hide();
		}
	});

	/* ********** Show Featured Image Options on checkbox check ********** */
	/* Check and see if field should be hidden by default */
	if($('input#social_proof_slider_showfeaturedimg').is(':checked')) {
		$(".form-table tr.img_border_radius").show();
	} else {
		$(".form-table tr.img_border_radius").hide();
	}

	$('input#social_proof_slider_showfeaturedimg').click(function () {
		if($(this).is(':checked')) {
			$(".form-table tr.img_border_radius").show("slow");
		} else {
			$(".form-table tr.img_border_radius").hide();
		}
	});

	/* ********** Show Arrow Options on checkbox check ********** */
	/* Check and see if field should be hidden by default */
	if($('input#social_proof_slider_showarrows').is(':checked')) {
		//$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').show();
		$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').show();
	} else {
		//$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').hide();
		$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').hide();
	}

	$('input#social_proof_slider_showarrows').click(function () {
		if($(this).is(':checked')) {
			//$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').show("slow");
			$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').show();
		} else {
			//$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').hide();
			$('.form-table tr.arrow_icon_type, .form-table tr.arrow_color, .form-table tr.arrow_hover_color').hide();
		}
	});

	/* ********** Show Dots Options on checkbox check ********** */
	/* Check and see if field should be hidden by default */
	if($('input#social_proof_slider_showdots').is(':checked')) {
		$('.form-table tr.dots_color').show();
	} else {
		$('.form-table tr.dots_color').hide();
	}

	$('input#social_proof_slider_showdots').click(function () {
		if($(this).is(':checked')) {
			$('.form-table tr.dots_color').show("slow");
		} else {
			$('.form-table tr.dots_color').hide();
		}
	});

	/* ********** Styling Radio Buttons Without Dots ********** */
	$('input:radio[data-radio-id="social_proof_slider_arrowiconstyle"], input:radio[data-radio-id="social_proof_slider_textalign"]').hide();

	$('a.icon').on('click', function(e) {
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

	}).on('keydown', function(e) {
		// on keyboard entry, trigger click event
		if ((e.keyCode ? e.keyCode : e.which) == 32) {
			$(this).trigger('click');
		}
	});

});
