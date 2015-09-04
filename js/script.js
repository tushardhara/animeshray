( function( $ ) {

	window.thb_ristorante_urlencode = function(str) {
		str = (str + '')
	    	.toString();

	  return encodeURIComponent(str)
	    .replace(/!/g, '%21')
	    .replace(/'/g, '%27')
	    .replace(/\(/g, '%28')
	    .
	  replace(/\)/g, '%29')
	    .replace(/\*/g, '%2A')
	    .replace(/%20/g, '+');
	};

	window.THB_SuperbaTemplate = function( template, data ) {
		return _.template(
			template,
			data,
			{
				evaluate:    /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape:      /\{\{([^\}]+?)\}\}(?!\})/g
			}
		);
	};

	window.thb_isotope_styleAdjust = function() {};

	/**
	 * Run carousels and slideshows on desktop and ipad only
	 */
	window.thb_gallery_script_check = function() {
		return ! $.thb.wp.is_body_class( "thb-gallery-modal-disabled" );
	};

	/**
	 * Gallery item details toggle
	 */
	$( document ).on( "click", ".thb-gallery-item-details-toggle", function() {
		var parent = $( this ).parent(),
			wrapper = $( ".thb-gallery-item-details-wrapper", parent );

		wrapper.toggle();

		if ( $( "#thb-grid-gallery-container" ).length ) {
			$( "#thb-grid-gallery-container" ).data( "THB_Isotope" ).refresh();
		}

		return false;
	} );

	/**
	 * iPhoto-like mode
	 */
	window.thb_boot_slideviews = function( root ) {
		$( ".thb-has-slideview", root ).each( function() {
			if ( $( ".slideview", this ).hasClass( "slideview_added" ) ) {
				return;
			}

			var images = [];

			if ( $( ".slideview", this ).length ) {
				var data_images = $( ".slideview", this ).data( "images" );

				if ( data_images && data_images != "" ) {
					images = data_images.split( "," );
				}
			}

			if ( images.length ) {
				// var images = $( ".slideview", this ).data( "images" ).split( "," );

				$( this ).iskip( {
					images: images,
					method: 'mousemove',
					'cycle': 1,
					img: $( ".slideview", this )
				} );

				$( ".slideview", this ).addClass( "slideview_added" );
			}
		} );
	};

	window.thb_boot_slideviews();

	window.thb_convertToSlug = function( Text )
	{
		return Text
			.toLowerCase()
			.replace(/ /g,'-')
			.replace(/[^\w-]+/g,'');
	};

	/**
	 * FitVids
	 */
	$(".thb-text, .textwidget, .work-slides-container, .format-embed-wrapper, .thb-section-block-thb_video-video-holder").fitVids();

	/**
	 * Gallery details modal
	 */
	window.THB_GalleryDetails = function( data ) {
		var self = this;
		this.counter = 0;
		this.modal = null;
		this.modal_image = null;
		this.modal_details = null;
		this.callback = {
			next: function() {},
			prev: function() {},
		};

		if ( typeof gallery_pace !== 'undefined' ) {
			data = data.slice(
				0,
				( parseInt( gallery_pace.current_page, 10 ) + 1 ) * parseInt( gallery_pace.pace, 10 )
			);
		}

		this.bind = function() {
			$.thb.key( "esc", function() {
				if ( ! thb_is_fullscreen() ) {
					return self.close();
				}
				return true;
			}, null, "thb-gallery-modal" );

			if ( $( "body.thb-mobile" ).length ) {
				self.hammertime = new Hammer( $( "body" ).get( 0 ) );

				self.hammertime.on( "panend", function( ev ) {
					if ( ev.direction == 4 ) {
						return self.prev();
					}
					else if ( ev.direction == 2 ) {
						return self.next();
					}
				} );
			}

			$.thb.key( "right", function() {
				return self.next();
			}, null, "thb-gallery-modal" );

			$.thb.key( "left", function() {
				return self.prev();
			}, null, "thb-gallery-modal" );

			$( document ).on( "click.thb-gallery-modal", ".thb-image-container", function() {
				return self.next();
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-next", function() {
				return self.next();
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-prev", function() {
				return self.prev();
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-close", function() {
				return self.close();
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-fullscreen", function() {
				return self.fullscreen();
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-trigger", function() {
				if ( $( "body" ).hasClass( "thb-gallery-details-open" ) ) {
					$( this ).text( $( this ).data( "text" ) );
				}
				else {
					$( this ).text( $( this ).data( "alt-text" ) );
				}

				$( "body" ).toggleClass( "thb-gallery-details-open" );
				return false;
			} );

			$( document ).on( "click.thb-gallery-modal", ".thb-gallery-details-exif-container-trigger", function() {
				$( ".thb-details-container" ).toggleClass( "thb-gallery-details-exif-open" );
				return false;
			} );
		};

		this.open = function( index, callback ) {
			if ( index === undefined ) {
				index = 0;
			}

			if ( callback && callback.next ) {
				this.callback.next = callback.next;
			}

			if ( callback && callback.prev ) {
				this.callback.prev = callback.prev;
			}

			this.close();

			this.modal = $( "<div id='thb-gallery-details-modal' />" );

			this.modal_details_container = $( '<div class="thb-gallery-details-inner" />' );
			this.modal_controls = $( '<div class="thb-gallery-controls" />' );
			this.modal_duplicated_controls = $( '<div class="thb-gallery-duplicated-controls" />' );

			this.modal_details_container.appendTo( this.modal );
			this.modal_controls.appendTo( this.modal_details_container );

			$( '<a class="thb-gallery-details-close" title="' + gallery_translation.close + '" href="#"></a>' ).appendTo( this.modal_controls );
			if ( thb_fullscreen_check() ) {
				$( '<a class="thb-gallery-details-fullscreen" title="' + gallery_translation.fullscreen + '" href="#"></a>' ).appendTo( this.modal_controls );
			}
			$( '<a class="thb-gallery-details-trigger" title="' + gallery_translation.details + '" href="#"></a>' ).appendTo( this.modal_controls );

			this.modal_duplicated_controls.appendTo( this.modal_details_container );
			$( '<a class="thb-gallery-details-close" title="' + gallery_translation.close + '" href="#"></a>' ).appendTo( this.modal_duplicated_controls );
			$( '<a class="thb-gallery-details-trigger" title="' + gallery_translation.details_close + '" href="#"></a>' ).appendTo( this.modal_duplicated_controls );
			if ( thb_fullscreen_check() ) {
				$( '<a class="thb-gallery-details-fullscreen" title="' + gallery_translation.fullscreen + '" href="#"></a>' ).appendTo( this.modal_duplicated_controls );
			}

			$( '<div class="thb-gallery-counter-nav"><a class="thb-gallery-details-prev" href=""></a><div><p><em>1</em> / <span>2</span></p></div><a class="thb-gallery-details-next" href=""></a></div>' ).appendTo( this.modal_details_container );

			this.modal.appendTo( $( "body" ) );

			if ( $( "body" ).hasClass( "thb-is-gallery-modal-details-opened" ) ) {
				$( "body" ).addClass( "thb-gallery-details-open" );
			}

			$( "body" ).addClass( "thb-gallery-details-modal-open" );

			this.counter = index;
			this.loading = false;
			this.bind();

			this.modal.addClass( "thb-loading" );

			if ( this.counter == 0 ) {
				$( "#thb-gallery-details-modal .thb-gallery-details-prev" ).addClass( "thb-inactive" );
			}
			else if ( this.counter == data.length - 1 ) {
				$( "#thb-gallery-details-modal .thb-gallery-details-next" ).addClass( "thb-inactive" );
			}

			setTimeout( function() {
				self.load();
			}, 5 );
		};

		this.close = function() {
			if ( thb_is_fullscreen() ) {
				thb_exit_fullscreen();
			}
			else {
				if ( this.modal ) {
					this.modal.remove();
				}

				$( "body" ).removeClass( "thb-gallery-details-modal-open" );
				$( "body" ).removeClass( "thb-gallery-details-open" );
				$( ".thb-details-container" ).removeClass( "thb-gallery-details-exif-open" );
				this.counter = 0;
				$( window ).off( ".thb-gallery-modal" );
				$( document ).off( ".thb-gallery-modal" );

				if ( this.hammertime ) {
					this.hammertime.destroy();
				}
			}

			return false;
		};

		this.fullscreen = function() {
			thb_go_fullscreen( this.modal );
			return false;
		};

		this.load = function() {
			var self = this;

			var item = $.extend( {}, {
				type: "image",
				image: "",
				title: "",
				id: 0,
				link: "",
				description: "",
				project_name: "",
				project_url: "",
				exif: {},
				classes: "",
				total_images: data.length,
				index: this.counter + 1
			}, data[this.counter] );

			$( ".thb-details-container" ).removeClass( "thb-gallery-details-exif-open" );
			this.loading = true;

			this.modal.find( ".thb-image-container" ).remove();
			this.modal.find( ".thb-details-container" ).remove();
			this.modal.find( ".thb-gallery-counter-nav em" ).text( this.counter + 1 );
			this.modal.find( ".thb-gallery-counter-nav span" ).text( data.length );

			self.modal.addClass( "thb-loading" );

			setTimeout( function() {
				if ( item.type == 'embed' ) {
					var url = item.id,
						code = "";

					if ( url.indexOf( "?" ) != -1 ) {
						// YouTube
						url = url.split( "?" );

						if ( url[1] && url[1] != "" ) {
							var query = $.parseParams( url[1] );
							code = query["v"] ? query["v"] : "";

							item.image = '<iframe src="//www.youtube.com/embed/' + code + '?modestbranding&showinfo=0" frameborder="0"></iframe>';
						}
					}
					else {
						// Vimeo
						url = url.replace( /\/$/, "" );
						url = url.split( "/" );
						code = url[url.length - 1];

						item.image = '<iframe src="//player.vimeo.com/video/' + code + '?badge=0&byline=0&title=0&color=fff" frameborder="0"></iframe>';
					}
				}

				var template_image_src = $( "[data-tpl='thb-gallery-details']" ).html(),
					template_data_src = $( "[data-tpl='thb-gallery-details-data']" ).html();
					// template_image = _.template( template_image_src ),
					// template_data = _.template( template_data_src );

				if ( item.title == '' && item.description == '' && item.project_url == '' && item.exif != '' ) {
					item.classes = 'thb-gallery-details-exif-open';
				}

				var slide_image = $( window.THB_SuperbaTemplate( template_image_src, item ) ).outerHTML();
				var slide_data = $( $( window.THB_SuperbaTemplate( template_data_src, item ) ).outerHTML() ).html();

				// var slide_image = $( template_image( item ) ).outerHTML();
				// var slide_data = $( $( template_data( item ) ).outerHTML() ).html();

				self.modal.append( slide_image );
				self.modal_details_container.append( slide_data );

				var ctn = $( $( slide_data ).outerHTML() ).wrap( '<div></div>' ).parent();

				if ( slide_data.trim() == "" || ! $( ".thb-details-container", ctn ).children().length ) {
					$( ".thb-gallery-details-trigger", self.modal ).addClass( "thb-inactive" );
				}
				else {
					$( ".thb-gallery-details-trigger", self.modal ).removeClass( "thb-inactive" );
				}

				if ( self.counter > 0 ) {
					// Preloading the previous image
					var previous_image = data[self.counter - 1].image,
						img = $( "<img src='" + previous_image + "' />" );

					$.thb.loadImage( img );
				}

				if ( self.counter < data.length - 1 ) {
					// Preloading the next image
					var next_image = data[self.counter + 1].image,
						img = $( "<img src='" + next_image + "' />" );

					$.thb.loadImage( img );
				}

				self.modal.imagesLoaded( function() {
					setTimeout( function() {
						self.modal.removeClass( "thb-loading" );
					}, 75 );
					self.loading = false;
				} );
			}, 75 );
		};

		this.next = function() {
			if ( this.counter >= data.length - 1 || this.loading ) {
				return false;
			}

			this.counter++;

			$( "#thb-gallery-details-modal .thb-gallery-details-next" ).removeClass( "thb-inactive" );
			$( "#thb-gallery-details-modal .thb-gallery-details-prev" ).removeClass( "thb-inactive" );

			if ( this.counter == data.length - 1 ) {
				$( "#thb-gallery-details-modal .thb-gallery-details-next" ).addClass( "thb-inactive" );
			}

			this.load();
			this.callback.next( this.counter );

			return false;
		};

		this.prev = function() {
			if ( this.counter == 0 || this.loading ) {
				return false;
			}

			this.counter--;

			$( "#thb-gallery-details-modal .thb-gallery-details-next" ).removeClass( "thb-inactive" );
			$( "#thb-gallery-details-modal .thb-gallery-details-prev" ).removeClass( "thb-inactive" );

			if ( this.counter == 0 ) {
				$( "#thb-gallery-details-modal .thb-gallery-details-prev" ).addClass( "thb-inactive" );
			}

			this.load();
			this.callback.prev( this.counter );
			return false;
		};
	};

	$( document ).on( "ready", function() {

		if( ! $('body').hasClass( 'thb-mobile' ) && $( "body" ).hasClass( "thb-disable-contextmenu" ) ) {
			$( document ).on( "contextmenu", "img", function() {
				return false;
			} );
		}

		if ( $.thb.wp.is_body_class( "thb-preloader-enabled" ) ) {
			NProgress.configure({ parent: '.thb-curtain-logo-inner-wrapper' }).start();
			$('body').addClass('thb-curtain-on');
		}

		// if( ! $('body').hasClass('thb-mobile') ) {


			/**
			 * Scroll in page
			 */
			var smoothScrollSelectors = ".thb-btn.action-primary, .thb-btn.action-secondary, li.menu-item a, .thb-slide-caption .thb-call-to .thb-btn";

			window.thb_scroll_in_page( smoothScrollSelectors );

			$( ".thb-header-inner-wrapper" ).imagesLoaded( function() {

				setTimeout( function() {
					$( window ).trigger( "resize" );

					if ( $.thb.wp.is_body_class( "thb-preloader-enabled" ) ) {
						NProgress.set(0.99);
					}

					if ( $( "body" ).hasClass( "thb-slideshow-fullscreen" ) ) {
						if ( $( "body" ).hasClass( "thb-theme-layout-a" ) && ! $( "body" ).hasClass( "thb-header-inner-filled" ) ) {
							$( ".thb-slideshow-wrapper" ).css( { 'top' : $( "#thb-header" ).outerHeight() } );

							if ( ! $( "body").hasClass( "thb-header-inner-filled" ) ) {
								$( ".thb-slideshow-wrapper" ).css( { 'top' : $( "#thb-header" ).outerHeight() + 24 } );
							}
						}
					}

					if ( $.thb.wp.is_body_class( "thb-preloader-enabled" ) ) {
						$.thb.transition( ".thb-curtain-logo-wrapper", function() {
							$( ".thb-curtain" ).remove();
						}, false );
					}

					if ( $.thb.wp.is_body_class( "thb-preloader-enabled" ) ) {
						setTimeout( function() {

							$("body").addClass("thb-page-loaded");
							NProgress.done();

						}, 500 );
					}
					else {
						$("body").addClass("thb-page-loaded");
					}

				}, 250 );
			} );
		// } else {

			// $("body").addClass("thb-page-loaded");

		// }

		/**
		 * Fit builder section height to the window height
		 */
		if ( $( ".thb-section" ).length ) {
			$( ".thb-section-extra[data-fit-height='1']" ).each( function() {
				var section = $( this ),
					offset = $( "body" ).offset().top,
					window_height = $( window ).height();

					var w_height = window_height - offset;

				section.css('min-height', w_height );
			} );
		}

		/**
		 * Galleries
		 */
		window.thbCreateGallery = function() {
			var gridItems = [];

			if ( typeof gallery_items_filtered == 'undefined' ) {
				window.gallery_items_filtered = window.gallery_items;
			}

			$.each( window.gallery_items_filtered, function( index, item ) {
				gridItems.push( {
					id: item.id,
					type: item.type,
					image: item.url_full,
					link: item.link,
					title: item.title,
					description: item.description,
					project_name: item.project ? item.project.name : "",
					project_url: item.project ? item.project.permalink : "",
					exif: item.exif
				} );
			} );

			if ( window.thb_gallery ) {
				delete window.thb_gallery;
			}

			window.thb_gallery = new window.THB_GalleryDetails( gridItems );
		};

		/**
		 * ---------------------------------------------------------------------
		 * Gallery grid
		 * ---------------------------------------------------------------------
		 */
		if ( $( "#thb-grid-gallery-container ul.thb-grid-layout" ).length ) {
			var galleryContainer = $( "#thb-grid-gallery-container ul.thb-grid-layout" ),
				filter_controls = $( "#thb-grid-gallery-container ul.filterlist" );

			$(document).on( 'inview', '#thb-grid-gallery-container ul.thb-grid-layout li', function() {
				var li = $( this );

				if( ! li.hasClass( 'inview' ) ) {
					li.addClass( 'inview' );
				}
			});

			var portfolio_isotope = new THB_Isotope( galleryContainer, {
				filter: new THB_Filter(galleryContainer, {
					controls: filter_controls,
					controlsOnClass: "active",
					filterCheck: function() {
						return ! $( "body" ).hasClass( "thb-ajax-loading" );
					},
					filter: function( selector ) {
						if ( typeof gallery_pace !== "undefined" ) {
							$( "body" ).addClass( "thb-ajax-loading" );
							gallery_pace.current_page = 0;

							if ( selector ) {
								var id = selector.match(/\d+/)[0];

								window.gallery_items_filtered = _.filter( window.gallery_items, function( item ) {
									var cats = item.gallery_category.split( "," );

									return cats.indexOf( id ) !== -1;
								} );
							}
							else {
								window.gallery_items_filtered = window.gallery_items;
							}

							portfolio_isotope.remove( function() {
								thb_gallery_load();
							} );
						}
						else {
							portfolio_isotope.filter( selector );
						}
					}
				})
			});

			$( "#thb-grid-gallery-container" ).data( "THB_Isotope", portfolio_isotope );

			window.thb_gallery_load = function( callback ) {
				$( "#thb-grid-gallery-container" ).addClass( "thb-loading" );

				var template = $( "[data-tpl='thb-gallery-item']" ).html(),
					insert = '';

				for ( i = 0; i < gallery_pace.pace; i++ ) {
					var cp = parseInt( gallery_pace.current_page, 10 ),
						pace = parseInt( gallery_pace.pace, 10 ),
						index = i;

					index = ( cp * pace ) + i;

					if ( typeof window.gallery_items_filtered === "undefined" ) {
						window.gallery_items_filtered = window.gallery_items;
					}

					if ( window.gallery_items_filtered && window.gallery_items_filtered[index] ) {
						var item = window.gallery_items_filtered[index],
							filters = "";

						insert += $( window.THB_SuperbaTemplate( template, {
							filters: filters,
							image: item.url,
							project: item.project,
							title: item.title
						} ) ).outerHTML();
					}
				}

				$( "#thb-grid-gallery-container" ).removeClass( "thb-loading" );
				$( "body" ).removeClass( "thb-ajax-loading" );

				portfolio_isotope.insert( $( insert ), function() {
					if ( callback ) {
						callback();
					}

					var check_index = ( parseInt( gallery_pace.current_page, 10 ) * parseInt( gallery_pace.pace, 10 ) ) + parseInt( gallery_pace.pace, 10 );

					if ( ! window.gallery_items_filtered[check_index] ) {
						$( ".thb-gallery-load-more-container" ).hide();
					}
					else {
						$( ".thb-gallery-load-more-container" ).show();
					}

					$.scrollToInclude( "#thb-grid-gallery-container", {
						offset: 20
					} );
				} );
			};

			$( document ).on( "click", "#thb-grid-gallery-container ul.thb-grid-layout li > a", function() {
				if ( thb_gallery_script_check() ) {
					window.thbCreateGallery();
					window.thb_gallery.open( $( this ).parent().index() );
				}

				return false;
			} );

			$( "#thb-gallery-load-more" ).on( "click", function() {
				var btn = $( this );

				btn.addClass( "thb-ajax-loading" );
				gallery_pace.current_page = parseInt( gallery_pace.current_page, 10 ) + 1;

				window.thb_gallery_load( function() {
					btn.removeClass( "thb-ajax-loading" );
				} );

				return false;
			} );
		}

		/**
		 * Gallery carousel
		 */
		if ( $( "#thb-carousel-gallery-container" ).length ) {
			var thb_carousel_on = $.thb.wp.is_desktop() || $.thb.wp.is_larger_than( 768 );

			window.thbGalleryCarousel = function() {
				$( document ).off( ".thbSly" );
				$( window ).off( "keydown.thbSly" );
				$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-prev" ).off( ".thbSly" );
				$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-next" ).off( ".thbSly" );
				$( "#thb-carousel-gallery-container div > a" ).off( ".thbSly" );

				if ( thb_carousel_on ) {
					$( "#thb-carousel-gallery-container .thb-video-holder" ).css( {
						"height": $( "#thb-carousel-gallery-container" ).outerHeight(),
						"width": $( "#thb-carousel-gallery-container" ).outerHeight() * 16 / 9
					} );
				} else {
					$( "#thb-carousel-gallery-container .thb-video-holder" ).css( {
						"height": $( "#thb-carousel-gallery-container" ).outerWidth() * 9 / 16,
						"width": $( "#thb-carousel-gallery-container" ).outerWidth()
					} );
				}

				var carousel_alignment = "forceCentered";

				if ( window.thb_carousel_options.carousel_alignment == "left" ) {
					carousel_alignment = "centered";
				}

				var slyOptions = {
					horizontal: 1,
					itemNav: carousel_alignment,
					smart: 1,
					activateOn: 'click',
					mouseDragging: 0,
					touchDragging: 0,
					releaseSwing: 1,
					scrollBy: 0,
					speed: 300,
					startAt: parseInt( window.thb_carousel_options.carousel_starts_from, 10 ),
					easing: 'easeOutExpo',
					keyboardNavBy: 'items'
				};

				// if ( $.thb.wp.is_body_class( "thb-theme-layout-b" ) ) {
				// 	slyOptions.startAt = 0;
				// }

				if ( thb_carousel_on ) {
					window.thbSly = new Sly( $( "#thb-carousel-gallery-container" ), slyOptions ).init();

					$( window ).on( "resize.thbSly", function() {
						if ( window.thbSly ) {
							window.thbSly.reload();
						}
					} );

					if ( $.thb.wp.is_mobile() ) {
						self.hammertime = new Hammer( $( "#thb-carousel-gallery-container" ).get( 0 ) );
						self.hammertime.on( "panend", function( ev ) {
							if ( ev.direction == 4 ) {
								if ( $( "body" ).hasClass( "thb-gallery-details-modal-open" ) ) {
									return false;
								}

								window.thbSly.prev();
							}
							else if ( ev.direction == 2 ) {
								if ( $( "body" ).hasClass( "thb-gallery-details-modal-open" ) ) {
									return false;
								}

								window.thbSly.next();
							}
						} );
					}

					// $.thb.key( "left", function() {
					// 	if ( $( "body" ).hasClass( "thb-gallery-details-modal-open" ) ) {
					// 		return false;
					// 	}

					// 	window.thbSly.prev();
					// }, false, "thbSly" );

					// $.thb.key( "right", function() {
					// 	if ( $( "body" ).hasClass( "thb-gallery-details-modal-open" ) ) {
					// 		return false;
					// 	}

					// 	window.thbSly.next();
					// }, false, "thbSly" );

					window.thbSlyCalc = function() {
						var all_items = $( "#thb-carousel-gallery-container div.thb-carousel-gallery-item" ).length,
							active = $( "#thb-carousel-gallery-container div.thb-carousel-gallery-item.active" ).index(),
							preload_num = $.thb.wp.is_desktop() ? 4 : 2,
							lazy = active + 4,
							items = $( "#thb-carousel-gallery-container div.thb-carousel-gallery-item:nth-child(-n+" + lazy + ")" );

						$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-prev" ).removeClass( "thb-inactive" );
						$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-next" ).removeClass( "thb-inactive" );

						if ( active === 0 ) {
							$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-prev" ).addClass( "thb-inactive" );
						}
						else if ( all_items - 1 === active ) {
							$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-next" ).addClass( "thb-inactive" );
						}

						if ( items.length ) {
							$.thb.loadImage( items, {
								imageLoaded: function( image ) {
									$( image ).addClass( "thb-image-loaded" );
									window.thbSly.reload();
								},
								allLoaded: function() {
									window.thbSly.reload();
								}
							} );
						}
					};

					window.thbSly.on('change', function (eventName) {
						window.thbSlyCalc();
					});

					window.thbSlyCalc();

					$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-prev" ).on( "click.thbSly", function() {
						window.thbSly.prev();

						return false;
					} );

					$( ".thb-carousel-gallery-outer-wrapper .thb-carousel-gallery-next" ).on( "click.thbSly", function() {
						window.thbSly.next();

						return false;
					} );
				}

				$( "#thb-carousel-gallery-container div > a" ).on( "click.thbSly", function() {
					var index = $( this ).parents(".thb-carousel-gallery-item").first().index();

					if ( thb_gallery_script_check() ) {
						window.thbCreateGallery();
						window.thb_gallery.open( index, {
							next: function( index ) {
								if ( window.thbSly ) {
									window.thbSly.slideTo( index, true );
								}
							},
							next: function( index ) {
								if ( window.thbSly ) {
									window.thbSly.slideTo( index, true );
								}
							},
						} );
					}

					if ( window.thbSly ) {
						window.thbSly.activate( index );
					}

					return false;
				} );

				if ( thb_carousel_on ) {
					$( window ).trigger( "resize.thbSly" );
				}
			};

			window.thbGalleryCarousel();

			if ( ! thb_carousel_on ) {
				$( "#thb-carousel-gallery-container div.thb-carousel-gallery-item img[data-src]" ).each( function() {
					var image = $( this ),
						parent = image.parent();

					image.on( "inview", function() {
						if( ! parent.hasClass( 'inview' ) ) {
							parent.addClass( 'inview' );
						}

						$.thb.loadImage( image, {
							allLoaded: function() {
								parent.addClass( "thb-image-loaded" );
							}
						} );
					} );
				} );
			}
		}

		/**
		 * Gallery slideshow
		 */
		if ( $( "#thb-slideshow-gallery-container" ).length ) {
			var thb_slideshow_on = $.thb.wp.is_desktop() || $.thb.wp.is_larger_than( 768 ),
				thb_slideshow_fullscreen = $( "body" ).hasClass( "thb-slideshow-fullscreen" ),
				thb_content_available = $( ".thb-content-section" ).hasClass( "thb-content-available" ) || ! $( "#thb-page-header" ).hasClass( "thb-page-header-disabled" );

			window.thbGallerySlideshow = function() {
				if ( thb_slideshow_on ) {
					var rsOptions = {
						loop: false,
						slidesSpacing: 0,
						navigateByClick: false,
						addActiveClass: true,
						controlNavigation: 'none',
						imageScaleMode: 'fit-if-smaller',
						numImagesToPreload: 1,
						keyboardNavEnabled: true,
						transitionType: thb_slideshow.effect
					};

					if ( thb_slideshow_fullscreen ) {
						rsOptions['imageScaleMode'] = 'fill';
					}

					var slideshow = $( "#thb-slideshow-gallery-container > .thb-slideshow" ),
						slideshow_height = slideshow.outerHeight();
					slideshow.thbRoyalSliderSlideshow( rsOptions );

					window.thbRoyal = $( "#thb-slideshow-gallery-container > .thb-slideshow" ).data( 'royalSlider' );

					if ( ! thb_slideshow_fullscreen ) {
						var slideshow_width = slideshow.outerWidth(),
							slideshow_height = slideshow_width * 9 / 16;

						slideshow.css( "height", slideshow_height );
					}

					window.thbRoyal = $( "#thb-slideshow-gallery-container > .thb-slideshow" ).data( 'royalSlider' );
				}

				if ( thb_slideshow_fullscreen ) {

					$( document ).on( "click", ".thb-toggle-caption", function() {
						$( "body" ).toggleClass( "thb-toggle-caption-open" );
						return false;
					} );

					if ( window.thbRoyal ) {
						window.thbRoyal.ev.on( "rsBeforeAnimStart", function() {
							$( "body" ).removeClass( "thb-toggle-caption-open" );
						} );
					}
				}

				$( document ).on( "click", "#thb-slideshow-gallery-container .thb-slideshow-gallery-open-details", function() {
					var index = thb_slideshow_on ? window.thbRoyal.currSlideId : $( this ).parent().index();

					if ( thb_slideshow_fullscreen && thb_slideshow_on ) {
						return false;
					}

					if ( thb_gallery_script_check() ) {
						window.thbCreateGallery();
						window.thb_gallery.open( index, {
							next: window.thbRoyal ? function() {
								window.thbRoyal.next();
							} : null,

							prev: window.thbRoyal ? function() {
								window.thbRoyal.prev();
							} : null,
						} );
					}

					if ( window.thbRoyal ) {
						window.thbRoyal.goTo( index );
					}

					return false;
				} );

				if ( thb_slideshow_on ) {
					$( window ).trigger( "resize" );
				}
			};

			window.thbGallerySlideshow();

			if ( ! thb_gallery_script_check() ) {
				$( "#thb-slideshow-gallery-container img[data-src]" ).each( function() {
					var image = $( this ),
						parent = image.parent();

					image.on( "inview", function() {
						if( ! parent.hasClass( 'inview' ) ) {
							parent.addClass( 'inview' );
						}

						$.thb.loadImage( image, {
							allLoaded: function() {
								parent.addClass( "thb-image-loaded" );
							}
						} );
					} );
				} );
			}
		}

		/**
		 * Blog Masonry
		 */
		if( $( ".thb-masonry-container" ).length ) {
			var blog_masonry = new THB_Isotope( $(".thb-masonry-container") );
		}

		/**
		 * Side nav menu
		 */
		window.thb_superba_vertical_menu_destroy = function( main_nav ) {
			$( main_nav + " .trigger" ).remove();
			$( main_nav ).removeAttr("style");
			$('body').removeClass('menu-open');
		};

		window.thb_superba_vertical_menu = function( main_nav ) {
			thb_superba_vertical_menu_destroy( ".main-navigation" );

			setTimeout( function() {
				$( main_nav + " .menu li.menu-item-has-children, " + main_nav + " .menu li.page_item_has_children" )
					.append( $( "<span class='trigger'></span>" ) );

				$( main_nav + " .menu li.menu-item-has-children .trigger, " + main_nav + " .menu li.page_item_has_children .trigger" )
					.on( "click.thb_menu", function() {
						var submenu = $( this ).parent().find( "> ul" ),
							link_el = submenu.parent().find( "> a" );

						if ( submenu.hasClass( "open" ) ) {
							$( this ).removeClass( "open" );
							submenu.removeClass( "open" );
							link_el.removeClass( "open" );
							submenu.find( ".open" ).removeClass( "open" );
						}
						else {
							$( this ).addClass( "open" );
							submenu.addClass( "open" );
							link_el.addClass( "open" );
						}

						return false;
					} );
			}, 10 );
		};

		/**
		 * Menu
		 */
		if ( $(".main-navigation.inline").length ) {
			$(".main-navigation.inline .thb-desktop-navigation > div").menu();
		}
		else {
			thb_superba_vertical_menu( ".main-navigation .thb-desktop-navigation" );
		}

		if ( $( "html" ).hasClass( 'responsive_480' ) ) {
			thb_superba_vertical_menu( ".main-navigation .thb-mobile-navigation" );
		}

		/**
		 * Mobile nav toggle
		 */
		function menuToggle() {
			var triggerOpen = $('.thb-mobile-nav-trigger');

			function openMenu() {
				$('#main-nav').css("display", "block");
				$('#main-nav').css("visibility", "visible");
				$('body').addClass('menu-open');
			}

			function closeMenu() {
				$('body').removeClass('menu-open');
				$.thb.transition('#main-nav', function() {
					$('#main-nav').css("visibility", "hidden");
					$('#main-nav').css("display", "none");
				});
			}

			triggerOpen.bind('click', function(){
				if( $("body").hasClass("menu-open") ) {
					closeMenu();
				} else {
					openMenu();
				}
				return false;
			});
		}

		menuToggle();

		/**
		 * Go top
		 */

		if ( $('.thb-go-top').length ) {
			$('.thb-go-top').click(function(){
				$("html, body").stop().animate({ scrollTop: 0 }, 350, 'easeInOutCubic' );
				return false;
			});
		}

		/**
		 * Portfolio.
		 */
		if ( $( ".thb-portfolio" ).length ) {
			$( ".thb-portfolio" ).each( function() {
				var portfolio = $( this ),
					useAjax = portfolio.attr( "data-ajax" ) == "1",
					isotopeContainer = $( ".thb-grid-layout", portfolio ),
					filter_controls = $( ".filterlist", portfolio ),
					portfolio_pagination = $( ".thb-navigation", portfolio ),
					thb_portfolio_filtering = false;

				if( ! useAjax ) {
					$( "li", filter_controls ).each(function() {
						var data = $(this).data("filter");

						if( data !== "" ) {
							if( ! isotopeContainer.find("[data-filter-" + data + "]").length ) {
								$(this).remove();
							}
						}
					});
				}

				var portfolio_isotope = new THB_Isotope( isotopeContainer, {
					filter: new THB_Filter(isotopeContainer, {
						controls: filter_controls,
						controlsOnClass: "active",
						filter: function( selector ) {
							if ( ! useAjax ) {
								portfolio_isotope.filter( selector );
							}
						}
					})
				});

				isotopeContainer.data( "thb_isotope", portfolio_isotope );

				window.thb_portfolio_reload = function( url, portfolio, callback ) {
					var portfolio_pagination = $( ".thb-navigation", portfolio ),
						isotopeContainer = $( ".thb-grid-layout", portfolio ),
						index = portfolio.index( $( ".thb-portfolio" ) );

					isotopeContainer.data( "thb_isotope" ).remove(function() {
						$.thb.loadUrl(url, {
							method: "POST",
							filter: false,
							complete: function( data ) {
								var target_portfolio = $(data).find( ".thb-portfolio" ).eq( index );

								var items = target_portfolio.find(".thb-grid-layout .item");

								if( portfolio_pagination.length ) {
									if ( target_portfolio.find(".thb-navigation").length ) {
										portfolio_pagination.replaceWith( target_portfolio.find(".thb-navigation") );
									} else {
										portfolio_pagination.html('');
									}
								}
								else {
									isotopeContainer.after( target_portfolio.find(".thb-navigation") );
								}

								isotopeContainer.data( "thb_isotope" ).insert(items, function() {
									thb_portfolio_bind_pagination( portfolio );

									if( callback !== undefined ) {
										callback();
									}
								});
							}
						});
					});
				};

				window.thb_portfolio_bind_pagination = function( portfolio ) {
					$( ".thb-navigation a", portfolio ).on("click", function() {
						thb_portfolio_reload( $(this).attr("href"), portfolio, function() {
							window.thb_boot_slideviews();
							$( window ).trigger( "resize" );
						} );
						return false;
					});
				};

				window.thb_portfolio_bind_filter = function( portfolio ) {
					var filter_controls = $( ".filterlist", portfolio );

					$( "li", filter_controls ).on("click", function() {
						if( thb_portfolio_filtering ) {
							return false;
						}

						thb_portfolio_filtering = true;

						thb_portfolio_reload( $(this).data("href"), portfolio, function() {
							thb_portfolio_filtering = false;
							window.thb_boot_slideviews();
							$( window ).trigger( "resize" );
						} );


						$( "li", filter_controls ).removeClass("active");
						$(this).addClass("active");
						return false;
					});
				};

				if( useAjax ) {
					thb_portfolio_bind_filter( portfolio );
					thb_portfolio_bind_pagination( portfolio );
				}
			} );
		}

		/**
		 * Single project
		 */
		if( $( ".work-slides-container.thb-photoset-grid" ).length ) {
			$( document ).on( "click", ".work-slides-container.thb-photoset-grid img", function() {
				if ( thb_gallery_script_check() ) {
					var index = parseInt( $( this ).data( "index" ), 10 );

					window.thbCreateGallery();
					window.thb_gallery.open( index );
				}

				return false;
			} );
		}

		if ( $( ".work-slides-container.thb-regular" ).length ) {
			$( ".work-slides-container.thb-regular img[data-src]" ).each( function() {
				var image = $( this ),
					parent = image.parent();

				image.on( "inview", function() {
					if( ! parent.hasClass( 'inview' ) ) {
						parent.addClass( 'inview' );
					}

					$.thb.loadImage( image, {
						allLoaded: function() {
							parent.addClass( "thb-image-loaded" );
						}
					} );
				} );
			} );

			$( document ).on( "click", ".work-slides-container.thb-regular a.thb-gallery-lightbox", function() {
				if ( thb_gallery_script_check() ) {
					var index = parseInt( $( this ).parent().data( "index" ), 10 );

					window.thbCreateGallery();
					window.thb_gallery.open( index );
				}

				return false;
			} );
		}

		/**
		 * Galleries
		 */
		if ( $( ".masonry .thb-gallery" ).length ) {
			$( ".masonry .thb-gallery" ).each( function( i ) {
				var gallery = $( this );

				gallery.royalSlider({
					loopRewind: true,
					slidesSpacing: 0,
					navigateByClick: false,
					imageScaleMode: "fill",
					addActiveClass: true,
					autoScaleSlider: true,
					autoScaleSliderWidth: 300,
					autoScaleSliderHeight: 300,
					arrowsNavAutoHide: false,
					transitionType: "fade",
					numImagesToPreload: 99
				});
			} );
		}

		if ( $(".classic .thb-gallery, .single-post .thb-gallery").length ) {
			$(".classic .thb-gallery, .single-post .thb-gallery").each( function() {
				var gallery = $( this );

				gallery.royalSlider({
					loopRewind: true,
					slidesSpacing: 0,
					navigateByClick: false,
					imageScaleMode: "fill",
					autoScaleSlider: true,
					autoScaleSliderWidth: 930,
					autoScaleSliderHeight: 523,
					addActiveClass: true,
					transitionType: "fade",
					numImagesToPreload: 99
				});
			} );
		}

		/**
		 * Splash page.
		 */
		if ( $( ".thb-splash-content-data-wrapper" ).length ) {
			$.thb.transition( ".thb-splash-content-data-wrapper > div:last-child", function() {
				$( "body" ).addClass( "thb-data-wrapper-transition-end" );
			}, false );
		}

		/**
		 * Mosaic album.
		 */
		if( $( ".thb-superba-photoset-grid" ).length ) {
			var photoset = $( ".thb-superba-photoset-grid" ),
				options = {
					gutter: photoset.data( "gutter" ) !== undefined ? photoset.data( "gutter" ) : 0,
				},
				photoset_on = $.thb.wp.is_desktop() || $( "html" ).is( ".ua-mobile-ipad" );

			if ( photoset_on ) {
				$.thb.loadImage( photoset, {
					allLoaded: function() {
						photoset.photosetGrid( options );
					}
				} );
			}

			if ( thb_gallery_script_check() ) {
				$( document ).on( "click", ".thb-superba-photoset-grid img", function() {
					if ( thb_gallery_script_check() ) {
						var index = parseInt( $( this ).data( "index" ), 10 );

						window.thbCreateGallery();
						window.thb_gallery.open( index );
					}

					return false;
				} );
			}

			$( document ).on( "inview", ".thb-superba-photoset-grid img", function() {
				var images = $( this );

				images.each( function() {
					if( ! $( this ).parent().hasClass( 'inview' ) ) {
						$( this ).parent().addClass( 'inview' );
					}

					$.thb.loadImage( this, {
						imageLoaded: function( image ) {
							if ( photoset_on ) {
								photoset.photosetGrid( options );
							}

							$( image ).parent().addClass( "thb-image-loaded" );
						}
					} );
				} );
			} );
		}

		/**
		 * Fast click
		 */

		if( $( "body" ).hasClass( "thb-mobile" ) ) {
			FastClick.attach(document.body);
		}

	} );
} )( jQuery );
