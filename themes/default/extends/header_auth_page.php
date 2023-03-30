<?php

	/*
	 *	Aruna Development Project
	 *	IS NOT FREE SOFTWARE
	 *	Codename: Aruna Personal Site
	 *	Source: Based on Sosiaku Social Networking Software
	 *	Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *	Created and developed by Andhika Adhitia N
	 */
	
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
			<meta name="copyright" content="'.get_csite('site_name').' 2022">
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
			<link rel="stylesheet" href="'.base_url('assets/plugins/bootstrap/5.2.3/css/bootstrap.min.css').'">

			<!-- Font Lato CSS -->
			<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"> 

			<!-- Custom CSS -->
			<link rel="stylesheet" href="'.base_url('assets/css/aruna-v3.css?v=0.0.2').'">
			<link rel="stylesheet" href="'.base_url('assets/plugins/fontawesome/5.15.3/css/all.min.css').'">

			<title>'.get_ctitle().'</title>
		</head>

		<body>');

?>