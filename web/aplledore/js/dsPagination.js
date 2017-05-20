/****
* Plagin: dsPagination
* Version: v 1.0
* Author: #dishastalker
****/
(function($) {
	var defaults = { 
		pLimit:10,
		pCount:100,
		pContent:'#paginationContent',
		pUrl:'/pagination/content',
		pId:null,
	};

	var options;

	var dsPaginationFunctions = {
    clickA: function(){
      var parentId = '#'+$(this).parent().parent().parent().attr('id'), pageOffset = 0, pageLastOffset = 0;
      var activeA = $(this).parent().parent().find('a.active').data('label');
      if (activeA != 'undefined'){
        var selectPage = activeA;
        $(this).parent().parent().find('a').removeClass('active');
        // $(parentId+' ul').find('a').removeClass('active');
        switch ($(this).data('label')) {
          case 'pFirst': $(parentId+' span li:first-of-type a').click(); break;
          case 'pLast': $(parentId+' span li:last-of-type a').click(); break;
          case 'pPrev':
            activeA--;
            if($(parentId).find('a[data-label="'+activeA+'"]').length != 0){
              $(parentId).find('a[data-label="'+activeA+'"]').click();
            }else{
              $(parentId+' span li:first-of-type a').click();
            }
          break;
          case 'pNext':
            activeA++;
            if($(parentId).find('a[data-label="'+activeA+'"]').length != 0){
              $(parentId).find('a[data-label="'+activeA+'"]').click();
            }else{
              $(parentId+' span li:last-of-type a').click();
            }
          break;
          default:
            $(this).addClass('active');
            nav = $(this).parents('[data-action="pagination"]');
            pageOffset = $(this).data('page');
            pageLastOffset = $(this).parent().parent().find('li:last-of-type a').data('page');
            lastChild = $(this).parent().parent().find('li:last-of-type a').data('label');
            selectPage = $(this).data('label');
            selectPage -= 3;
            lastChild -= 5;
            if (selectPage != 0 && selectPage > 0){
              if(lastChild == selectPage || lastChild < selectPage){
                $(this).parent().parent().animate({left:'-'+(lastChild*36)+'px'},200);
              }else{
                $(this).parent().parent().animate({left:'-'+(selectPage*36)+'px'},200);
              }
            }else{
              $(this).parent().parent().animate({left:'0'},200);
            }
            dsPaginationFunctions.getContent(pageOffset, pageLastOffset, nav);
            return false;
        }
      }
      return false;
    },
    getContent: function(num, pageLastOffset, nav){
      if (num >= 0 && num <= pageLastOffset) {
        // alert(nav.attr('data-left-content'));
        if (!$(nav.data('content')).hasClass('loading')) {
          var leftcontent = '';
          if (nav.data('left-content') != 'empty') {
            leftcontent = nav.data('left-content');
          }
          $.ajax({
            url: nav.data('url'),
            method: "POST",
            data:{offset:num, leftcontent:leftcontent},
            dataType: "json",
            beforeSend: function(){
              $(nav.data('content')).addClass('loading');
              $(nav.data('preloader')).removeClass('d-none');
            },
            success: function(data){
              if (data.res == 'success') {
                $(nav.data('content')).html(data.content);
              }else{
                alert('ERROR!');
              }
              $(nav.data('content')).removeClass('loading');
              $(nav.data('preloader')).addClass('d-none');
            },
            error: function(){
              alert('error');
              $(nav.data('content')).removeClass('loading');
            }
          });
        }
      }else{
        alert('Error!');
      }
      return false;
    },
	};

  $.fn.dsPagination = function(params){
  	options = $.extend({}, defaults, options, params);

  	return this.each(function() {
  		options.pLimit = $(this).data('limit');
  		options.pCount = $(this).data('count');
  		options.pContent = $(this).data('content');
  		options.pUrl = $(this).data('url');
  		P = $(this);
  		var content = '', offset = 0, pageCount = 1;
  		if (options.pLimit < options.pCount){
  			content += '<ul class="dsPagination"><li><a href="#" data-label="pFirst"><i class="icon-arrow-left15"></i></a></li><li><a href="#" data-label="pPrev"><i class="icon-arrow-left12"></i></a></li><div><span>';
  			while(0 < options.pCount){
          if (pageCount == 1){
  				  content += '<li><a href="#" data-page="'+offset+'" data-label="'+pageCount+'" class="active">'+pageCount+'</a></li>';
          }else{
            content += '<li><a href="#" data-page="'+offset+'" data-label="'+pageCount+'">'+pageCount+'</a></li>';
          }
  				options.pCount = options.pCount - options.pLimit;
  				offset += options.pLimit;
  				pageCount++;
  			}
  			content += '</span></div><li><a href="#" data-label="pNext"><i class="icon-arrow-right13"></i></a></li><li><a href="#" data-label="pLast"><i class="icon-arrow-right15"></i></a></li></ul>';
  		}

  		P.html(content);
			if (pageCount <= 5 && pageCount > 1){
				pageCount--;
				P.find('div').css({'width':(pageCount*36)+'px'})
			}
      // alert(P.attr('id'));

      $(document).on('click', '#'+P.attr('id')+' a', dsPaginationFunctions.clickA);
    });

    return this;
  };
})(jQuery);