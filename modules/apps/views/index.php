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

	defined('MODULEPATH') OR exit('No direct script access allowed');

	section_header('
	<div class="content-header">
		<div class="page-header header-filter header-small parallax-window" data-parallax="scroll" data-image-src="'.base_url(get_content_page('homepage', 'header', 'image_0')).'" alt="Background Image">
			<div class="container">
				<div class="row">
					<div class="col-md-8 mx-auto text-center">
						<h1>'.get_content_page('homepage', 'header', 'title').'</h1>
						<h4 class="fw-light">'.get_content_page('homepage', 'header', 'caption').'</h4>
					</div>
				</div>
			</div>
		</div>
	</div>');

	section_content('
	<div>
		<div class="container position-relative px-4 px-lg-0 my-5">
			<div class="row my-5">
				<div class="col-md-6 mb-5">
					<img src="'.base_url('modules/apps/image_optimized/hospital_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">
							
					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Web Hospital</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/hospital/" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<img src="'.base_url('modules/apps/image_optimized/rfasyura_optimized_new.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Web Game</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://www.asyurapvp.com" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<img src="'.base_url('modules/apps/image_optimized/jobseeker_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Job Seeker</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/carikerja" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<img src="'.base_url('modules/apps/image_optimized/niatngampus_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">NiatNgampus</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/niatngampus" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<img src="'.base_url('modules/apps/image_optimized/wtbcontrol_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">WTB Control App <span class="text-danger d-none">(Offline)</span></h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://www.wtbcontrol.com" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #9e9e9e;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #9e9e9e"></i>
							<i class="fa-inverse far fa-image" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/kombatan_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">
							
					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Kombatan (Web Portal Media)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/kombatan" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/sosiaku_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Sosiaku Social Network</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/sosiaku" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/gudlak_optimized.jpg').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Gudlak Web Event</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://www.gudlak.id" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/technovora_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Technovora <span class="text-danger">(Offline)</span></h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://www.technovora.com" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/lawyer_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Gregory Advocate (Lawyer Web)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/lawyerweb" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/umaragroup_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Umara Group</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/umaragroup" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/rumahumara_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Rumah Umara (Wedding & Event)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/rumahumara" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/lumpangemas_optimized.jpg').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Lumpang Emas Restaurant</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/lumpangemas" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/umaracatering_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Umara Catering</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/umaracatering" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image_optimized/educrack_optimized.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Educrack (Online Learning System)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>
                
				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/crypstocks-new.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Crypstocks (CMS Online Course)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>
	
				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/autocad.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">AutoCAD (CMS Article & Online Event)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/breadtalk.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Breadtalk</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/mgmotor.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">MG Motor (Company Profile)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/mgmotor-cms.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">CMS MG Motor (CMS)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/asus-event.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">ASUS (Web Event)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/gen21wifi.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">GEN21 WiFi (Login WiFi For User)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/gen21wifi-cms.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">CMS GEN21 WiFi (CMS)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>

				<div class="col-md-6 mb-5">
					<!---
					<div class="cs-no-thumb align-self-center text-center shadow" style="width: 100%;border-radius: 8px;background: #40c4ff;">
						<span class="fa-layers fa-fw height-no-thumb" style="width: 100%;">
							<i class="fas fa-square" style="color: #40c4ff"></i>
							<i class="fa-inverse fas fa-feather" data-fa-transform="shrink-6"></i>
						</span>
					</div>
					--->

					<img src="'.base_url('modules/apps/image/akuntansi.png').'" class="img-fluid border shadow" style="border-radius: 8px">

					<div class="short-desc d-flex justify-content-between align-items-center mt-1">
						<div>
							<h5 class="mt-3 mb-1">Akuntasi UKM (Accounting App)</h5>
							<div class="font-weight-light text-muted">Andhika Adhitia</div>
						</div>

						<div>
							<a href="https://demo.aruna-dev.id/educrack" class="btn btn-outline-success d-none" target="_blank">View</a>
						</div>
					</div>
				</div>
                
			</div>
		</div>
	</div>');

?>