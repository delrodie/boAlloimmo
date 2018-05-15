$(function () {

	var $document = $(document),
		$window = $(window),
		windowWidth = window.innerWidth || $window.width(),
		windowH = $window.height();

	// Template options
	templateOption = {
			mobileMenuBreikpont: 1023,
			stickyHeader: true, // sticky header enable (set 'false' for disable)
			smoothScroll: false, // smooth scroll enable (set 'false' for disable)
			backToTop: true // back to top button enable (set 'false' for disable)
		},

		// Google map options
		googleMapOption = {
			latitude: 59.3,
			longitude: 18.0941403,
			zoom: 14,
			marker: [
			['Best Hotel', 59.3, 18.0941403, 1, 'images/map-marker.png']
		],
			markers: [
			['Object number four', 59.302627, 18.1073223, 4, 'images/map-marker-4.png'],
			['Object number three', 59.305004, 18.0733833, 3, 'images/map-marker-3.png'],
			['Object number two', 59.29383, 18.0814213, 2, 'images/map-marker-2.png'],
			['Object number one', 59.291129, 18.0931024, 1, 'images/map-marker-1.png']
		]
		},

		// Template Blocks
		blocks = {
			mainSlider: $('#mainSlider'),
			servicesCarousel: $('.js-services-carousel'),
			servicesCarousel2: $('.js-services-carousel-sm'),
			roomCarousel: $('.js-room-carousel'),
			specialCarousel: $('.js-special-carousel'),
			reviewsCarousel: $('.js-reviews-carousel'),
			singleCarousel: $('.js-slider-single'),
			instagram: $(".js-instagram"),
			googleMapHeader: 'googleMapHeader',
			googleMapFooter: 'googleMapFooter',
			galleryMain: '.js-slider-gallery-main',
			galleryThumbs: '.js-slider-gallery-thumbs',
			galleryRoomMain: '.js-slider-gallery-room-main',
			galleryRoomThumbs: '.js-slider-gallery-room-thumbs',
			rangeSlider1: $('#rangeSlider1'),
			rangeSlider2: $('#rangeSlider2'),
			isotopeGallery: $('.gallery-isotope')
		};


	// Detect Touch Devices
	window.mobileCheck = function () {
		var i = !1;
		return function (a) {
			(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) && (i = !0)
		}(navigator.userAgent || navigator.vendor || window.opera), i
	};
	var isTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;
	if (isTouch) {
		$('body').addClass('touch');
	}

	// Time Out Resize (Debouncer)
	function debouncer(func, timeout) {
		var timeoutID,
			timeout = timeout || 500;
		return function () {
			var scope = this,
				args = arguments;
			clearTimeout(timeoutID);
			timeoutID = setTimeout(function () {
				func.apply(scope, Array.prototype.slice.call(args));
			}, timeout);
		};
	}

	// Main Slider
	if (blocks.mainSlider.length) {
		var $el = blocks.mainSlider;
		$el.find('.slide').first().find('.img--holder').imagesLoaded({
			background: true
		}, function () {
			setTimeout(function () {
        $el.parent().find('.loading-content').addClass('disable');
			}, 1000);
		})
		$el.on('init', function (e, slick) {
			var $firstAnimatingElements = $('div.slide:first-child').find('[data-animation]');
			doAnimations($firstAnimatingElements);
		});
		$el.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
			var $currentSlide = $('div.slide[data-slick-index="' + nextSlide + '"]');
			var $animatingElements = $currentSlide.find('[data-animation]');
			doAnimations($animatingElements);
		});
		$el.slick({
			arrows: false,
			dots: false,
			autoplay: true,
			autoplaySpeed: 7000,
			fade: true,
			speed: 1000,
			pauseOnHover: false,
			pauseOnDotsHover: true
		});
	}
	// Sticky Elements
	$.fn.stickyEl = function () {
		var $stickyNav;
		var $stickyForm;
		$.fn.stickyEl.init = function () {
			if (windowWidth > 767) {
				if ($('.js-booking-form').length) {
					$stickyForm = new Waypoint.Sticky({
						element: $('.js-booking-form')[0],
						offset: 50
					})
				}
			}
			if (windowWidth > templateOption.mobileMenuBreikpont) {
				if ($('.header-nav').length) {
					$stickyNav = new Waypoint.Sticky({
						element: $('.header-nav')[0],
						offset: 0
					})
				}
			} else {
				if ($('.header-content').length) {
					$stickyNav = new Waypoint.Sticky({
						element: $('.header-content')[0],
						offset: -35
					})
				}
			}
		}
		this.stickyEl.init();
		$.fn.stickyEl.destroy = function () {
			if ($stickyNav) {
				$stickyNav.destroy();
			}
			if ($stickyForm) {
				$stickyForm.destroy();
			}
		}
		$('.js-booking-form-close').on('click', function(e){
			e.preventDefault();
			if ($stickyForm) {
				$stickyForm.destroy();
			}
		})
	}
	
	// Slick Carousels Start
	if (blocks.servicesCarousel2.length) {
		blocks.servicesCarousel2.slick({
			mobileFirst: false,
			slidesToShow: 3,
			slidesToScroll: 1,
			infinite: false,
			arrows: false,
			dots: true,
			autoplay: true,
			autoplaySpeed: 5000,
			speed: 1200,
			pauseOnHover: false,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2
					}
					},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 1
					}
				}]
		});
		blocks.servicesCarousel2.slick('slickPause');
		blocks.servicesCarousel2.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	if (blocks.servicesCarousel.length) {
		blocks.servicesCarousel.slick({
			mobileFirst: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: false,
			arrows: false,
			dots: true,
			autoplay: true,
			autoplaySpeed: 4000,
			speed: 1600,
			pauseOnHover: false
		});
		blocks.servicesCarousel.slick('slickPause');
		blocks.servicesCarousel.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	if (blocks.roomCarousel.length) {
		blocks.roomCarousel.slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 5000,
			speed: 1200,
			arrows: false,
			dots: true,
			pauseOnHover: true,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 1
					}
				}]
		});
		blocks.roomCarousel.slick('slickPause');
		blocks.roomCarousel.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	if (blocks.specialCarousel.length) {
		blocks.specialCarousel.slick({
			mobileFirst: false,
			slidesToShow: 2,
			slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 3500,
			arrows: false,
			dots: true,
			speed: 1500,
			pauseOnHover: false,
			responsive: [
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 1
					}
			}]
		});
		blocks.specialCarousel.slick('slickPause');
		blocks.specialCarousel.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	if (blocks.reviewsCarousel.length) {
		blocks.reviewsCarousel.slick({
			mobileFirst: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: false,
			dots: true,
			speed: 1200
		});
		blocks.reviewsCarousel.slick('slickPause');
		blocks.reviewsCarousel.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	if (blocks.singleCarousel.length) {
		blocks.singleCarousel.slick({
			mobileFirst: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			arrows: true,
			fade: true,
			autoplay: true,
			autoplaySpeed: 3000,
			pauseOnHover: false
		});
		blocks.singleCarousel.slick('slickPause');
		blocks.singleCarousel.waypoint({
			offset: 500,
			handler: function () {
				$(this.element).slick('slickPlay');
				this.destroy();
			}
		});
	}
	// Slick Carousels End

	// Isotope Gallery
	if (blocks.isotopeGallery.length) {
		var $gallery = blocks.isotopeGallery;
		$gallery.imagesLoaded(function () {
			$gallery.isotope({
				itemSelector: '.gallery-item',
				masonry: {
					columnWidth: '.gallery-item',
					gutter: 30
				}
			});
		});
		isotopeFilters($gallery);
		// Image Popup
		blocks.isotopeGallery.find('a.hover').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			}
		});
	}

	// Isotope Filters (for Gallery Page)
	function isotopeFilters(gallery) {
		var $gallery = $(gallery);
		if ($gallery.length) {
			var container = $gallery;
			var optionSets = $(".filters-by-category .option-set"),
				optionLinks = optionSets.find("a");
			optionLinks.on('click', function (e) {
				var thisLink = $(this);
				if (thisLink.hasClass("selected")) return false;
				var optionSet = thisLink.parents(".option-set");
				optionSet.find(".selected").removeClass("selected");
				thisLink.addClass("selected");
				var options = {},
					key = optionSet.attr("data-option-key"),
					value = thisLink.attr("data-option-value");
				value = value === "false" ? false : value;
				options[key] = value;
				if (key === "layoutMode" && typeof changeLayoutMode === "function") changeLayoutMode($this, options);
				else {
					container.isotope(options);
				}
				return false
			})
		}
	}

	// Syncronized Gallery
	function sliderGallery(main, thumbs) {
		$(main).slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			asNavFor: thumbs,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						arrows: false
					}
				}]
		});
		$(thumbs).slick({
			slidesToShow: 6,
			slidesToScroll: 1,
			asNavFor: main,
			centerMode: false,
			focusOnSelect: true,
			infinite: true,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 5,
						arrows: false
					}
					}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 4,
						arrows: false
					}
					},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 3,
						arrows: false
					}
				}]
		});
	}

	// Room Details Page Syncronized Gallery
	function sliderRoomGallery(main, thumbs) {
		$(main).slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			asNavFor: thumbs,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						arrows: false
					}
				}]
		});
		$(thumbs).slick({
			slidesToShow: 5,
			slidesToScroll: 1,
			asNavFor: main,
			centerMode: false,
			focusOnSelect: true,
			infinite: true,
			responsive: [
				{
					breakpoint: 1024,
					settings: {
						slidesToShow: 4,
						arrows: false
					}
					}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 4,
						arrows: false
					}
					},
				{
					breakpoint: 575,
					settings: {
						slidesToShow: 3,
						arrows: false
					}
				}]
		});
	}

	// Instagram Feed
	function instagram(el) {
		var $this = el,
			id = $this.attr('id'),
			token = $this.attr('data-token');
		var newfeed = new Instafeed({
			target: id,
			get: 'user',
			userId: 'self',
			accessToken: token,
			limit: 6,
			resolution: 'standard_resolution',
			sortBy: 'most-recent',
			template: '<a href="{{link}}" target="_blank"><span><img src="{{image}}"/></span><span class="icn"></span></a>'
		});
		newfeed.run();
	}

	// Modal Video Popup
	function videoModal(link) {
		$(link).magnificPopup({
			type: 'iframe',
			removalDelay: 300,
			mainClass: 'mfp-fade'
		});
	};

	// Pause Carousel (hover, modal)
	function pauseCarousel(modal) {
		$(modal).on('show.bs.modal', function (e) {
				$('.paused-slick').slick('slickPause');
			})
		$(document).on('mouseenter', '.slick-slider', function () {
			if($(this).get(0).slick.options.paused){
				$(this).slick('slickPause');
			}
		}).on('mouseleave', '.slick-slider', function () {
			if($(this).get(0).slick.options.autoplay && !$('body').hasClass('modal-open')){
				$(this).slick('slickPlay');
			}
		})
		$('[data-toggle="modal"]').on('click', function (e) {
			blocks.servicesCarousel.slick('slickPause');
			if ($(this).closest('.slick-slider').length) {
				$(this).closest('.slick-slider').addClass('paused-slick');
			}
		})
	}

	// Mobile Menu Modal
	function menuModal(modal) {
		var menu = $('.js-main-menu').clone();
		$('#modalNavigation .modal-dialog').append(menu);
		$(modal).on('shown.bs.modal', function (e) {
			$('body').addClass('menu-open');
		})
		$(modal).on('hide.bs.modal', function (e) {
			$('body').removeClass('menu-open');
		})
	};

	// Booking Form Start
	function bookingForm() {
		bookingFormGuest();
		bookingFormDate(2, '#start-date', '#end-date');
		bookingFormDate(1, '#start-date-m', '#end-date-m');
		bookingFormRoom();
		$('.js-booking-form-toggle').on('click', function () {
			$(this).toggleClass('opened');
			$('.js-booking-form').toggle();
		})
	}

	function bookingFormRoom() {
		$('.popover-2>.trigger').on('click', function (e) {
			e.preventDefault();
			var $this = $(this),
				current = $this.parent('.popover-markup');
			$('.popover-markup').not(current).removeClass('opened');
			$this.parent('.popover-markup').toggleClass('opened');
		});
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.popover-2').length) {
				$('.popover-2.opened').removeClass('opened');
			}
		});
		$(document).on('change', '.popover-2 input[type=radio]', function () {
			var $this = $(this),
				$input = $this.closest('.popover-2').find('.form-control');
			$input.html($this.val());
		})
	}

	function bookingFormGuest() {
		var guests = [1, 1, 0, 1];
		$('.popover-1>.trigger').on('click', function (e) {
			e.preventDefault();
			var $this = $(this),
				current = $this.parent('.popover-markup');
			$('.popover-markup').not(current).removeClass('opened');
			if ($this.parent('.popover-markup').hasClass('opened')) {
				$this.parent('.popover-markup').removeClass('opened');
				$this.parent('.popover-markup').find('.popover-content input').each(function (i) {
					guests[i] = $(this).val();
				});
			} else {
				$this.parent('.popover-markup').addClass('opened');
				$this.parent('.popover-markup').find('.popover-content input').each(function (i) {
					$(this).val(guests[i]);
				});
			}
		});
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.popover-1').length) {
				$('.popover-1.opened').removeClass('opened');
			}
		});
		$(document).on('click', '.number-spinner a', function () {
			var btn = $(this),
				$target = $('#' + btn.closest('.number-spinner').data('val')),
				input = btn.closest('.number-spinner').find('input'),
				total = $target.html(),
				oldValue = parseInt(input.val(), 10);
			if (btn.attr('data-dir') == 'up') {
				if (oldValue < input.attr('data-max')) {
					oldValue++;
					total++;
				}
			} else {
				if (oldValue > input.attr('data-min')) {
					oldValue--;
					total--;
				}
			}
			$target.html(total);
			input.val(oldValue);
		});
	}

	function bookingFormDate(numberOfMonths, startId, endId) {
		var start_date = null,
			end_date = null;
		var timestamp_start_date = null,
			timestamp_end_date = null;
		var $input_start_date = null,
			$input_end_date = null;
		var numberOfMonths = numberOfMonths;

		function getDateClass(date, start, end) {
			if (end != null && start != null) {
				if (date > start && date < end)
					return [true, "", ""];
			}
			if (date == start) return [true, "", ""];
			if (date == end) return [true, "", ""];
			return false;
		}

		function datepicker_draw_nb_nights() {
			var $datepicker = jQuery("#ui-datepicker-div");
			setTimeout(function () {
				if (start_date != null && end_date != null) {
					var $qty_days_stay = jQuery("<div />", {
						class: "ui-datepicker-stay-duration"
					});
					var qty_nights_stay = get_days_difference(timestamp_start_date, timestamp_end_date);
					$qty_days_stay.text(qty_nights_stay + " nights stay");
					$qty_days_stay.appendTo($datepicker);
				}
			});
		}
		var options_start_date = {
			showAnim: false,
			constrainInput: true,
			numberOfMonths: numberOfMonths,
			showOtherMonths: true,
			beforeShow: function (input, datepicker) {
				datepicker_draw_nb_nights();
			},
			beforeShowDay: function (date) {
				var timestamp_date = date.getTime();
				var result = getDateClass(timestamp_date, timestamp_start_date, timestamp_end_date);
				if (result != false) return result;
				return [true, "", ""];
			},
			onSelect: function (date_string, datepicker) {
				start_date = $input_start_date.datepicker("getDate");
				timestamp_start_date = start_date.getTime();
			},
			onClose: function () {
				if (end_date != null) {
					if (timestamp_start_date >= timestamp_end_date || end_date == null) {
						$input_end_date.datepicker("setDate", null);
						end_date = null;
						timestamp_end_date = null;
						$input_end_date.datepicker("show");
						return;
					}
				}
				if (start_date != null && end_date == null)
					$input_end_date.datepicker("show");
			}
		};
		var options_end_date = {
			showAnim: false,
			constrainInput: true,
			numberOfMonths: numberOfMonths,
			showOtherMonths: true,
			beforeShow: function (input, datepicker) {
				datepicker_draw_nb_nights();
			},
			beforeShowDay: function (date) {
				var timestamp_date = date.getTime();
				var result = getDateClass(timestamp_date, timestamp_start_date, timestamp_end_date);
				if (result != false) return result;
				return [true, "", ""];
			},
			onSelect: function (date_string, datepicker) {
				end_date = $input_end_date.datepicker("getDate");
				timestamp_end_date = end_date.getTime();
			},
			onClose: function () {
				if (end_date == null)
					return;
				if (timestamp_end_date <= timestamp_start_date || start_date == null) {
					$input_start_date.datepicker("setDate", null);
					start_date = null;
					timestamp_start_date = null;
					$input_start_date.datepicker("show");
				}
			}
		};
		$input_start_date = $(startId);
		$input_end_date = $(endId);

		$input_start_date.datepicker(options_start_date);
		$input_end_date.datepicker(options_end_date);

		function get_days_difference(start_date, end_date) {
			return Math.floor(end_date - start_date) / (1000 * 60 * 60 * 24);
		}
	}
	// END Booking Form

	// DatePicker
	function datePicker(datepicker) {
		$(datepicker).datepicker({
			beforeShow: function () {
				if (!$('.datepicker-wrapper').length) {
					$('#ui-datepicker-div').wrap('<span class="datepicker-wrapper"></span>');
					$('.dropdown.show').addClass('keep-open');
				}
			}
		});
		$(document).on('hide.bs.dropdown', function (e) {
			if ($('#ui-datepicker-div').is(':visible')) {
				return false;
			}
		});
	}
	
	function datePickerM(datepicker) {
		$(datepicker).datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'MM yy',
			beforeShow: function () {
				$('#ui-datepicker-div').wrap('<span class="datepicker-wrapper datepicker-onlymonth"></span>');
			},
			onClose: function(dateText, inst) {
				$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			}
		});
	}
	
	function toggleReview(link, review) {
		var $review = $(review);
		$(link).on('click', function (e) {
			e.preventDefault();
			$(this).toggleClass('opened');
			$review.css({'height': $review[0].scrollHeight}).toggleClass('opened');
		})
	}

	// Close DropMenu Button
	function closeDrop(button) {
		$(button).on('click', function (e) {
			$(this).closest('.dropdown').find('.dropdown-toggle').trigger('click');
			e.preventDefault();
		})
	}

	// Back To Top
	function backToTop(button, flag) {
		if (flag) {
			var $button = $(button);
			$(window).on('scroll', function () {
				if ($(this).scrollTop() >= 500) {
					$button.addClass('visible');
				} else {
					$button.removeClass('visible');
				}
			});
			$button.on('click', function () {
				$('body,html').animate({
					scrollTop: 0
				}, 1000);
			});
		} else {
			$(button).hide();
		}
	}

	// Slider Animation
	function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
			if ($this.hasClass('animate')) {
				$this.removeClass('animation');
			}
		});
	}


	// Text Truncate
	function trunkText(el) {
		$(el).each(function () {
			var $this = $(this),
				lines = 10;
			if ($this.data('trunk')) {
				lines = $this.data('trunk')
			}
			if ($this.data('lg-trunk')) {
				lines = (windowWidth > 1024) ? $this.data('lg-trunk') : $this.data('md-trunk');
			}
			$this.trunk8({
				lines: lines
			});
		})
	}

	// Sidebar Filters
	function sidebarFilters() {
		$(".filters-slide-inside").mCustomScrollbar({
			theme: "minimal"
		});
		$('.js-sidebar-close').on('click', function (e) {
			e.preventDefault();
			$('.js-sidebar').removeClass('active');
			$('.overlay').fadeOut();
		});
		$('.js-sidebar-toggle').on('click', function (e) {
			e.preventDefault();
			$('.js-sidebar').addClass('active');
			$('.overlay').fadeIn();
		});
	}

	// Range Slider
	if (blocks.rangeSlider1.length) {
		var rangeSlider1 = document.getElementById('rangeSlider1');
		noUiSlider.create(rangeSlider1, {
			start: [100, 2000],
			connect: true,
			step: 50,
			padding: 100,
			range: {
				'min': 0,
				'max': 3100
			}
		});
		var number1_1 = document.getElementById('number-1-1');
		var number1_2 = document.getElementById('number-1-2');
		rangeSlider1.noUiSlider.on('update', function (values, handle) {
			var value = values[handle];
			if (handle) {
				number1_1.textContent = Math.round(value);
			} else {
				number1_2.textContent = Math.round(value);
			}
		});
		number1_1.addEventListener('change', function () {
			rangeSlider1.noUiSlider.set([this.textContent, null]);
		});
		number1_2.addEventListener('change', function () {
			rangeSlider1.noUiSlider.set([null, this.textContent]);
		});
	}
	if (blocks.rangeSlider2.length) {
		var rangeSlider2 = document.getElementById('rangeSlider2');
		noUiSlider.create(rangeSlider2, {
			start: [0, 120],
			connect: true,
			step: 10,
			padding: 10,
			range: {
				'min': 0,
				'max': 310
			}
		});
		var number2_1 = document.getElementById('number-2-1');
		var number2_2 = document.getElementById('number-2-2');
		rangeSlider2.noUiSlider.on('update', function (values, handle) {
			var value = values[handle];
			if (handle) {
				number2_1.textContent = Math.round(value);
			} else {
				number2_2.textContent = Math.round(value);
			}
		});
		number2_1.addEventListener('change', function () {
			rangeSlider2.noUiSlider.set([this.textContent, null]);
		});
		number2_2.addEventListener('change', function () {
			rangeSlider2.noUiSlider.set([null, this.textContent]);
		});
	}

	// Google Map Start
	var mapStyle = [{
		featureType: "water",
		elementType: "geometry",
		stylers: [{
			color: "#e9e9e9"
		}, {
			lightness: 17
		}]
	}, {
		featureType: "landscape",
		elementType: "geometry",
		stylers: [{
			color: "#f5f5f5"
		}, {
			lightness: 20
		}]
	}, {
		featureType: "road.highway",
		elementType: "geometry.fill",
		stylers: [{
			color: "#ffffff"
		}, {
			lightness: 17
		}]
	}, {
		featureType: "road.highway",
		elementType: "geometry.stroke",
		stylers: [{
			color: "#ffffff"
		}, {
			lightness: 29
		}, {
			weight: 0.2
		}]
	}, {
		featureType: "road.arterial",
		elementType: "geometry",
		stylers: [{
			color: "#ffffff"
		}, {
			lightness: 18
		}]
	}, {
		featureType: "road.local",
		elementType: "geometry",
		stylers: [{
			color: "#ffffff"
		}, {
			lightness: 16
		}]
	}, {
		featureType: "poi",
		elementType: "geometry",
		stylers: [{
			color: "#f5f5f5"
		}, {
			lightness: 21
		}]
	}, {
		featureType: "poi.park",
		elementType: "geometry",
		stylers: [{
			color: "#dedede"
		}, {
			lightness: 21
		}]
	}, {
		elementType: "labels.text.stroke",
		stylers: [{
			visibility: "on"
		}, {
			color: "#ffffff"
		}, {
			lightness: 16
		}]
	}, {
		elementType: "labels.text.fill",
		stylers: [{
			saturation: 36
		}, {
			color: "#333333"
		}, {
			lightness: 40
		}]
	}, {
		elementType: "labels.icon",
		stylers: [{
			visibility: "off"
		}]
	}, {
		featureType: "transit",
		elementType: "geometry",
		stylers: [{
			color: "#f2f2f2"
		}, {
			lightness: 19
		}]
	}, {
		featureType: "administrative",
		elementType: "geometry.fill",
		stylers: [{
			color: "#fefefe"
		}, {
			lightness: 20
		}]
	}, {
		featureType: "administrative",
		elementType: "geometry.stroke",
		stylers: [{
			color: "#fefefe"
		}, {
			lightness: 17
		}, {
			weight: 1.2
		}]
	}];

	function createMapHeader(id, mapZoom, lat, lng, markers) {
		var mapOptions = {
			zoom: mapZoom,
			scrollwheel: false,
			center: new google.maps.LatLng(lat, lng),
			styles: mapStyle
		};
		var mapHeader = new google.maps.Map(document.getElementById(id), mapOptions);
		var count,
			locations = markers;
		for (count = 0; count < locations.length; count++) {
			new google.maps.Marker({
				position: new google.maps.LatLng(locations[count][1], locations[count][2]),
				map: mapHeader,
				title: locations[count][0],
				icon: locations[count][4]
			});
		}
	}

	function createMapFooter(id, mapZoom, lat, lng, markers) {
		var mapOptions = {
			zoom: mapZoom,
			scrollwheel: false,
			center: new google.maps.LatLng(lat, lng),
			styles: mapStyle
		};
		var mapFooter = new google.maps.Map(document.getElementById(id), mapOptions);
		var count,
			locations = markers;
		for (count = 0; count < locations.length; count++) {
			new google.maps.Marker({
				position: new google.maps.LatLng(locations[count][1], locations[count][2]),
				map: mapFooter,
				title: locations[count][0],
				icon: locations[count][4]
			});
		}
	}

	function footerMap(el, map) {
		var $map = map;
		$(el).on('click', function (e) {
			e.preventDefault();
			$(this).toggleClass('opened');
			$map.toggleClass('opened');
		})
	}
	// Google Map End

	// Mobile Slide Info
	function mobileHeaderSlider(button) {
		var button = button;
		$(button).on('click', function () {
			var $topline = $('.header-topline'),
				$this = $(this),
				$slide = $('.' + $this.data('slide'));
			if (!$this.hasClass('active')) {
				$(button).removeClass('active');
				$this.addClass('active');
				$topline.addClass('active');
				$('.header-mobile-slide').not('.' + $this.data('slide')).removeClass('opened');
				$slide.addClass('opened');
			} else {
				$this.removeClass('active');
				$topline.removeClass('active');
				$('.header-mobile-slide').removeClass('opened');
			}
		})
	}

	// Header Catalog Widget
	function catalogToggle(button) {
		$(button).on('click', function () {
			$(this).closest('.catalog-widget').toggleClass('opened');
		})
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.catalog-widget').length) {
				$('.catalog-widget').removeClass('opened');
			}
		});
	}
	// Popover HTML Content
	function popoverHtml(popover) {
		$(popover).each(function (i, obj) {
			$(this).popover({
				html: true,
				content: function () {
					return $(this).next('.popover-content').html();
				}
			});
		});
	}
	// background image inline
	function dataBg(el) {
		$(el).each(function () {
			var $this = $(this),
				bg = $this.attr('data-bg');
			$this.css({
				'background-image': 'url(' + bg + ')'
			});
		});
	}
	// slider expand buttons
	function expandBut(button) {
		var button = button;
		$(button).on('click', function(){
			if($('body').hasClass('touch')){
				$('.expand-btn').not(this).removeClass('hovered');
				$(this).toggleClass('hovered');
			}
		});
		$(button).on('mouseenter', function(){
			if(!$('body').hasClass('touch')){
				$(this).addClass('hovered');
			}
		}).on('mouseleave', function(){
			if(!$('body').hasClass('touch')){
				$(this).removeClass('hovered');
			}
		});
		$(document).on('click', function (e) {
			if (!$(e.target).closest(button).length) {
				$(button).removeClass('hovered');
			}
		});
	}
	//scroll to ahchor
	function scrollTo() {
		$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').not('[data-toggle]').on('click', function (event) {
			if (
				location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
				location.hostname == this.hostname
			) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top - 130
					}, 1000);
				}
				if (target.attr('id') == 'googleMapFooter') {
					$('.js-footer-map-toggle').trigger('click');
				}
			}
		});
	}
	
	// Functions Initializations
	$(document).stickyEl();
	bookingForm();
	sidebarFilters();
	trunkText('.trunk');
	videoModal('.js-video-btn');
	menuModal('#modalNavigation');
	pauseCarousel('.modal');
	mobileHeaderSlider('[data-slide]');
	datePicker('.datepicker:not(.datepicker-month)');
	datePickerM('.datepicker-month');
	closeDrop('.js-drop-close');
	catalogToggle('.js-catalog-widget-toggle');
	backToTop('.js-backToTop', templateOption.backToTop);
	scrollTo();
	popoverHtml('[data-toggle=popover]');
	dataBg('[data-bg]');
	expandBut('.expand-btn');
	toggleReview('.js-toggle-reviewform', '.js-review-form-wrap');
	$('[data-toggle=tooltip]').tooltip();
	if (templateOption.smoothScroll) {
		$('html').scrollWithEase();
	}
	if ($(blocks.galleryMain.length) && $(blocks.galleryThumbs.length)) {
		sliderGallery(blocks.galleryMain, blocks.galleryThumbs);
	}
	if ($(blocks.galleryRoomMain.length) && $(blocks.galleryRoomThumbs.length)) {
		sliderRoomGallery(blocks.galleryRoomMain, blocks.galleryRoomThumbs);
	}
	if (blocks.instagram.length) {
		instagram(blocks.instagram)
	}
	if (blocks.googleMapHeader.length) {
		createMapHeader(blocks.googleMapHeader, googleMapOption.zoom, googleMapOption.latitude, googleMapOption.longitude, googleMapOption.marker);
	}
	if (blocks.googleMapFooter.length) {
		footerMap('.js-footer-map-toggle', $('#' + blocks.googleMapFooter));
		createMapFooter(blocks.googleMapFooter, googleMapOption.zoom, googleMapOption.latitude, googleMapOption.longitude, googleMapOption.markers);
	}
	// Resize Window Events
	$(window).resize(debouncer(function (e) {
		windowWidth = window.innerWidth || $window.width();
		$(document).stickyEl.destroy();
		$(document).stickyEl.init();
		bookingFormDate();
		trunkText('.trunk')
	}));

})