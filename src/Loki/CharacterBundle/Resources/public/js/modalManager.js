$(function(){
	$('.edit, .editSetting').click(function(){
		loader = $("#floatingCirclesG").show();
        var myUrl = $(this).attr("data-route");
		$('.modal-body').load($(this).attr("data-route"), function(){
			$(".modal-title").html("Memory App Manager");
			$('form').attr('role','form');
			$("#elbformat_memorybundle_picture div").addClass("form-group");

			bindSubmit($("form"),myUrl);
			
		});
	});
	$('.delete').click(function(){
		$('.modal-body').load($(this).attr("data-route"), function(){
			$(".modal-title").html("Memory App Manager");
			$('form').attr('role','form');
			$("#elbformat_memorybundle_picture div").addClass("form-group");
		});
	});
	$('.logout').click(function(){
		window.location.href = $(this).attr("data-route")
	});
	
	
	$(".entry").hide();
	$(".showLess").hide();
	$(".entry").each(function( index ) {
		/*if(index <= 2){
			$(this).show();
		}*/
		cnt = index;
	
	});
	$(".entry").each(function( index ) {
		if(index >= cnt-2){
			$(this).show();
		}
	
	});
	$('.showMore, .showLess').click(function(){
		 if ( $( ".entry" ).is( ":hidden" ) ) {
			 $( ".entry" ).slideDown( "slow" );
			 $(".showLess").show();
			 $(".showMore").hide();
			 } else {
			 $( ".entry" ).hide();
			 $(".showLess").hide();
			 $(".showMore").show();
			 $(".entry").each(function( index ) {
					if(index >= cnt-2){
						$(this).show();
					}
				
				});
			 }
		});
	/*function bindSubmit(form, url){
		form.submit(function(e){
			form.hide();
			$(".modal-body").html(loader);
			e.preventDefault();
            //CHANGE Hier stand als erster Param URL //$(this).attr("data-route")
			$.post(url,$(this).serialize(),function(data){
				html = $.parseHTML( data ),

				nodeNames = [];
				abbruch = "0";
				$.each( html, function( i, el ) {
					if((el.nodeName == "TITLE") && (abbruch !="1")){
							abbruch = "1";
							location.reload();
					 }
				});
				if(abbruch == "0"){
					$(".modal-body").html( data );
					$("#elbformat_memorybundle_picture div").addClass("form-group");
					bindSubmit($("form"),$("form").attr("action"));
				}
	        });
		})
	}*/

    function bindSubmit(form, url) {
        form.submit(function(e) {
            form.hide();
            $(".modal-body").html(loader);
            e.preventDefault();
            var formData = new FormData(form[0]);
            $.ajax({
                url : url,
                data : formData,
                type : 'POST',
                processData : false,
                contentType : false,
                success : function(data) {
                    html = $.parseHTML(data), nodeNames = [];
                    abbruch = "0";
                    $.each(html, function(i, el) {
                        if ((el.nodeName == "TITLE") && (abbruch != "1")) {
                            abbruch = "1";
                            location.reload();
                        }
                    });
                    if (abbruch == "0") {
                        $(".modal-body").html(data);
                        $("#elbformat_memorybundle_picture div").addClass(
                            "form-group");
                        bindSubmit($("form"), $("form").attr("action"));
                    }
                },
                error : function(xhr, rrr, error) {
                    alert(error);
                }
            });
        })
    }
});


	
