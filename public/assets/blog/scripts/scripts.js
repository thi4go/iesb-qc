'use strict';

// Main
(function (window, document, $) {
  'use strict';

  window.mod = {};

  $(function () {
    // Carregando os modulos
    window.mod.common = new window.mod.common();

    var bodyClasses = $('body').attr('class').split(' ');
    $.each(bodyClasses, function (key, val) {
      val = val.replace(/[-]/g, '');
      if (window.mod[val] !== undefined) {
        // console.log(key + ' => ' + val);
        window.mod[val] = new window.mod[val]();
      }
    });
  });
})(window, document, jQuery);
'use strict';

// Common
window.mod.common = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin common.js');
    window.mod.navbar = new window.mod['navbar']();
    window.mod.slidemenu = new window.mod['slidemenu']();
    window.mod.search = new window.mod['search']();
    window.mod.tags = new window.mod['tags']();
    initFixed();
  };

  var initFixed = function initFixed() {
    if (document.getElementsByClassName('homes').length == 0) {
      $('.Navbar').addClass('u-fixed');
    }
  };

  init();
};
'use strict';

// Homes
window.mod.homes = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin homes.js');
    window.mod.slide = new window.mod['slide']();
    window.mod.promo = new window.mod['promo']();
    initNextLink();
  };

  var initNextLink = function initNextLink() {
    $('.Home-next').click(function () {
      $('html, body').animate({
        'scrollTop': $('.Navbar').offset().top
      }, 800);
    });
  };

  init();
};
'use strict';

// Navbar
window.mod.navbar = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin navbar.js');
    initNavbar();
  };

  var initNavbar = function initNavbar() {
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('.Navbar').outerHeight();

    $(window).scroll(function (event) {
      didScroll = true;
    });

    setInterval(function () {
      if (didScroll) {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta) return;

        // If they scrolled down and are past the navbar, add class .Navbar-up.
        if (st > lastScrollTop && st > navbarHeight) {
          // Scroll Down
          $('.Navbar').removeClass('Navbar-down').addClass('Navbar-up');
        } else {
          // Scroll Up
          if (st + $(window).height() < $(document).height()) {
            $('.Navbar').removeClass('Navbar-up').addClass('Navbar-down');
          }
        }

        if (document.getElementsByClassName('homes').length > 0) {
          if (st > $(window).height()) {
            $('.Navbar').addClass('u-fixed');
            $('.Content--postsHome').removeClass('u-p-t-50').addClass('u-p-t-200');
          } else {
            $('.Navbar').removeClass('u-fixed');
            $('.Content--postsHome').removeClass('u-p-t-200').addClass('u-p-t-50');
          }
        }

        lastScrollTop = st;

        didScroll = false;
      }
    }, 1000);
  };

  init();
};
'use strict';

// Posts
window.mod.posts = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin posts.js');
    window.mod.share = new window.mod['share']();
    window.mod.rating = new window.mod['rating']();
  };

  init();
};
'use strict';

// Promo
window.mod.promo = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin promo.js');
    initListeners();
  };

  that.openPromo = function () {
    $('body').addClass('hasOpenMenu');
    $('.Promo').addClass('active');
    bindEscKey();
  };

  that.closePromo = function () {
    $('body').removeClass('hasOpenMenu');
    $('.Promo').removeClass('active');
  };

  var initListeners = function initListeners() {
    that.openPromo();

    $('.Promo-close').click(function () {
      that.closePromo();
    });

    that.openForm();
  };

  that.openForm = function () {
    $('.Promo-download').click(function (e) {
      e.preventDefault();
      $('.Promo-logo').addClass('center-block').fadeIn(1500);
      $('.Promo-cta').removeClass('active').fadeIn(1500);
      $('.Promo-form').addClass('active').fadeIn(1500);
      that.sendForm();
    });
  };

  that.sendForm = function () {
    $('.Promo-form').on('submit', function (e) {
      e.preventDefault();

      $('.Promo-form .Promo-button').html('Enviando...');

      var data = {
        name: $('#name').val(),
        email: $('#email').val()
      };

      $.ajax({
        type: 'POST',
        'headers': {
          'X-CSRF-Token': $('#token').val()
        },
        'url': '/conversao/enviar',
        'data': data,
        'async': false,
        'dataType': 'json',
        'success': function success(resp) {
          $('.Promo-formValidate').text('');
          alert(resp.message);
          that.closePromo();
          window.open(resp.redirect);
        },
        'error': function error(resp) {
          setTimeout(function () {
            $('.Promo-form .Promo-button').text('Enviar');
          }, 1000);

          $('.Promo-formValidate').text('');
          $.each(resp.responseJSON.errors, function (key, value) {
            var input = '.Promo-form input[name=' + key + ']';
            $(input + '+span').text(value);
          });
        }
      });
    });
  };

  var bindEscKey = function bindEscKey() {
    $(document).bind('keydown.closePromo', function (e) {
      if (e.which == 27) {
        e.preventDefault();
        that.closePromo();
        unbindEscKey();
      }
    });
  };

  var unbindEscKey = function unbindEscKey() {
    $(document).unbind('keyup.closePromo');
  };

  init();
};
'use strict';

// Rating
window.mod.rating = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin rating.js');
    initRating();
  };

  var initRating = function initRating() {
    getVotes();
    hoverStars();
    bindVote();
  };

  var hoverStars = function hoverStars() {
    $('.Rating-stars').hover(
    // Handles the mouseover
    function () {
      $(this).prevAll().andSelf().addClass('Icon--starfillBefore');
      $(this).nextAll().removeClass('Icon--starfillBefore').addClass('Icon--starBefore');
    },
    // Handles the mouseout
    function () {
      $(this).prevAll().andSelf().removeClass('Icon--starfillBefore');
      setVotes($(this).parent());
    });
  };

  var getVotes = function getVotes(rating) {
    $('.Rating').each(function (i) {
      var rating = $(this);

      var data = {
        id: rating.data('id')
      };

      $.post({
        'headers': {
          'X-CSRF-Token': rating.data('token')
        },
        'url': '/avaliacoes/nota',
        'data': data,
        'dataType': 'json',
        'success': function success(resp) {
          $(rating).data('rating', resp.data);
          setVotes(rating);
        },
        'error': function error(resp) {
          alert(resp.responseJSON.message);
        }
      });
    });
  };

  var setVotes = function setVotes(rating) {
    var avr = $(rating).data('rating').avr;
    var rtp = $(rating).data('rating').rtp;
    var total = $(rating).data('rating').total;

    $(rating).find('.Rating-stars--' + avr).prevAll().andSelf().addClass('Icon--starfillBefore').removeClass('Icon--starBefore');
    $(rating).find('.Rating-stars--' + avr).nextAll().removeClass('Icon--starfillBefore').addClass('Icon--starBefore');
  };

  var bindVote = function bindVote() {
    $('.Rating-stars').click(function () {
      var star = $(this);
      var rating = $(this).parent();

      var data = {
        id: rating.data('id'),
        value: $(star).data('value')
      };

      $.post({
        'headers': {
          'X-CSRF-Token': rating.data('token')
        },
        'url': '/avaliacoes/avaliar',
        'data': data,
        'dataType': 'json',
        'success': function success(resp) {
          $(rating).data('rating', resp.data);
          setVotes(rating);
        },
        'error': function error(resp) {
          alert(resp.responseJSON.message);
        }
      });
    });
  };

  init();
};
'use strict';

// Search
window.mod.search = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin search.js');
    initListeners();
    initFind();
  };

  that.openSearch = function () {
    $('body').addClass('hasOpenMenu');
    $('.Search').addClass('active');
    $('#searchInput').focus();
    bindEscKey();
  };

  that.closeSearch = function () {
    $('body').removeClass('hasOpenMenu');
    $('.Search').removeClass('active');
  };

  var initListeners = function initListeners() {
    $('.Search-open').click(function () {
      that.openSearch();
    });

    $('.Search-close').click(function () {
      that.closeSearch();
    });
  };

  var bindEscKey = function bindEscKey() {
    $(document).bind('keydown.closeSearch', function (e) {
      if (e.which == 27) {
        e.preventDefault();
        that.closeSearch();
        unbindEscKey();
      }
    });
  };

  var unbindEscKey = function unbindEscKey() {
    $(document).unbind('keyup.closeSearch');
  };

  var search = function search() {
    var q = $('#searchInput').val();
    if (q !== '') {
      $.ajax({
        type: 'GET',
        url: '/posts/buscar',
        data: { q: q },
        success: function success(view) {
          $('#post-results').html(view);
        }
      });
    }return false;
  };

  var initFind = function initFind() {
    $('#searchForm').submit(false);
    $('#searchInput').on('keyup', function (e) {
      clearTimeout($.data(this, 'timer'));
      var q = $(this).val();
      if (q.length < 3) {
        $('#post-results').fadeOut();
      } else {
        $('#post-results').fadeIn();
        $(this).data('timer', setTimeout(search, 100));
      };
    });
  };

  init();
};
'use strict';

// Share
window.mod.share = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin share.js');
    initShare();
  };

  var initShare = function initShare() {
    $('.Share-link').click(function (e) {
      e.preventDefault();

      var url,
          el = $(this),
          shareUrl = el.data('url'),
          shareTitle = el.data('title');

      if (el.hasClass('twitter')) {
        url = 'https://twitter.com/intent/tweet?url=' + shareUrl + '&text=' + shareTitle + '&wrap_links=true';
      } else if (el.hasClass('facebook')) {
        url = 'https://www.facebook.com/sharer/sharer.php?u=' + shareUrl;
      } else if (el.hasClass('googleplus')) {
        url = 'https://plus.google.com/share?url=' + shareUrl;
      }

      window.open(url, '_blank');
    });
  };

  init();
};
'use strict';

// Slide
window.mod.slide = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin slide.js');
    initSlide();
  };

  var time = 4; // time in seconds
  var $progressBar, $barArea, $bar, $elem, isPause, tick, percentTime, $slide;

  var initSlide = function initSlide() {
    $('.Home-slidershow').owlCarousel({
      loop: true,
      animateOut: 'fadeOut',
      items: 1,
      nav: false,
      dots: true,
      mouseDrag: false,
      dotsContainer: '.Home-sliderDots',
      onInitialized: progressBar,
      onTranslate: moved,
      onDrag: pauseOnDragging
    });
  };

  // var animateItens = function(){
  //   $slide = $('.Home-slidershow').find('.active');
  //   $slide.find('.Home-sliderTitle').slideDown('slow');
  //   $slide.find('.Home-sliderText').slideUp('slow');
  // };

  var progressBar = function progressBar() {
    $barArea = $('<div>', {
      class: 'Home-sliderBar hidden-xs'
    });

    $progressBar = $('<div>', {
      class: 'Home-sliderProgressBar'
    });

    $bar = $('<div>', {
      class: 'Home-sliderBarLoading'
    });

    $progressBar.append($bar);
    $barArea.append($progressBar).prependTo($('.Home-slidershow'));

    // start counting
    start();
  };

  var start = function start() {
    // reset timer
    percentTime = 0;
    isPause = false;
    // run interval every 0.01 second
    tick = setInterval(interval, 10);
  };

  var interval = function interval() {
    if (isPause === false) {
      percentTime += 1 / time;

      $bar.css({
        width: percentTime + '%'
      });

      // if percentTime is equal or greater than 100
      if (percentTime >= 100) {
        // slide to next item
        $('.Home-slidershow').trigger('next.owl.carousel');
        percentTime = 0;
      }
    }
  };

  // pause while dragging
  var pauseOnDragging = function pauseOnDragging() {
    isPause = true;
  };

  // moved callback
  var moved = function moved() {
    clearTimeout(tick);
    start();
  };

  init();
};
'use strict';

// SlideMenu
window.mod.slidemenu = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin slidemenu.js');
    initListeners();
    // Uncomment the line below if you want to debug the slidemenu
    // that.openMenu();
  };

  var initListeners = function initListeners() {
    // Opener
    $('.SlideMenu-open').click(that.openMenu);

    // Closer
    $('.SlideMenu-close').click(that.closeMenu);
    $('.MenuMask').click(that.closeMenu);
  };

  that.closeMenu = function () {
    console.log('[brz] closing menu');
    $('.SlideMenu').removeClass('active');
    $('.MenuMask').removeClass('active');
    $('body').removeClass('hasOpenMenu');
  };

  that.openMenu = function () {
    $('.SlideMenu').addClass('active');
    $('.MenuMask').addClass('active');
    $('body').addClass('hasOpenMenu');
    bindEscKey();
  };

  var bindEscKey = function bindEscKey() {
    $(document).on('keyup.closeMenu', function (e) {
      if (e.which === 27) {
        console.log('[brz] pressing esc');
        that.closeMenu();
        unbindEscKey();
      }
    });
  };

  var unbindEscKey = function unbindEscKey() {
    $(document).unbind('keyup.closeMenu');
  };

  init();
};
'use strict';

// Tags
window.mod.tags = function () {

  // Scope
  var that = this;

  var init = function init() {
    console.log('[brz] begin tags.js');
    initListeners();
    // Uncomment this line if you want to debug the tags lightbox
    // that.openTags();
  };

  that.openTags = function () {
    $('body').addClass('hasOpenMenu');
    $('.Tags').addClass('active');
    bindEscKey();
  };

  that.closeTags = function () {
    $('body').removeClass('hasOpenMenu');
    $('.Tags').removeClass('active');
  };

  var initListeners = function initListeners() {
    $('.Tags-open').click(function () {
      that.openTags();
    });

    $('.Tags-close').click(function () {
      that.closeTags();
    });
  };

  var bindEscKey = function bindEscKey() {
    $(document).bind('keydown.closeTags', function (e) {
      if (e.which == 27) {
        e.preventDefault();
        that.closeTags();
        unbindEscKey();
      }
    });
  };

  var unbindEscKey = function unbindEscKey() {
    $(document).unbind('keyup.closeTags');
  };

  init();
};