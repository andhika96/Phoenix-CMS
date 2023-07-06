<?php

	defined('THEMEPATH') OR exit('No direct script access allowed');
	
	display_application_header('
	<!doctype html>
	<html lang="en">
		<head>
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="author" content="Andhika Adhitia N">
			<meta name="generator" content="Powered by Aruna Development Project Framework PHP">
			<meta name="copyright" content="'.get_csite('site_name').' '.date("Y").'">
			<meta name="title" content="'.get_csite('site_name').'">
			<meta name="description" content="'.get_csite('site_description').'">

			<!-- Open Graph / Facebook -->
			<meta property="og:type" content="website">
			<meta property="og:url" content="'.get_meta('url').'">
			<meta property="og:title" content="'.get_meta('title').'">
			<meta property="og:description" content="'.get_meta('description').'">
			<meta property="og:image" content="'.get_meta('image').'">

			<!-- Twitter -->
			<meta property="twitter:card" content="summary_large_image">
			<meta property="twitter:url" content="'.get_meta('url').'">
			<meta property="twitter:title" content="'.get_meta('title').'">
			<meta property="twitter:description" content="'.get_meta('description').'">
			<meta property="twitter:image" content="'.get_meta('image').'">

			<!-- Favicons -->
			<link rel="apple-touch-icon" href="'.base_url('assets/favicons/apple-touch-icon.png').'" sizes="180x180">
			<link rel="icon" href="'.base_url('assets/favicons/favicon-32x32.png').'" sizes="32x32" type="image/png">
			<link rel="icon" href="'.base_url('assets/favicons/favicon-24x24.png').'" sizes="24x24" type="image/png">
			<link rel="mask-icon" href="'.base_url('assets/favicons/apple-touch-icon.png').'" color="#ec1c24">
			<link rel="icon" href="'.base_url('assets/favicons/favicon.ico').'">

			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="'.base_url('assets/plugins/bootstrap/5.3.0/css/bootstrap.min.css').'">

			<!-- Font Lato CSS -->
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap">

			<!-- Custom CSS -->
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
			<link rel="stylesheet" href="'.base_url('assets/css/aruna-v3.css?v=0.0.4').'">
			<link rel="stylesheet" href="'.base_url('assets/css/phoenix-cms.css?v=0.0.4').'">

			<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">

			<title>'.get_ctitle().'</title>

			<style>
			/* Default Custom CSS from PHOENIX CMS*/
			.ph-navbar
			{
				transition: all 300ms ease 0s;
				background-color: '.get_section_header('background_color').' !important;
			}

			.ph-navbar .nav-link
			{
				color: '.get_section_header('link_color').';
				'.get_section_header('border_radius_link').'
				background-color: '.get_section_header('background_link_color').';
			}

			.ph-navbar .nav-link:hover
			{
				color: '.get_section_header('link_color_hover').';
				background-color: '.get_section_header('background_link_color_hover').';
			}

			.ph-navbar .nav-link.active, 
			.ph-navbar .nav-link.show,
			.ph-navbar .show > .nav-link
			{
				color: '.get_section_header('link_color_active').';
				background-color: '.get_section_header('background_link_color_active').';
			}

			.ph-navbar-transparent .navbar-brand
			{
				filter: brightness(0) invert(1);
			}

			.ph-navbar-white
			{
				background-color: '.get_section_header('background_color_active').' !important;
			}

			.ph-navbar-white .navbar-brand
			{
				filter: none;
			}

			.ph-navbar-white .nav-link
			{
				color: #000;
			}

			.ph-navbar .megamenu 
			{ 
				padding: 4rem; 
			}

			.ph-navbar .megamenu a
			{
				color: #212529;
				text-decoration: none;
			}

			@media all and (min-width: 992px) 
			{
				.ph-navbar .has-megamenu 
				{
					position: static !important;
				}

				.ph-navbar .megamenu 
				{
					left: 0; 
					right: 0; 
					width: 100%; 
					margin-top: 0;
				}
			}	

			@media(max-width: 991px) 
			{
				.ph-navbar.fixed-top .ph-navbar-collapse, .ph-navbar.sticky-top .ph-navbar-collapse 
				{
					overflow-y: auto;
					max-height: 90vh;
					margin-top:10px;
				}
			}

			.has-megamenu .dropdown-menu
			{
				border: 0;
				border-radius: 0;
				background-color: #f8f9fa;
			}

			.dropdown-toggle[data-bs-toggle="dropdown"]
			{
				position: relative;
			}

			.dropdown-toggle[data-bs-toggle="dropdown"]::after
			{
				padding: 3px;
				border: solid;
				margin-left: .75rem;
				vertical-align: .1rem
				display: inline-block;
				transform: rotate(46.8deg);
				transition: all .2s ease-out;
				border-width: 0 .1rem .1rem 0;
			}

			.dropdown-toggle[data-bs-toggle="dropdown"][aria-expanded="true"]::after
			{
				transform: rotate(-135deg);
				vertical-align: .0rem 
			}
			</style>
		</head>

		<body class="ph-custom-css">
			<header class="ph-navbar '.is_fixed_navbar().' navbar navbar-expand-lg bg-light" style="border-bottom: 1px '.get_section_header('background_border_bottom').' solid">
				<div class="container">
					<a class="navbar-brand me-lg-4" href="#">
						<img src="'.base_url(get_logo(1, 'image')).'" class="d-none d-md-block" style="width: '.get_logo(1, 'size').'">
						<img src="'.base_url(get_logo(2, 'image')).'" class="d-block d-md-none" style="width: '.get_logo(2, 'size').'">
					</a>
				
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse '.get_section_header('menu_position').'" id="navbarNavDropdown">
						<ul class="navbar-nav">
							'.get_list_menu_header().'
						</ul>
					</div>
				</div>
			</header>');

	// Load application from modules
	display_application_content();

	display_application_footer('
			<!-- Optional JavaScript -->
			<!-- VueJS first, the second jQuery, then Bootstrap JS, and other -->			
			<script>let baseurl = "'.base_url().'"; let siteurl = "'.site_url().'";</script>

			<script src="'.base_url('assets/js/croppie-2.6.5.min.js').'"></script>
			<script src="'.base_url('assets/plugins/axios/0.27.2/axios.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-select-3.18.3.min.js').'"></script>
			<script src="'.base_url('assets/js/lodash-4.17.21.min.js').'"></script>
			<script src="'.base_url('assets/js/vuejs-2.7.14.min.js').'"></script>
			<script src="'.base_url('assets/js/vuejs-paginate-2.1.0.min.js').'"></script>
			<script src="'.base_url('assets/js/vue-lazyload-1.3.3.min.js').'"></script>
			<script src="'.base_url('assets/js/aruna-vue2022.js?v=0.0.15').'"></script>

			<script src="'.base_url('assets/js/jquery-3.6.0.min.js').'"></script>
			<script src="'.base_url('assets/plugins/bootbox/5.5.2/bootbox.all.min.js').'"></script>
			<script src="'.base_url('assets/plugins/bootstrap/5.3.0/js/bootstrap.bundle.min.js').'"></script>
			<script src="'.base_url('assets/plugins/fontawesome/5.15.3/js/all.min.js').'"></script>
			<script src="'.base_url('assets/js/aruna-admin-v5.js?v=1.0.2').'"></script>
			<script src="'.base_url('assets/js/simplebar-5.3.6.min.js').'"></script>
			<script src="'.base_url('assets/plugins/parallax/1.5.0/parallax.js').'"></script>

			<script>
			$(document).ready(function() 
			{ 
				$(".parallax-window").parallax({ "positionY": "center", "androidFix": false }); 

				if (document.querySelector(".ph-navbar-transparent") !== null)
				{
					if (window.pageYOffset != 0)
					{
						$(".ph-navbar").addClass("ph-navbar-white");
						$(".ph-navbar").removeClass("ph-navbar-transparent");
					}

					$(window).scroll(function() 
					{
						if ($(window).scrollTop() == 0) 
						{
							$(".ph-navbar").addClass("ph-navbar-transparent");
							$(".ph-navbar").removeClass("ph-navbar-white");
						}
						else 
						{
							$(".ph-navbar").addClass("ph-navbar-white");
							$(".ph-navbar").removeClass("ph-navbar-transparent");
						}
					});
				}
			});
			</script>			

			'.load_js().'	
		</body>
	</html>');

?>