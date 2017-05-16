$(document).ready(function(){
	$(document).on('click', '.pasteImages span.fa-remove', function(){
		$(this).parent().children('input').val('');
		$(this).parent().children('.minyatura').html($('.pasteImages .minyatura').attr('title'));
		$(this).remove();
		return false;
	});
	$(document).on('click', '.pasteImages', function(){
		$.ajax({
	    url: "/idev/media/load-media-image-content",
	    method: "POST",
	    data:{'input':'#'+$(this).attr('id'),'type':'minyatura'},
	    dataType: "json",
	    beforeSend: function(){
				$('#mediaModalContent .preloader').removeClass('d-none');
	    },
	    success: function(data){
	    	$('#imageContent').html(data.content);
	    	$('#imageContent').append('<div class="preloader-imagelist d-none"><img src="'+$('.preloader img').attr("src")+'"></div>');
	    	$('.imagesContent').css({'height':$('#imageContent').height()+'px'});
				$('#mediaModalContent .preloader').addClass('d-none');
				$('#'+data.pagination.id).dsPagination();
	    },
	    error: function(){
	      alert('error');
	    }
	  });
	  return false;
	});

	$(document).on('click','[data-action="image-add"]', function(){
		$('.closeModal').click();
		if ($(this).data('type') == 'editor') {
			$($(this).data('label')).val($(this).data('content'));
		}
		if ($(this).data('type') == 'minyatura') {
			$($(this).data('label')+' span.fa-remove').remove();
	    $($(this).data('label')).append('<span class="fa fa-remove"></span>');
			$($(this).data('label')+' input').val($(this).data('content'));
			$($(this).data('label')+' div.minyatura').html('<img class="img-fluid" src="'+$(this).data('content')+'">');
		}
		return false;
	});
});