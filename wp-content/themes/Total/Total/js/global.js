(function($) {
	"use strict";
	
	/* --------------------------------*/
	/* - Total Theme
	/* -------------------------------*/

	// VARS
	var $window = $(window);
	var $windowsize = $window.width();
	
	// Doc ready functions
	$(document).ready(function (){
		
		// If menu item has classname "nav-no-click" then  return false
		$('li.nav-no-click > a').click( function() {
			return false;
		});
		
		// Main superfish menu without supersubs
		$('ul.sf-menu').superfish({
			delay: 100,
			//animation: {opacity:'show', height:'show'},
			animation: { opacity: 'show' },
			speed: 'fast',
			speedOut: 'fast',
			cssArrows: false,
			disableHI: false
		});
		
		// Search - overlay modal
		$("a.search-overlay-toggle").leanerModal({
			id : '#searchform-overlay',
			top : 100,
			overlay : 0.8
		});

		$("a.search-overlay-toggle").click(function() {
			$('#site-searchform input').focus();
		});
		
		// Search - dropdown
		$("a.search-dropdown-toggle").click(function( event ) {
			$('div#current-shop-items-dropdown').hide();
			$("li.wcmenucart-toggle-dropdown").removeClass('current-menu-item');
			$('#searchform-dropdown').fadeToggle('fast');
			$('#searchform-dropdown input').focus();
			$(this).parent('li').toggleClass('current-menu-item');
			return false;
		});
		
		// Search - header replace
		$("a.search-header-replace-toggle").click(function( event ) {
			$('#searchform-header-replace').fadeToggle('fast');
			$('#searchform-header-replace input').focus();
			return false;
		});
		
		$('#searchform-header-replace-close').click( function(){
			$('#searchform-header-replace').fadeOut('fast');
			return false;
		});
		
		// Close searchforms
		$('#searchform-dropdown, #searchform-header-replace, #toggle-bar-wrap').click(function( event ) {
			event.stopPropagation();
		});
		
		$(document).click( function(){
			$('#searchform-dropdown, #searchform-header-replace').fadeOut('fast');
			$('a.search-dropdown-toggle').parent('li').removeClass('current-menu-item');
			$('#toggle-bar-wrap').removeClass('active-bar');
			$('a.toggle-bar-btn.fade-toggle').children('.fa').removeClass('fa-minus').addClass('fa-plus');
		});
		
		// Sidebar menu toggle
		var submenuParent = $("div#main .widget_nav_menu ul.sub-menu").parent('li');
		if( submenuParent.length ) {
			submenuParent.addClass('parent');
			$('.parent > a').click( function() {
				$(this).parent('li').children('.sub-menu').stop(true,true).slideToggle('fast');
				$(this).parent('li').toggleClass('active');
				return false;
			});
		}
		
		if ( ! $('a.wcmenucart').hasClass('go-to-shop') ) {
			// Woo Cart - Modal
			$("li.wcmenucart-toggle-overlay").leanerModal({
				id : '#current-shop-items-overlay',
				top : 100,
				overlay : 0.8
			});
			
			// Woo Car - Drop-down
			$("li.wcmenucart-toggle-dropdown").click(function( event ) {
				$('#searchform-dropdown').hide();
				$('a.search-dropdown-toggle').parent('li').removeClass('current-menu-item');
				$('div#current-shop-items-dropdown').fadeToggle('fast');
				$(this).toggleClass('current-menu-item');
				return false;
			});
			
			$('div#current-shop-items-dropdown').click(function( event ) {
				event.stopPropagation(); 
			});
			
			$(document).click( function(){
				$('div#current-shop-items-dropdown').fadeOut('fast');
				$("li.wcmenucart-toggle-dropdown").removeClass('current-menu-item');
			});
		}
		
		// Mobile menu - sidr
		if ( typeof wpexLocalize.sidrSource != 'undefined' ) {
			$('a.sidr-menu-toggle').sidr({
				name: 'sidr-main',
				source: wpexLocalize.sidrSource,
				side: 'left',
				renaming: true,
				displace: false
			});
		}

		// Mobile menu subitem toggle
		$('.sidr-class-menu-item-has-children').each(function (index) {
			$(this).append('<span class="sidr-class-dropdown-toggle"><i class="fa fa-chevron-right"></i></span>');
		});
		$('.sidr-class-dropdown-toggle').on('click touchstart', function () {
			var nextList = $(this).prev('ul');
			var html = nextList.is(':visible') ? '<i class="fa fa-chevron-right"></i>' : '<i class="fa fa-chevron-down"></i>';
			$(this).html(html);
			nextList.toggle();
			$(this).toggleClass('active');
			return false;
		});
		
		// Close sidr on click
		$('a.sidr-class-toggle-sidr-close').click(function() {
			$.sidr('close', 'sidr-main');
			return false;
		});

		// Back to top scroll
		var $scrollTopLink = $( 'a#site-scroll-top' );
		$window.scroll(function () {
			if ($(this).scrollTop() > 100) {
				$scrollTopLink.fadeIn();
			} else {
				$scrollTopLink.fadeOut();
			}
		});
		$scrollTopLink.on('click', function() {
			$( 'html, body' ).animate({scrollTop:0}, 400);
			return false;
		} );

		// Comment scroll
		$( '.single li.comment-scroll a' ).click( function(event) {
			event.preventDefault();
			$( 'html,body' ).animate( {
				scrollTop: $( this.hash ).offset().top -180 }, 'normal');
		} );

		// Lightbox Vars
		if ( wpexLocalize.lightboxArrows === '1' ) {
			wpexLocalize.lightboxArrows = true;
		} else {
			wpexLocalize.lightboxArrows = false;
		}
		if ( wpexLocalize.lightboxThumbnails === '1' ) {
			wpexLocalize.lightboxThumbnails = true;
		} else {
			wpexLocalize.lightboxThumbnails = false;
		}
		if ( wpexLocalize.lightboxFullScreen === '1' ) {
			wpexLocalize.lightboxFullScreen = true;
		} else {
			wpexLocalize.lightboxFullScreen = false;
		}
		if ( wpexLocalize.lightboxMouseWheel === '1' ) {
			wpexLocalize.lightboxMouseWheel = true;
		} else {
			wpexLocalize.lightboxMouseWheel = false;
		}
		if ( wpexLocalize.lightboxTitles === '1' ) {
			wpexLocalize.lightboxTitles = true;
		} else {
			wpexLocalize.lightboxTitles = false;
		}

		// Lightbox Standard
		$('.wpex-lightbox, .wpb_single_image.image-lightbox a').each( function() {
			$(this).iLightBox({
				skin: wpexLocalize.LightboxSkin,
				controls: {
					fullscreen: wpexLocalize.lightboxFullScreen,
				}
			});
		});

		// Lightbox Videos
		$('.wpex-lightbox-video, .wpb_single_image.video-lightbox a').iLightBox({
			skin: wpexLocalize.LightboxSkin,
			path: 'horizontal',
			show: {
				title: wpexLocalize.lightboxTitles
			},
			controls: {
				fullscreen: wpexLocalize.lightboxFullScreen,
				mousewheel: wpexLocalize.lightboxMouseWheel
			},
			smartRecognition: true
		});

		// Lightbox Galleries
		$('.wpex-gallery-lightbox, .vcex-gallery-lightbox').each( function() {
			$(this).find('a').iLightBox({
				skin: wpexLocalize.lightboxSkin,
				path: 'horizontal',
				show: {
					title: wpexLocalize.lightboxTitles
				},
				controls: {
					arrows: wpexLocalize.lightboxArrows,
					thumbnail: wpexLocalize.lightboxThumbnails,
					fullscreen: wpexLocalize.lightboxFullScreen,
					mousewheel: wpexLocalize.lightboxMouseWheel
				}
			});
		});

		// Lightbox Gallery with custom imgs
		$('.wpex-lightbox-gallery').bind('click', function(event) {
			event.preventDefault();
			var imagesArray = $(this).data('gallery').split(',');
			//console.log(imagesArray);
			if ( imagesArray ) {
				$.iLightBox(imagesArray, {
					skin: wpexLocalize.lightboxSkin,
					path: 'horizontal',
					show: {
						title: wpexLocalize.lightboxTitles
					},
					controls: {
						arrows: wpexLocalize.lightboxArrows,
						thumbnail: wpexLocalize.lightboxThumbnails,
						fullscreen: wpexLocalize.lightboxFullScreen,
						mousewheel: wpexLocalize.lightboxMouseWheel
					}
				});
			}
		});

		// Tipsy
		$('a.tooltip-left').tipsy({fade: true, gravity: 'e'});
		$('a.tooltip-right').tipsy({fade: true, gravity: 'w'});
		$('a.tooltip-up').tipsy({fade: true, gravity: 's'});
		$('a.tooltip-down').tipsy({fade: true, gravity: 'n'});
		
		// Custom Selects
		$('.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, #bbp_stick_topic_select, #bbp_topic_status_select, #bbp_destination_topic').customSelect({
			customClass: "theme-select"
		});
		
		// Sociallight sharing buttons
		if ( $('.social-share-buttons.style-counter').width() ) {
			Socialite.load();
		}

		// Toggle bar
		$('a.toggle-bar-btn.fade-toggle').on('click touchstart', function () {
			$(this).find('.fa').toggleClass('fa-plus fa-minus');
			$('#toggle-bar-wrap').toggleClass('active-bar');
			return false;
		});

		// Local Scroll - Menu
		$('li.local-scroll a').click(function() {
			var target = $(this.hash);
			if ( $('body').hasClass('shrink-fixed-header') ) {
				var topOffset = '60';
			} else if ( $('#site-header').hasClass('fixed-scroll') ) {
				var topOffset = $('#site-header').outerHeight();
			} else {
				var topOffset = '';
			}
			if ($(target).length) {
				$('.main-navigation li').removeClass('current-menu-item');
				$(this).parent('li').addClass('current-menu-item');
				$('html,body').stop(true,true).animate({
					scrollTop: target.offset().top - topOffset
				}, 1000);
			}
			return false;
		});

		// Local Scroll Anylink
		$('.local-scroll-link').click(function() {
			var target = $(this.hash);
			if ( $('body').hasClass('shrink-fixed-header') ) {
				var topOffset = '60';
			} else if ( $('#site-header').hasClass('fixed-scroll') ) {
				var topOffset = $('#site-header').outerHeight();
			} else {
				var topOffset = '';
			}
			if ($(target).length) {
				$('html,body').stop(true,true).animate({
					scrollTop: target.offset().top - topOffset
				}, 1000);
			}
			return false;
		});

		// LocalScroll Woocommerce Reviews
		$('body.single div.entry-summary a.woocommerce-review-link').click(function() {
			var target = $(this.hash);
			if ( $('body').hasClass('shrink-fixed-header') ) {
				var topOffset = '60';
			} else if ( $('#site-header').hasClass('fixed-scroll') ) {
				var topOffset = $('#site-header').outerHeight();
			} else {
				var topOffset = '';
			}
			if ($(target).length) {
				$('html,body').stop(true,true).animate({
					scrollTop: target.offset().top - topOffset - 30
				}, 1000);
			}
			return false;
		});

		// Skillbar
		$('.vcex-skillbar').each(function(){
			$(this).find('.vcex-skillbar-bar').animate({ width: $(this).attr('data-percent') }, 800 );
		});

		// Milestone
		$('.vcex-animated-milestone').each(function() {
			$(this).appear(function() {
				$(this).find('.vcex-milestone-time').countTo();
			},{accX: 0, accY: 0});
		});

		// Custom hovers using data attributes
		$('a.wpex-data-hover, .wpex-data-hover a').hover( function() {
			if ( typeof $(this).attr('data-hover-background') !== "undefined" ) {
				$(this).css({
					background: $(this).attr('data-hover-background')
				});
			}
			if ( typeof $(this).attr('data-hover-color') !== "undefined" ) {
				$(this).css({
					color: $(this).attr('data-hover-color')
				});
			}
		}, function() {
			if ( typeof $(this).attr('data-original-background') !== "undefined" ) {
				$(this).css({
					background: $(this).attr('data-original-background')
				});
			}
			if ( typeof $(this).attr('data-original-color') !== "undefined" ) {
				$(this).css({
					color: $(this).attr('data-original-color')
				});
			}
		});

		/* --------------------------------*/
		/* - On Images Loaded
		/* -------------------------------*/
		$('#wrap').imagesLoaded(function(){

			// Run Some functions
			wpexIsotopeGrid();
			wpexNoMarginsGridMasonry();
			wpexBlogIsotope();
			wpexPortfolioArchivesMasonry();

			// Run or re-run functions on resize and orientation change
			var isIE8 = $.browser.msie && +$.browser.version === 8;
			if (isIE8) {
				document.body.onresize = function () {
					wpexIsotopeGrid();
					wpexBlogIsotope();
					wpexPortfolioArchivesMasonry();
				};
			} else {
				$(window).resize(function () {
					wpexIsotopeGrid();
					wpexBlogIsotope();
					wpexPortfolioArchivesMasonry();
				});
				window.addEventListener("orientationchange", function() {
					wpexIsotopeGrid();
					wpexBlogIsotope();
					wpexPortfolioArchivesMasonry();
				});
			}

			// Advanced Parallax
			$('div.vcex-parallax-div').each(function() {
				$(this).scrolly2().trigger('scroll');
			});

			// Equal Height columns
			$('.equal-height-column').matchHeight();

			// Simple Parallax
			if ( ! $('body').hasClass('.is_mobile') ) {
				$('.style-parallax, .row-with-parallax .vcex-background-parallax').each(function(){
					var $bgobj = $(this);
					$window = $(window);
					$(window).scroll(function() {
						var yPos = -($window.scrollTop() / '8'); 
						var coords = '50% '+ yPos + 'px';
						$bgobj.css({ backgroundPosition: coords });
					});
				});
			}

			// Carousels
			$(".vcex-caroufredsel-wrap .vcex-caroufredsel-prev,.vcex-caroufredsel-wrap .vcex-caroufredsel-next").show();

			// FlexSliders
			$( ".vcex-flexslider, .vcex-galleryslider" ).each( function() {
				var $slider = $(this);
				var slideshow = $slider.data("slideshow"),
				animation = $slider.data("animation"),
				randomize = $slider.data("randomize"),
				direction = $slider.data("direction"),
				slideshowSpeed = $slider.data("slideshow-speed"),
				animationSpeed = $slider.data("animation-speed"),
				directionNav = $slider.data("direction-nav"),
				pauseOnHover = $slider.data("pause"),
				smoothHeight = $slider.data("smooth-height"),
				controlNav = $slider.data("control-nav");
				$slider.flexslider({
					slideshow : slideshow,
					animation: animation,
					randomize : randomize,
					direction: direction,
					slideshowSpeed : slideshowSpeed,
					animationSpeed : animationSpeed,
					directionNav : directionNav,
					pauseOnHover : pauseOnHover,
					smoothHeight : smoothHeight,
					controlNav : controlNav,
					prevText : '<i class=fa fa-chevron-left"></i>',
					nextText : '<i class="fa fa-chevron-right"></i>'
				});
			});

			// Gallery slider
			$('.gallery-format-post-slider').flexslider({
				animation: 'fade',
				animationSpeed: 500,
				slideshow: true,
				smoothHeight: false,
				directionNav: true,
				controlNav : "thumbnails",
				prevText : '<span class="fa fa-chevron-left"></span>',
				nextText : '<span class="fa fa-chevron-right"></span>'
			});

			// Woo Entry slider
			$( ".woocommerce-single-product-slider" ).flexslider({
				animation: 'fade',
				animationSpeed: 500,
				slideshow: false,
				smoothHeight: true,
				directionNav: false,
				controlNav : "thumbnails",
				controlsContainer: ".woocommerce-single-product-slider-wrap"
			});
			
			// Woo Entry slider
			$( ".woo-product-entry-slider" ).each( function() {
				var $this = $(this);
				$(this).flexslider({
					animation: 'fade',
					slideshow : false,
					randomize : false,
					controlNav: true,
					directionNav: false,
					smoothHeight: false,
					prevText : '<span class="fa fa-chevron-left"></span>',
					nextText : '<span class="fa fa-chevron-right"></span>',
					start: function(slider) {
					$this.click(function(event){
						event.preventDefault();
							slider.flexAnimate(slider.getTarget("next"));
						});
					}
				});
			});

		}); // End Images Loaded
	}); // End doc ready


	/* --------------------------------*/
	/* - Window Load
	/* -------------------------------*/
	$window.load(function(){

		// Fixed header/nav
		if ( $windowsize >= 960 ) {
			$("#site-header.fixed-scroll").sticky({
				topSpacing:0
			});
			$(".fixed-nav").sticky({
				topSpacing:0
			});
		}

		// Scroll to hash
		function wpexScrollToHash() {
			var $hash = location.hash;
			if ($hash.indexOf('localscroll-') != -1) {
				var target = $hash.replace('localscroll-','');
				if ( $(target).length ) {
					if ( $('body').hasClass('shrink-fixed-header') ) {
						var topOffset = '60';
					} else if ( $('#site-header').hasClass('fixed-scroll') ) {
						var topOffset = $('#site-header').outerHeight();
					} else {
						var topOffset = '';
					}
					$('html,body').animate({
						scrollTop: $(target).offset().top - topOffset
					}, 1000);
				}
			}
		}
		window.setTimeout(wpexScrollToHash, 500);
		$(window).on('hashchange', wpexScrollToHash);
		
	}); // End on window load

	/* --------------------------------*/
	/* - Functions
	/* -------------------------------*/

	// Isotope Containers
	function wpexIsotopeGrid() {
		$('.vcex-isotope-grid').each( function () {
			// Initialize isotope
			var $container = $(this);
			$container.isotope({
				itemSelector: '.vcex-isotope-entry'
			});
			// Isotope filter links
			var $filter = $container.prev('ul.vcex-filter-links');
			var $filterLinks = $filter.find('a');
			$filterLinks.each( function() {
				var $filterableDiv = $(this).data('filter');
				if ( $filterableDiv !== '*' && ! $container.find($filterableDiv).length ) {
					$(this).parent().hide('100');
				}
			});
			$filterLinks.css({ opacity: 1 } );
			$filterLinks.click(function(){
			var selector = $(this).attr('data-filter');
				$container.isotope({
					filter: selector
				});
				$(this).parents('ul').find('li').removeClass('active');
				$(this).parent('li').addClass('active');
			return false;
			});
		});
	}

	// No Margins Grid
	function wpexNoMarginsGridMasonry() {
		$('.vcex-no-margin-grid').each( function () {
			var $container = $(this);
			$container.masonry({
				itemSelector: ".vcex-no-margin-entry"
			});
		});
	}

	// Masonry Grids
	function wpexBlogIsotope() {
		var $container = $('.blog-masonry-grid');
		$container.isotope({
			itemSelector: '.blog-entry'
		});
	}

	// Portfolio archives masonry
	function wpexPortfolioArchivesMasonry() {
		$('div.wpex-row.portfolio-no-margins, div.wpex-row.wpex-row.portfolio-masonry, div.wpex-row.staff-masonry, div.wpex-row.staff-no-margins').masonry({
			itemSelector: ".portfolio-entry"
		});
	}

})(jQuery);