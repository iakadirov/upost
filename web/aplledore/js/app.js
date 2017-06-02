$(window).on('load', function() {
  $('body').removeClass('no-transitions');
  $('.mce-panel iframe').css({'height':$('div.mce-edit-area').height()+'px'});
  addCloseButtonInModal();
});

function addCloseButtonInModal(){
  $('.closeModal').html('<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 224.512 224.512" xml:space="preserve"><g><polygon points="224.507,6.997 217.521,0 112.256,105.258 6.998,0 0.005,6.997 105.263,112.254 0.005,217.512 6.998,224.512 112.256,119.24 217.521,224.512 224.507,217.512 119.249,112.254 "></polygon></g></svg>');
}

$(function() {

  var url = location.href.split('/'), mcUrl = '/'+url[3]+'/'+url[4];

  $(document).on('click','[data-action="checkbox"] input',function(){
    var action = 'deactive';
    if ($(this).prop('checked')) {
      action = 'active';
    }
    $.post(mcUrl+'/check-status',{action:action,id:$(this).parent().data('id')},function(res){
      if (res.res == 'success') {
        return true;
      }else{
        location.reload();
      }
    },'json');
  });

  $(document).on('click','#createRightUser',function(e){
    // alert($(this).data('id'));
    $('#mediumModal').modal('show');
    $.post(mcUrl+'/get-author-right',{id:$(this).data('id')},function(res){
      $('#mediumModal .modal-content').html(res.content);
      addCloseButtonInModal();
    },'json');
  });

  $(document).on('click','.postPriority span.label',function(){
    var action = 'plain', thisis = $(this);
    if ($(this).hasClass('label-default')) {
      action = 'important';
    }
    $.post(mcUrl+'/check-priority',{action:action,id:$(this).data('id')},function(res){
      if(res.res == 'success'){
        if(action == 'plain'){
          thisis.removeClass('label-danger').addClass('label-default');
          thisis.text(res.text);
        }else{
          thisis.removeClass('label-default').addClass('label-danger');
          thisis.text(res.text);
        }
      }else{
        location.reload();
      }
    },'json');
  });

  $(document).on('click', '#tagCreateNew #createNewTag', function(){
    if ($('#tagCreateNew input').val() != ' ' && $('#tagCreateNew input').val().length != 0) {
      $('.tagList').append('<span class="badge badge-default" data-id="0" data-text="'+$('#tagCreateNew input').val()+'" data-lang="'+$('#tagCreateNew select').val()+'">'+$('#tagCreateNew input').val()+" ("+$('#tagCreateNew select option:selected').text()+")"+'<i class="close">&times</i></span>');
      eachTagList();
      $('#tagCreateNew input').val('');
      $('#tagCreateNew input').focus();
    }
    return false;
  });
  $(document).on('click','.tagList .close',function(){
    $(this).parent().remove();
    eachTagList();
  });
  $('.tagOldListInput').typeahead({
    onSelect: function(item) {
      $('.tagList').append('<span class="badge badge-success" data-id="'+item.value+'" data-text="'+item.text+'">'+item.text+'<i class="close">&times</i></span>');
      eachTagList();
      setTimeout(function(){
        $('.tagOldListInput').val("");
      }, 100);
    },
    ajax: {
      url:mcUrl+'/get-tag-list',
      method: "post",
      triggerLength: 1,
      preDispatch: function(query){
        var str = '',num = 0;
        $('.tagList span').each(function(i){
          if ($(this).data("id") != 0) {
            str = str+'"'+(num++)+'":"'+$(this).data("id")+'",';
          }
        });
        str = "{"+str.slice(0,-1)+"}";
        return {name:query,ids:str};
      },
    }
  });

  $('#searchThema').typeahead({
    onSelect: function(item) {
      $('[name="Post[thema_id]"]').val(item.value);
    },
    ajax: {
      url:mcUrl+'/get-thema-list',
      method: "post",
      triggerLength: 1,
      preDispatch: function(query){
        return {name:query};
      },
    }
  });
  $('#searchThema').change(function(){
    if($(this).val() == '' || $(this).val() == ' '){
      $('[name="Post[thema_id]"]').val(0);
    };
  });

  function eachTagList(){
    var oldTags = '', newTags = '';
    $('.tagList span').each(function(i){
      if ($(this).data("id") == 0) {
        newTags = newTags+'{"name":"'+$(this).data('text')+'","lang":"'+$(this).data('lang')+'"},';
      }
      if($(this).data("id") > 0){
        oldTags = oldTags+'"'+parseInt($(this).data("id"))+'":"'+$(this).data('text')+'",';
      }
    });
    $('#oldTags').val("{"+oldTags.slice(0,-1)+"}");
    $('#newTags').val("["+newTags.slice(0,-1)+"]");
    console.log(oldTags);
  }

  $(".switch").bootstrapSwitch();

  $(document).on('click','[data-action="delete"]',function(){
    return confirm($(this).data('text'));
  });

  var dropzoneMaxSizeFile = $("#myAwesomeDropzone").data('max-size');
  $("#myAwesomeDropzone").dropzone({
    url: "/"+url[3]+"/media/upload",
    maxFilesize: dropzoneMaxSizeFile,
    maxFiles: 50
  });

  tinymce.init({
    selector: '.content_edit',
    language: 'ru',
    forced_root_block : false,
    // forced_root_block_attrs: {
    //   'class': 'myclass',
    //   'data-something': 'my data'
    // },
    // invalid_styles: 'color font-size',
    /*valid_classes: {
      'img': 'image_class', // Global classes
    },*/
    browser_spellcheck: true,
    theme : "modern",
    menubar: false,
    plugins: "searchreplace lists link image media codesample code imagetools insertdatetime textcolor colorpicker table charmap emoticons template",
    toolbar1: "bold italic underline strikethrough subscript superscript removeformat | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
    toolbar2: "searchreplace | bullist numlist | outdent indent blockquote | link unlink image media codesample code | insertdatetime forecolor backcolor | table charmap emoticons | template",
    file_browser_callback: function(field_name, url, type, win){
      if (type == 'image'){
        $('#mediaModalContent').modal('show');
        // $('#mediaModalContent .preloader').removeClass('d-none');
        $.ajax({
          url: "/aplledore/media/load-media-image-content",
          data: {'input':'#'+field_name, 'type':'editor'},
          method: "POST",
          dataType: "json",
          success: function(data){
            $('#imageContent').html(data.content);
            $('.imagesContent').css({'height':$('#imageContent').height()+'px'});
            $('#mediaModalContent .preloader').addClass('d-none');
            $('#'+data.pagination.id).dsPagination();
            $('#'+data.pagination.id).attr("data-left-content",data.pagination.leftcontent);
          },
          error: function(){
            alert('error');
          }
        });
      }
      return false;
    },
    skin : "dishastalker",
    templates: [
      {
        title: 'Button Primary',
        content: '<button type="button" class="btn btn-primary"> Primary</button>'
      },
      {
        title: 'Button Success',
        content: '<button type="button" class="btn btn-success"> Success</button>'
      },
      {
        title: 'Button Danger',
        content: '<button type="button" class="btn btn-danger"> Danger</button>'
      },
    ],
    style_formats: [
      {
        title: 'Bold text',
        inline: 'b'
      }, {
        title: 'Red text',
        inline: 'span',
        styles: {
          color: '#ff0000'
        }
      }, {
        title: 'Red header',
        block: 'h1',
        styles: {
          color: '#ff0000'
        }
      }, {
        title: 'Example 1',
        inline: 'span',
        classes: 'example1'
      }, {
        title: 'Example 2',
        inline: 'span',
        classes: 'example2'
      }, {
        title: 'Table styles'
      }, {
        title: 'Table row 1',
        selector: 'tr',
        classes: 'tablerow1'
      }
    ],
  });

  $(document).on('click', '.pasteImages span.icon-cross', function(){
    $(this).parent().children('input').val('');
    $(this).parent().children('.minyatura').html($('.pasteImages .minyatura').attr('title'));
    $(this).remove();
    return false;
  });
  $(document).on('click', '.pasteImages', function(){
    $('#mediaModalContent').modal('show');
    $.ajax({
      url: "/"+url[3]+"/media/load-media-image-content",
      method: "POST",
      data:{'input':'#'+$(this).attr('id'),'type':'minyatura'},
      dataType: "json",
      beforeSend: function(){
        // $('#mediaModalContent .preloader').removeClass('d-none');
      },
      success: function(data){
        $('#imageContent').html(data.content);
        // $('#imageContent').append('<div class="preloader-imagelist d-none"><img src="'+$('.preloader img').attr("src")+'"></div>');
        $('.imagesContent').css({'height':$('#imageContent').height()+'px'});
        // $('#mediaModalContent .preloader').addClass('d-none');
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
      $($(this).data('label')+' span.icon-cross').remove();
      $($(this).data('label')).append('<span class="icon-cross"></span>');
      $($(this).data('label')+' input').val($(this).data('image-id'));
      $($(this).data('label')+' div.minyatura').html('<img class="img-responsive" src="'+$(this).data('content')+'">');
    }
    return false;
  });

  $(document).on('click','#removeSort',function(){
    $('#contentSort').append('<input type="hidden" name="Sort[remove_sort]" value="1">');
    $(this).prev().click();
  })

  $('body').addClass('no-transitions');
  $(document).on('click', '.dropdown-content', function (e) {
    e.stopPropagation();
  });
  $('.navbar-nav .disabled a').on('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
  });
  $('.dropdown-content a[data-toggle="tab"]').on('click', function (e) {
      $(this).tab('show');
  });
  function containerHeight() {
      var availableHeight = $(window).height() - $('.page-container').offset().top - $('.navbar-fixed-bottom').outerHeight();
      $('.page-container').attr('style', 'min-height:' + availableHeight + 'px');
  }
  containerHeight();
  $('.panel [data-action=reload]').click(function (e) {
      e.preventDefault();
      var block = $(this).parent().parent().parent().parent().parent();
      $(block).block({ 
          message: '<i class="icon-spinner2 spinner"></i>',
          overlayCSS: {
              backgroundColor: '#fff',
              opacity: 0.8,
              cursor: 'wait',
              'box-shadow': '0 0 0 1px #ddd'
          },
          css: {
              border: 0,
              padding: 0,
              backgroundColor: 'none'
          }
      });

      // For demo purposes
      window.setTimeout(function () {
         $(block).unblock();
      }, 2000); 
  });
  $('.category-title [data-action=reload]').click(function (e) {
      e.preventDefault();
      var block = $(this).parent().parent().parent().parent();
      $(block).block({ 
          message: '<i class="icon-spinner2 spinner"></i>',
          overlayCSS: {
              backgroundColor: '#000',
              opacity: 0.5,
              cursor: 'wait',
              'box-shadow': '0 0 0 1px #000'
          },
          css: {
              border: 0,
              padding: 0,
              backgroundColor: 'none',
              color: '#fff'
          }
      });

      // For demo purposes
      window.setTimeout(function () {
         $(block).unblock();
      }, 2000); 
  }); 
  $('.sidebar-default .category-title [data-action=reload]').click(function (e) {
      e.preventDefault();
      var block = $(this).parent().parent().parent().parent();
      $(block).block({ 
          message: '<i class="icon-spinner2 spinner"></i>',
          overlayCSS: {
              backgroundColor: '#fff',
              opacity: 0.8,
              cursor: 'wait',
              'box-shadow': '0 0 0 1px #ddd'
          },
          css: {
              border: 0,
              padding: 0,
              backgroundColor: 'none'
          }
      });

      // For demo purposes
      window.setTimeout(function () {
         $(block).unblock();
      }, 2000); 
  }); 
  $('.category-collapsed').children('.category-content').hide();
  $('.category-collapsed').find('[data-action=collapse]').addClass('rotate-180');
  $('.category-title [data-action=collapse]').click(function (e) {
      e.preventDefault();
      var $categoryCollapse = $(this).parent().parent().parent().nextAll();
      $(this).parents('.category-title').toggleClass('category-collapsed');
      $(this).toggleClass('rotate-180');

      containerHeight(); // adjust page height

      $categoryCollapse.slideToggle(150);
  });
  $('.panel-collapsed').children('.panel-heading').nextAll().hide();
  $('.panel-collapsed').find('[data-action=collapse]').addClass('rotate-180');
  $('.panel [data-action=collapse]').click(function (e) {
      e.preventDefault();
      var $panelCollapse = $(this).parent().parent().parent().parent().nextAll();
      $(this).parents('.panel').toggleClass('panel-collapsed');
      $(this).toggleClass('rotate-180');

      containerHeight(); // recalculate page height

      $panelCollapse.slideToggle(150);
  });
  $('.panel [data-action=close]').click(function (e) {
      e.preventDefault();
      var $panelClose = $(this).parent().parent().parent().parent().parent();

      containerHeight(); // recalculate page height

      $panelClose.slideUp(150, function() {
          $(this).remove();
      });
  });
  $('.category-title [data-action=close]').click(function (e) {
      e.preventDefault();
      var $categoryClose = $(this).parent().parent().parent().parent();

      containerHeight(); // recalculate page height

      $categoryClose.slideUp(150, function() {
          $(this).remove();
      });
  });
  $('.navigation').find('li.active').parents('li').addClass('active');
  $('.navigation').find('li').not('.active, .category-title').has('ul').children('ul').addClass('hidden-ul');
  $('.navigation').find('li').has('ul').children('a').addClass('has-ul');
  $('.dropdown-menu:not(.dropdown-content), .dropdown-menu:not(.dropdown-content) .dropdown-submenu').has('li.active').addClass('active').parents('.navbar-nav .dropdown:not(.language-switch), .navbar-nav .dropup:not(.language-switch)').addClass('active');
  $('.navigation-main > .navigation-header > i').tooltip({
      placement: 'right',
      container: 'body'
  });
  $('.navigation-main').find('li').has('ul').children('a').on('click', function (e) {
      e.preventDefault();
      $(this).parent('li').not('.disabled').not($('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).toggleClass('active').children('ul').slideToggle(250);
      if ($('.navigation-main').hasClass('navigation-accordion')) {
          $(this).parent('li').not('.disabled').not($('.sidebar-xs').not('.sidebar-xs-indicator').find('.navigation-main').children('li')).siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(250);
      }
  });
  $('.navigation-alt').find('li').has('ul').children('a').on('click', function (e) {
      e.preventDefault();
      $(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(200);
      if ($('.navigation-alt').hasClass('navigation-accordion')) {
          $(this).parent('li').not('.disabled').siblings(':has(.has-ul)').removeClass('active').children('ul').slideUp(200);
      }
  }); 
  $('.sidebar-main-toggle').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-xs');
  });
  $(document).on('click', '.navigation .disabled a', function (e) {
      e.preventDefault();
  });
  $(document).on('click', '.sidebar-control', function (e) {
      containerHeight();
  });
  $(document).on('click', '.sidebar-main-hide', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-main-hidden');
  });
  $(document).on('click', '.sidebar-secondary-hide', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-secondary-hidden');
  });
  $(document).on('click', '.sidebar-detached-hide', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-detached-hidden');
  });
  $(document).on('click', '.sidebar-all-hide', function (e) {
      e.preventDefault();

      $('body').toggleClass('sidebar-all-hidden');
  });
  $(document).on('click', '.sidebar-opposite-toggle', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-opposite-visible');
      if ($('body').hasClass('sidebar-opposite-visible')) {
          $('body').addClass('sidebar-xs');
          $('.navigation-main').children('li').children('ul').css('display', '');
      }
      else {
          $('body').removeClass('sidebar-xs');
      }
  });
  $(document).on('click', '.sidebar-opposite-main-hide', function (e) {
      e.preventDefault();

      // Opposite sidebar visibility
      $('body').toggleClass('sidebar-opposite-visible');
      
      // If visible
      if ($('body').hasClass('sidebar-opposite-visible')) {

          // Hide main sidebar
          $('body').addClass('sidebar-main-hidden');
      }
      else {

          // Show main sidebar
          $('body').removeClass('sidebar-main-hidden');
      }
  });
  $(document).on('click', '.sidebar-opposite-secondary-hide', function (e) {
      e.preventDefault();

      // Opposite sidebar visibility
      $('body').toggleClass('sidebar-opposite-visible');

      // If visible
      if ($('body').hasClass('sidebar-opposite-visible')) {

          // Hide secondary
          $('body').addClass('sidebar-secondary-hidden');

      }
      else {

          // Show secondary
          $('body').removeClass('sidebar-secondary-hidden');
      }
  });
  $(document).on('click', '.sidebar-opposite-hide', function (e) {
      e.preventDefault();

      // Toggle sidebars visibility
      $('body').toggleClass('sidebar-all-hidden');

      // If hidden
      if ($('body').hasClass('sidebar-all-hidden')) {

          // Show opposite
          $('body').addClass('sidebar-opposite-visible');

          // Hide children lists
          $('.navigation-main').children('li').children('ul').css('display', '');
      }
      else {

          // Hide opposite
          $('body').removeClass('sidebar-opposite-visible');
      }
  });
  $(document).on('click', '.sidebar-opposite-fix', function (e) {
      e.preventDefault();

      // Toggle opposite sidebar visibility
      $('body').toggleClass('sidebar-opposite-visible');
  });
  $('.sidebar-mobile-main-toggle').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-mobile-main').removeClass('sidebar-mobile-secondary sidebar-mobile-opposite sidebar-mobile-detached');
  });
  $('.sidebar-mobile-secondary-toggle').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-mobile-secondary').removeClass('sidebar-mobile-main sidebar-mobile-opposite sidebar-mobile-detached');
  });
  $('.sidebar-mobile-opposite-toggle').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-mobile-opposite').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-detached');
  });
  $('.sidebar-mobile-detached-toggle').on('click', function (e) {
      e.preventDefault();
      $('body').toggleClass('sidebar-mobile-detached').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-opposite');
  });
  $(window).on('resize', function() {
      setTimeout(function() {
          containerHeight();
          
          if($(window).width() <= 768) {

              // Add mini sidebar indicator
              $('body').addClass('sidebar-xs-indicator');

              // Place right sidebar before content
              $('.sidebar-opposite').insertBefore('.content-wrapper');

              // Place detached sidebar before content
              $('.sidebar-detached').insertBefore('.content-wrapper');

              // Add mouse events for dropdown submenus
              $('.dropdown-submenu').on('mouseenter', function() {
                  $(this).children('.dropdown-menu').addClass('show');
              }).on('mouseleave', function() {
                  $(this).children('.dropdown-menu').removeClass('show');
              });
          }
          else {

              // Remove mini sidebar indicator
              $('body').removeClass('sidebar-xs-indicator');

              // Revert back right sidebar
              $('.sidebar-opposite').insertAfter('.content-wrapper');

              // Remove all mobile sidebar classes
              $('body').removeClass('sidebar-mobile-main sidebar-mobile-secondary sidebar-mobile-detached sidebar-mobile-opposite');

              // Revert left detached position
              if($('body').hasClass('has-detached-left')) {
                  $('.sidebar-detached').insertBefore('.container-detached');
              }

              // Revert right detached position
              else if($('body').hasClass('has-detached-right')) {
                  $('.sidebar-detached').insertAfter('.container-detached');
              }

              // Remove visibility of heading elements on desktop
              $('.page-header-content, .panel-heading, .panel-footer').removeClass('has-visible-elements');
              $('.heading-elements').removeClass('visible-elements');

              // Disable appearance of dropdown submenus
              $('.dropdown-submenu').children('.dropdown-menu').removeClass('show');
          }
      }, 100);
  }).resize();
  $('[data-popup="popover"]').popover();
  $('[data-popup="tooltip"]').tooltip();
});