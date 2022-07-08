jQuery(document).ready(function() {

	"use strict";

 	var $ = jQuery;
    var screenRes = $(window).width(),
        screenHeight = $(window).height(),
        html = $('html');

    $(window).resize(function() {
        screenRes = $(window).width();
        screenHeight = $(window).height();
    });

// IE<8 Warning
    if (html.hasClass("oldie")) {
        $("body").empty().html('Please, Update your Browser to at least IE8');
    }

// Remove outline in IE
	$("a, input, textarea").attr("hideFocus", "true").css("outline", "none");

// Disable Empty Links
    $("[href=#]").click(function(event){
        event.preventDefault();
    });

// Tooltip
    $("[data-toggle='tooltip']").tooltip();

// Remove padding-bottom if next section has padding
    if (!html.hasClass('ie8')) {
        $('.main-row').each(function(){
            var $this = $(this);

            if($this.attr("class").trim() == "main-row" && $this.next().length && $this.next().attr("class").trim() == "main-row") {
                $this.addClass('padding-bottom-0');
            }
        });
    }

// Placeholders
    if($("[placeholder]").size() > 0) {
        $.Placeholder.init({color : "#291c1c"});
    }

// SyntaxHighlighter
    if ($("pre").hasClass("brush: plain")) {
        SyntaxHighlighter.defaults['gutter'] = false;
        SyntaxHighlighter.defaults['toolbar'] = true;
        SyntaxHighlighter.all();
    }

// Styled Select, CheckBox, RadioBox
    if ($(".select-styled").length) {
        cuSel({changedEl: ".select-styled", visRows: 6, itemPadding: 14});
    }
    if ($(".input-styled").length) {
        $(".input-styled input").customInput();
    }

// PrettyPhoto LightBox, check if <a> has attr data-rel and hide for Mobiles
    if($('a').is('[data-rel]') && screenRes > 600) {
        $('a[data-rel]').each(function() {
            $(this).attr('rel', $(this).data('rel'));
        });
        $("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
    }

// Main Slider, Post Slider, Animated Header
    $.fn.sliderApi = function() {
        var slider = $(this),
            header = $('.page-header'),
            animateClass;

        slider.find('[data-animate-in]').addClass('animated');

        // Page Header Animation
        setTimeout(function(){
            header.find('[data-animate-in]').each(function () {
                var $this = $(this);
                animateClass = $this.data('animate-in');

                $this.removeClass('invisible').addClass('animated ' + animateClass);
            })
        }, 300);

        // Animation when Slide Appear
        function animateSlide() {
            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
                var $this = $(this);
                animateClass = $this.data('animate-in');
                $this.addClass(animateClass);
            });
            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
                var $this = $(this);
                animateClass = $this.data('animate-out');
                $this.removeClass(animateClass);
            });
        }

        // Animation when Slide Disappear
        function animateSlideEnd() {
            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
                var $this = $(this);
                animateClass = $this.data('animate-in');
                $this.removeClass(animateClass)
            });
            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
                var $this = $(this);
                animateClass = $this.data('animate-out');
                $this.addClass(animateClass);
            });
        }

        // Slide Description Right Angle
        function slideDescAngle() {
            slider.find('.active .page-desc').each(function () {
                var $this = $(this),
                    height = $this.outerHeight();
                $this.children('.angle').css('border-top-width', height);
            })
        }

        // Slider Controls Position
        function sliderControls() {
            slider.find('.active .page-title, .active .entry-content p:last-child').each(function () {
                var $this = $(this),
                    offset = $this.offset().top - slider.offset().top + $this.height();
                slider.find('.carousel-indicators').css('top', offset + 30);
                if (screenRes < 992) {
                    slider.find('.carousel-indicators').css('top', offset + 10);
                }
            })
        }

        sliderControls();
        slideDescAngle();
        animateSlide();

        slider.on('slid.bs.carousel', function () {
            sliderControls();
            slideDescAngle();
            animateSlide();
        });
        slider.on('slide.bs.carousel', function () {
            animateSlideEnd();
        });
        $(window).on('resize', function () {
            sliderControls();
            slideDescAngle();
        });

        if (Modernizr.touch) {
            slider.find('.carousel-inner').swipe( {
                swipeLeft: function() {
                    $(this).parent().carousel('prev');
                },
                swipeRight: function() {
                    $(this).parent().carousel('next');
                },
                threshold: 30
            })
        }
    };

    $('#testimage').load(function() {
        $("#spinner, #testimage").remove();
        $(".main-slider, .site-logo-alt, #menu-call, .page-header, .header, .carousel-control").removeClass('invisible').addClass('animated fadeIn');

        $('#main-slider').carousel({interval: 8000, pause: 'none'});
        $('#workout-slider').carousel({interval: 10000, pause: 'none'});
        $('#main-slider').sliderApi();
        $('#workout-slider').sliderApi();
    });
    $('#post-slider').carousel({interval: 10000, pause: 'none'});
    $('#post-slider').sliderApi();

// Gray Header Animation
    if($('.main-header-gray').length) {
        $(".page-header, .header").removeClass('invisible').addClass('animated fadeIn');
        $('.main-header-gray').find('[data-animate-in]').each(function () {
            var $this = $(this);
            animateClass = $this.data('animate-in');
            $this.removeClass('invisible').addClass('animated ' + animateClass);
        });
    }

// No Header
    if(!$('.main-header').length) {
        $(".page-header, .header").removeClass('invisible').addClass('animated fadeIn');
    }

// Post Slider Dynamic Height
    function sliderHeight() {
        var sliderHeight = $('#post-slider').find('.active').height();
        $('#post-slider').find('.carousel-inner').css('height', sliderHeight);
    }

    sliderHeight();

    $('#post-slider').on('slid.bs.carousel', function () {
        sliderHeight();
    });
    $(window).on('resize', function () {
        sliderHeight();
    });

// Mobile Menu (SlickNav)
    $('#primary-navigation').children('ul').first().slicknav({parentTag: 'div'});
    $('.slicknav_nav').children('.mega-nav').find('.slicknav_item').removeClass('slicknav_item');

// Main Menu
    $(".nav-menu").find('ul').addClass('hidden');
    $(".nav-menu").find('.mega-nav-widget').find('ul').removeClass('hidden');
    $(".nav-menu li").not('.mega-nav-widget').has('ul').addClass('parent');

    $(".nav-menu li").hover(function(){
        var $this = $(this),
            dropdown = $this.children('ul');

        if(dropdown.length) {
            dropdown.removeClass().addClass('fadeInDownSmall').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                dropdown.removeClass('fadeInDownSmall hidden');
            });
        }

        // Set Level 1 to the center of parent Item
        if($this.parent().hasClass('nav-menu') && dropdown.length) {
            var menuItemWidth = $this.outerWidth(),
                menuItemOffset = parseInt($this.offset().left, 10),
                submenuItemWidth = dropdown.outerWidth();

            if (menuItemOffset + menuItemWidth/2 + submenuItemWidth/2 > screenRes - 5) {
                //dropdown.css('left' , (menuItemWidth-submenuItemWidth)/2 - (menuItemOffset + menuItemWidth/2 + submenuItemWidth/2 - screenRes));
                dropdown.css('left' , screenRes - submenuItemWidth - menuItemOffset);
            } else {
                dropdown.css('left' , (menuItemWidth-submenuItemWidth)/2);
            }
        }
        // Move Dropdown to the left side of its Parent if it doesn't fit to the screen
        else
        {
            if(($this).hasClass('parent')) {
                var dropdownWidth = dropdown.outerWidth(),
                    dropdownOffset = parseInt(dropdown.offset().left, 10);

                if (dropdownWidth + dropdownOffset > screenRes - 5) {
                    dropdown.addClass('left');
                }
            }
        }

    }, function(){
        var $this = $(this),
            dropdown = $this.children('ul');

        dropdown.removeClass('fadeInDownSmall hidden').addClass('fadeOutUpSmall').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            dropdown.removeClass('fadeOutUpSmall').addClass('hidden');
        })
    });

    // Sticky Menu
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 80) {
            $('.sticky-menu').addClass('sticky')
        } else {
            $('.sticky-menu').removeClass('sticky')
        }

        if ($(window).scrollTop() > 750) {
            $('.sticky-menu').addClass('sticky-scrolled')
        } else {
            $('.sticky-menu').removeClass('sticky-scrolled')
        }
    });

// Calendar Slider
	function calendarInit() {
		$('#calendar-slider').carouFredSel({
			prev: '#calendar-prev',
			next: '#calendar-next',
			auto: {
				play: true,
				timeoutDuration: 5000
			},
			scroll: {
				pauseOnHover: true,
				items: 1,
				duration: 1000,
				easing: 'quadratic'
			}
		})
	}
    if($('#calendar-slider').length) {
        calendarInit();
        $(window).resize(function() {
            calendarInit();
        });
    }

// Categories Slider
	function categoriesInit() {
		$('#categories-slider').carouFredSel({
			prev: '#categories-prev',
			next: '#categories-next',
			auto: {
				play: true,
				timeoutDuration: 5000
			},
			scroll: {
				pauseOnHover: true,
				items: 1,
				duration: 1000,
				easing: 'quadratic'
			}
		})
	}
    if($('#categories-slider').length) {
        categoriesInit();
        $(window).resize(function() {
            categoriesInit();
        });
    }

// BMI Calculator
    $('#bmi-submit').on('click', function(e) {
        e.preventDefault();

        $('#weight, #height-metric, #weight-metric').removeClass('error');

        var bmi =  function() {
            var height, weight, bmiCalc;

            if($('.system-metric').hasClass('hidden')) {
                height = $('#height1').val() * 0.3048 + $('#height2').val() * 0.0254;
                weight = $('#weight').val() * 0.45359237;
            } else {
                height = $('#height-metric').val() / 100;
                weight = $('#weight-metric').val();
            }

            bmiCalc = weight/height/height;
            return bmiCalc;
        };

        if(bmi() && bmi() < 999999) {
            $('#bmi-result').removeClass('exceed');
            if (bmi() < 18.5 || bmi() > 24.9) {
                $('#bmi-result').addClass('exceed')
            }
            $('#bmi-result').text(bmi().toFixed(1));
            $('.bmi-calc [class*="system-"], #bmi-submit').addClass('hidden');
            $('.bmi-calc .bmi-results, #bmi-reset').removeClass('hidden');
        } else {
            $('#weight, #height-metric, #weight-metric').each(function(){
                var $this = $(this);
                if (!$this.val().match(/^\d+$/) || $this.val()==0) {
                    $this.addClass('error')
                }
            });
        }
    });

    $('#bmi-reset').on('click', function(e) {
        e.preventDefault();

        $('.bmi-calc .system-normal, #bmi-submit').removeClass('hidden');
        $('.bmi-calc .bmi-results, #bmi-reset').addClass('hidden');
        $('#weight, #height-metric, #weight-metric').val('').removeClass('error');
        cuSelRefresh({refreshEl: "#height1, #height2", visRows: 6, itemPadding: 14});
    });

    $('.bmi-calc').on('click', '.switch', function(e) {
        e.preventDefault();

        var $this = $(this).parents('[class*="system-"]');

        $('.bmi-calc [class*="system-"]').removeClass('hidden');
        $this.addClass('hidden');
        cuSelRefresh({refreshEl: "#height1, #height2", visRows: 6, itemPadding: 14});

    });

// Workouts Filtering (isotope)
    var isotopeContainer = $('#workoutlist');

	// Add the dummy Item if # of Items are odd
	function getItemsNumber(elem) {
		if (elem.length % 2 == 1) {
			$('.workout-item-dummy').removeClass('hidden').addClass('fadeIn');
		}
	}
	
    if (isotopeContainer.length) {
        isotopeContainer.isotope({
            transitionDuration: '0.4s',
            itemSelector: '.isotope'
        });

        // One of Filters Changed
        $('.field-select').on('change', '#filter-difficulty, #filter-duration, #filter-goal', function() {
            var $this = $(this).attr('id'),
                difficulty =  $('#filter-difficulty').val(),
                duration =  $('#filter-duration').val(),
                goal =  $('#filter-goal').val(),
                search = !difficulty && !duration && !goal ? '*' : function() {
                    var item = $(this),
                        difficultyName = item.data('difficulty') ? item.data('difficulty') : '',
                        durationName = item.data('duration') ? item.data('duration') : '',
                        goalName = item.data('goal') ? item.data('goal') : '';

                    if(difficultyName.match(new RegExp(difficulty)) && durationName.match(new RegExp(duration)) && goalName.match(new RegExp(goal))) {
                        if ($this == 'filter-difficulty') return difficultyName;
                        if ($this == 'filter-duration') return durationName;
                        if ($this == 'filter-goal') return goalName;
                    }
                 };

            $('#workoutlist').isotope({filter : search});

            // Hide 'Nothing Found' Message and the dummy Item
            $('.nothing-found, .workout-item-dummy').removeClass('fadeIn').addClass('hidden');
        });

        var items = isotopeContainer.isotope('getItemElements');
        getItemsNumber(items);

        // 'Nothing Found' Message
        isotopeContainer.isotope( 'on', 'layoutComplete', function( isoInstance, laidOutItems ) {
            setTimeout(function(){
                if (laidOutItems.length) {
                    getItemsNumber(laidOutItems);
                } else {
                    $('.nothing-found').removeClass('hidden').addClass('fadeIn');
                }
            }, 0);
        });
    }

// Exercise Video Height (Youtube, Vimeo)
    function setIframeHeight () {
        $('.postlist-exercises').find('.post-thumbnail').each(function() {
            var $this = $(this),
                iframeHeight = parseInt($this.width()/1.78, 10);

            $this.children('iframe').css('height', iframeHeight);
        })
    }

    setIframeHeight ();
    $(window).resize(function() {
        setIframeHeight ();
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        setIframeHeight ();
    });

// ProgressBars Colors
    $('.progress-wrap').each(function() {
        var $this = $(this),
            level = $this.find('.progress-bar').attr('aria-valuenow');

        if (level > 33 && level < 67) $this.addClass('level-middle');
        if (level > 66) $this.addClass('level-high');
    });

// Rating Stars
    $('.rating-button .tficon-star').hover(
        function() {
            $(this).addClass('over').prevAll().addClass('over');
        }
        , function() {
            $(this).removeClass('over').prevAll().removeClass('over');
        }
    );
    $('.rating-button .tficon-star').on('click', function() {
        var $this = $(this),
            value = $this.data('vote');

        $this.parent().children('.tficon-star').removeClass('voted');
        $this.addClass('voted').prevAll().addClass('voted');
        $this.parents('.rating-button').find('input[type="hidden"]').val(value);
    });

// Smooth Transition to Anchors
    $('.anchor[href^="#"]').on('click', function(e) {
        e.preventDefault();
        var speed = 2,
            boost = 1,
            offset = 60,
            target = $(this).attr('href'),
            currPos = parseInt($(window).scrollTop(), 10),
            targetPos = target!="#" && $(target).length==1 ? parseInt($(target).offset().top, 10)-offset : currPos,
            distance = targetPos-currPos,
            boost2 = Math.abs(distance*boost/1000);
        $("html, body").animate({ scrollTop: targetPos }, parseInt(Math.abs(distance/(speed+boost2)), 10));
    });

// Google Map
    if($('.map').length) {
        $("#map").gMap({
            markers: [{
                latitude: 34.0473765,
                longitude: -118.5427426,
                title: "Company Name LTD",
                html:"<div class='gmap-tooltip'><strong>Company Name HQ</strong><br>Opposite Croma, Road 36, Jubilee Hills, Hyderabad<br>Tel.: 040 658.684.744</div>",
                popup: false,
                icon: {
                    image: 'images/icons/gmap-flag.png',
                    iconsize: [25, 34],
                    iconanchor: [12,34],
                    infowindowanchor: [0, 0]
                }
            }],
            zoom: 15,
            scrollwheel: false
        });

        $('#show-map').on('click', function(e) {
            e.preventDefault();

            if (Modernizr.cssanimations) {
                $(this).parents('.page-header').addClass('fadeOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                    $(this).addClass('hidden')
                });

            } else {
                $(this).parents('.page-header').addClass('hidden');
            }
        });
    }

// Entry Meta
    $('.entry-meta').each(function(index) {
        $(this).children('span').last().addClass('last');
    });

// Post Detail Images
    $('.post-details').find('.entry-image').each(function() {
        var $this = $(this);

        if ($this.prev().hasClass('entry-image') && !$this.prev().hasClass('omega')) {
            $this.addClass('omega');
        }
    });

// Similar Posts
    $('.post-similar').find('a').each(function(index) {
        if (index % 2 == 1) {
            $(this).addClass('omega');
        }
    });

// Video Iframe ratio
    function videoRatio() {
        $('.video').find('iframe').each(function(){
            var $this = $(this),
                iframeAttrWidth = $this.attr('width'),
                iframeAttrHeight = $this.attr('height'),
                iframeWidth = $this.width(),
                iframeHeight = parseInt(iframeAttrHeight*iframeWidth/iframeAttrWidth, 10);

            $this.css('height', iframeHeight);
        });
    }
    videoRatio();
    $(window).on('resize', function () {
        videoRatio();
    });

});