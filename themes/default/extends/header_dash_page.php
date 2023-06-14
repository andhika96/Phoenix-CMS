<?php

	defined('THEMEPATH') OR exit('No direct script access allowed');
	
	section_header('
	<!doctype html>
	<html lang="en">
		<head>
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="author" content="Andhika Adhitia N">
			<meta name="generator" content="Powered by Aruna Development Project Framework PHP">
			<meta name="copyright" content="'.get_csite('site_name').' 2021">
			<meta name="title" content="'.get_csite('site_name').'">
			<meta name="description" content="'.get_csite('site_description').'">

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
			<link rel="stylesheet" href="'.base_url('assets/css/aruna-v3.css').'">
			<link rel="stylesheet" href="'.base_url('assets/css/aruna-admin-v6.css?v=0.0.5').'">

			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha256-r8T4Dlx/tdy6jNcFHplWaDHs7ob/Y9bKoJgjNFlYxY4=" crossorigin="anonymous" />
			<link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css">
			<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
			
			<!-- Spectrum ColorPicker CSS -->
			<link rel="stylesheet" href="'.base_url('assets/plugins/spectrum/dist/spectrum.min.css').'">

			<link rel="stylesheet" href="'.base_url('assets/plugins/fontawesome/5.15.3/css/all.min.css').'">
			<link rel="stylesheet" href="'.base_url('assets/plugins/iconpicker/dist/iconpicker-1.5.0.css').'">

			<title>'.get_ctitle().'</title>

			<noscript>
				<style>
				/*
				 * Reinstate scrolling for non-JS clients
				 */
			
				.simplebar-content-wrapper 
				{
					overflow: auto;
				}
				</style>
			</noscript>
		</head>

		<body>
			<!--- Ardev v6 Container Theme --->
			<div class="arv6-container">

				<!--- List Menu for Desktop View --->
				<div class="arv6-sidebar bg-white text-dark">

					<!--- Brand or Logo Here --->
					<div class="arv6-brand d-flex align-items-center justify-content-center">
						<img src="'.base_url(get_logo(3, 'image')).'" style="width: '.get_logo(3, 'size').'">
					</div>
					<!--- End of Brand or Logo Here --->

					<!--- List Menu --->
					<div class="arv6-menu px-2" data-simplebar>
						<div class="arv6-title row">
							<div class="col-auto fw-bold">
								'.t('All').'
							</div>

							<div class="col ps-0">
								<hr class="navbar-vertical-divider mb-0">
							</div>
						</div>

						<ul class="list-group list-group-flush">
							<a href="'.site_url().'" class="list-group-item list-group-item-action" target="_blank">
								<i class="fad fa-external-link fa-fw me-2"></i>
								'.t('Visit Site').'
							</a>

							<a href="'.site_url('dashboard').'" class="list-group-item list-group-item-action">
								<i class="fad fa-tachometer-alt fa-fw me-2"></i>
								'.t('Dashboard').'
							</a>
						</ul>

						<div class="arv6-title row">
							<div class="col-auto fw-bold">
								'.t('Menu').'
							</div>

							<div class="col ps-0">
								<hr class="navbar-vertical-divider mb-0">
							</div>
						</div>

						<div class="list-group list-group-flush">
							'.get_list_menu().'
						</div>

						<div class="arv6-title row">
							<div class="col-auto fw-bold">
								'.t('Admin Settings').'
							</div>

							<div class="col ps-0">
								<hr class="navbar-vertical-divider mb-0">
							</div>
						</div>

						<ul class="list-group list-group-flush">
							<a href="'.site_url('awesome_admin').'" class="list-group-item list-group-item-action">
								<i class="fad fa-user-secret fa-fw me-2"></i>
								'.t('Admin Panel').'
							</a>
						</ul>
					</div>
					<!--- End of List Menu --->

				</div>
				<!--- End of List Menu for Desktop View --->

				<!--- List Menu for Mobile View --->
				<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
					<div class="offcanvas-header py-4">
						<img src="'.base_url(get_logo(4, 'image')).'" style="width: '.get_logo(4, 'size').'">
						<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					
					<div class="offcanvas-body">

						<!--- List Menu --->
						<div class="arv6-menu px-0" data-simplebar>
							<div class="arv6-title row">
								<div class="col-auto fw-bold">
									'.t('All').'
								</div>

								<div class="col ps-0">
									<hr class="navbar-vertical-divider mb-0">
								</div>
							</div>

							<ul class="list-group list-group-flush">
								<a href="#" class="list-group-item list-group-item-action">
									<i class="fas fa-external-link fa-fw me-2"></i>
									'.t('Visit Site').'
								</a>

								<a href="'.site_url('dashboard').'" class="list-group-item list-group-item-action">
									<i class="fad fa-tachometer-alt fa-fw me-2"></i>
									'.t('Dashboard').'
								</a>
							</ul>

							<div class="arv6-title row">
								<div class="col-auto fw-bold">
									'.t('Menu').'
								</div>

								<div class="col ps-0">
									<hr class="navbar-vertical-divider mb-0">
								</div>
							</div>

							<div class="list-group list-group-flush">
								'.get_list_menu().'
							</div>

							<div class="arv6-title row">
								<div class="col-auto fw-bold">
									'.t('Admin Settings').'
								</div>

								<div class="col ps-0">
									<hr class="navbar-vertical-divider mb-0">
								</div>
							</div>

							<ul class="list-group list-group-flush">
								<a href="'.site_url('awesome_admin').'" class="list-group-item list-group-item-action">
									<i class="fas fa-user-secret fa-fw me-2"></i>
									'.t('Admin Panel').'
								</a>
							</ul>
						</div>
						<!--- End of List Menu --->

					</div>
				</div>
				<!--- End of List Menu for Mobile View --->

				<div class="arv6-main-side">
					<div class="arv6-header-side mb-4 navbar navbar-expand-lg navbar-light">
						<div class="container-fluid">
							<ul class="navbar-nav arv6-button-bars">
								<li class="nav-item dropdown">
									<a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><i class="far fa-bars fa-lg"></i></a>
								</li>
							</ul>

							<ul class="navbar-nav ms-auto">
								<li class="nav-item dropdown">
									<a href="javascript:void(0)" class="nav-link dropdown-toggle" aria-current="page" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog fa-lg"></i></a>

									<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
										<li><a class="dropdown-item font-size-normal" href="'.site_url('account').'"><i class="fas fa-cog fa-fw me-1"></i> '.t('Account Settings').'</a></li>
										<li><a class="dropdown-item font-size-normal" href="'.site_url('auth/logout').'"><i class="fas fa-sign-out fa-fw me-1"></i> '.t('Logout').'</a></li>
									</ul>
								</li>
							</ul>
		  				</div>
		  			</div>

		  			<div class="arv6-content-side">');

?>