$(function() {
  $('.js-logout-btn').on('click', function() {
    $.ajax({
      url : '/app/logout',
      success: function (data) {
        if (JSON.parse(data).status) {
          window.location.assign('/');
        }
      }
    });
  });

  $('body').on('click', '.js-category', function() {
    var $category = $(this),
        group = $category.data('group');
    
    $('.js-category').removeClass('selected');
    $category.addClass('selected');

    if (group === 'all') {
      $('.js-images img').removeClass('hide');
      return;
    }

    $('.js-images img').each(function(index, el) {
      var $el = $(el),
          groups = $el.data('groups');
      if (groups.indexOf(group) === -1) {
        $el.addClass('element-to-hide');
      }
    });
    $('.js-images img').removeClass('hide');
    $('.element-to-hide').addClass('hide');
    $('.body').scrollTop(0);
    $('.element-to-hide').removeClass('element-to-hide');
  });

  function getImagesData() {
    if ($('.js-content').data('loggedIn')) {
      $.ajax({
        url : '/home/getImagesData',
        success: function (data) {
          var dataJSON = JSON.parse(data);
          if (dataJSON.status) {
            $('.js-loader').remove();
            $('.js-content').html(dataJSON.html);
          }
        }
      });
    }
  }

  getImagesData();
});