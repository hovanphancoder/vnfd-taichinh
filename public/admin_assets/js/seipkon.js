/*=========================================================================================
[Seipkon Javascript]

Project	     : Seipkon - Responsive Admin Template
Author       : Hassan Rasu
Author URL   : https://themeforest.net/user/themescare
Version      : 1.0
Primary use  : Seipkon - Responsive Admin Template

Should be included in all HTML pages.

==========================================================================================*/


(function ($) {
	"use strict";

	jQuery(document).ready(function ($) {


		/* 
		=================================================================
		Sidebar Menu JS
		=================================================================	
		*/

		$("#sidebar").perfectScrollbar();

		$('#sidebarCollapse').on('click', function () {
			$('#sidebar, #content').toggleClass('active');
			$('.collapse.open').toggleClass('open');
			$('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});

		/* 
		=================================================================
		Perfect Scroller JS
		=================================================================	
		*/

		$(".notification-body, .message-body, .chat-list").perfectScrollbar();


		/* 
        =================================================================
        Tooltip JS
        =================================================================	
        */

		$('[data-toggle="tooltip"]').tooltip();


		/* 
		=================================================================
		Fullscreen JS
		=================================================================	
		*/

		$("#fullscreen-button").on("click", function toggleFullScreen() {
			if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
				if (document.documentElement.requestFullScreen) {
					document.documentElement.requestFullScreen();
				} else if (document.documentElement.mozRequestFullScreen) {
					document.documentElement.mozRequestFullScreen();
				} else if (document.documentElement.webkitRequestFullScreen) {
					document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
				} else if (document.documentElement.msRequestFullscreen) {
					document.documentElement.msRequestFullscreen();
				}
			} else {
				if (document.cancelFullScreen) {
					document.cancelFullScreen();
				} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
				} else if (document.webkitCancelFullScreen) {
					document.webkitCancelFullScreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			}
		});

		/* 
		=================================================================
		Checkbox Toogle JS
		=================================================================	
		*/

		$(".parent").each(function (index) {
			var group = $(this).data("group");
			var parent = $(this);

			parent.change(function () { //"select all" change 
				$(group).prop('checked', parent.prop("checked"));
			});
			$(group).change(function () {
				parent.prop('checked', false);
				if ($(group + ':checked').length == $(group).length) {
					parent.prop('checked', true);
				}
			});
		});

		/* 
		=================================================================
		Mail Important JS
		=================================================================	
		*/

		if ($('.mail-important').length > 0) {
			$(".mail-important").click(function () {
				$(this).find('i.fa').toggleClass("fa-star");
				$(this).find('i.fa').toggleClass("fa-star-o");
			});
		};


		/* 
		=================================================================
		Tooltip Popover JS
		=================================================================	
		*/

		$('[data-toggle="popover"]').popover();


	});


	/*====  Window Load Function =====*/
	jQuery(window).on('load', function () {
		/* 
		=================================================================
		Page Loader JS
		=================================================================	
		*/
		setTimeout(function () {
			$('body').addClass('loaded');
		}, 500);
	});
	
	// function map(arr, fn) {
        // var res = [], i;
        // for (i = 0; i < arr.length; ++i) {
            // res.push(fn(arr[i], i));
        // }
        // return res;
    // }
	

}(jQuery));
function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}


// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			var $this = $(this);
			var $dropdown = $('<ul class="dropdown-menu" />');
			
			this.timer = null;
			this.items = [];

			$.extend(this, option);

			$this.attr('autocomplete', 'off');

			// Focus
			$this.on('focus', function() {
				this.request();
			});

			// Blur
			$this.on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$this.on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				var value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $this.position();

				$dropdown.css({
					top: pos.top + $this.outerHeight(),
					left: pos.left
				});

				$dropdown.show();
			}

			// Hide
			this.hide = function() {
				$dropdown.hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				var html = '';
				var category = {};
				var name;
				var i = 0, j = 0;

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						// update element items
						this.items[json[i]['id']] = json[i];

						if (!json[i]['category']) {
							// ungrouped items
							html += '<li data-value="' + json[i]['id'] + '"><a href="#">' + json[i]['name'] + '</a></li>';
						} else {
							// grouped items
							name = json[i]['category'];
							if (!category[name]) {
								category[name] = [];
							}

							category[name].push(json[i]);
						}
					}

					for (name in category) {
						html += '<li class="dropdown-header">' + name + '</li>';

						for (j = 0; j < category[name].length; j++) {
							html += '<li data-value="' + category[name][j]['id'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['name'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$dropdown.html(html);
			}

			$dropdown.on('click', '> li > a', $.proxy(this.click, this));
			$this.after($dropdown);
		});
	}
})(window.jQuery);

