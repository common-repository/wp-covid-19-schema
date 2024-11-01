jQuery(document).ready(function($) {

	$('#swwpcs_testing_facility_date_posted, #swwpcs_testing_facility_date_expires, #swwpcs_school_closure_date_posted, #swwpcs_school_closure_expires').datepicker({
		dateFormat: "yy-mm-dd"
	});

	$("#swwpcs_testing_facility_schema_control").change(function(){

		if(escape($(this).val()) == "post") {

			$("#swwpcs_testing_facility_page_select").removeAttr("required");
			$("#swwpcs_testing_facility_post_select").attr("required", "required");
			$(".swwpcs-testing-facility-page-select").hide();	
			$(".swwpcs-testing-facility-post-select").show();	

		} else if(escape($(this).val()) == "page") {
			
			$("#swwpcs_testing_facility_post_select").removeAttr("required");
			$("#swwpcs_testing_facility_page_select").attr("required", "required");
			$(".swwpcs-testing-facility-post-select").hide();
			$(".swwpcs-testing-facility-page-select").show();

		} else {

			$(".swwpcs-testing-facility-post-select, .swwpcs-testing-facility-page-select").hide();

		}

	});


	$("#swwpcs_school_closure_schema_control").change(function(){

		if(escape($(this).val()) == "post") {

			$("#swwpcs_school_closure_page_select").removeAttr("required");
			$("#swwpcs_school_closure_post_select").attr("required", "required");
			$(".swwpcs-school-closure-page-select").hide();	
			$(".swwpcs-school-closure-post-select").show();	

		} else if(escape($(this).val()) == "page") {
			
			$("#swwpcs_school_closure_post_select").removeAttr("required");
			$("#swwpcs_school_closure_page_select").attr("required", "required");
			$(".swwpcs-school-closure-post-select").hide();
			$(".swwpcs-school-closure-page-select").show();

		} else {

			$(".swwpcs-school-closure-post-select, .swwpcs-school-closure-page-select").hide();

		}

	});

	$("ul.swwpcs-menu li").click(function() {

		if ($(this).hasClass("current")) return false;

		$(".swwpcs-menu li").removeClass("current");
		$(this).addClass("current");

		var target = $(this).data("target");
		$(".content-panel").hide();
		$("#panel").find(target).slideDown();

	});

	$(".wp-covid-schema-alert").delay(5000).slideUp();

	$("body").on('keyup', '#swwpcs_testing_facility_announcement_name', function(){ $(".swwpcs-announcement-name").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_desc_text', function(){ $(".swwpcs-announcement-text").html(escape($(this).val())) });
	$("body").on('keyup change', '#swwpcs_testing_facility_date_posted', function(){ $(".swwpcs-announcement-date").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_article_url', function(){ $(".swwpcs-article-url").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_name', function(){ $(".swwpcs-testing-facility-name").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_image', function(){ $(".swwpcs-testing-facility-image").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_date_expires', function(){ $(".swwpcs-announcement-date-expires").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_price_range', function(){ $(".swwpcs-price-range").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_address', function(){ $(".swwpcs-testing-facility-address").html(escape($(this).val())) });
	$("body").on('keyup', '#swwpcs_testing_facility_telephone', function(){ $(".swwpcs-testing-facility-telephone").html(escape($(this).val())) });
	
	$("body").on('change', '#swwpcs_testing_facility_enable', function(){

		if($(this).prop("checked") == true){
			
			$(".swwpcs-schema-preview .swwpcs-testing-facility-disabled").slideUp(200);
			$("#swwpcs-preview-outer, #swwpcs-testing-facility-schema-settings tbody").delay(200).slideDown(500);

		} else {

			$("#swwpcs-preview-outer, #swwpcs-testing-facility-schema-settings tbody").slideUp(500);
			$(".swwpcs-schema-preview .swwpcs-testing-facility-disabled").delay(600).slideDown(200);

		}
		
	});

	$("body").on('change', '#swwpcs_school_closure_enable', function(){

		if($(this).prop("checked") == true){
			
			$(".swwpcs-school-closure-disabled").slideUp(200);
			$("#swwpcs-school-closure-preview-outer, #swwpcs-school-closure-schema-settings tbody").delay(200).slideDown(500);

		} else {

			$("#swwpcs-school-closure-preview-outer, #swwpcs-school-closure-schema-settings tbody").slideUp(500);
			$(".swwpcs-school-closure-disabled").delay(600).slideDown(200);

		}
		
	});
	
	$("body").on('change', '#swwpcs_school_closure_web_feed_enable', function(){

		if($(this).prop("checked") == true){
			
			$(".web-feed-details, #swwpcs-school-closure-preview-outer li.webfeed").slideDown(200);

		} else {

			$(".web-feed-details, #swwpcs-school-closure-preview-outer li.webfeed").slideUp(200);

		}
		
	});

	$("#swwpcs-school-closure-schema-settings").on('keyup change', 'input, textarea', function(){ 
		
		$id = $(this).attr("id");
		$val = escape($(this).val());
		$("#swwpcs-school-closure-preview-outer").find("span." + $id).html($val);

	});

});
