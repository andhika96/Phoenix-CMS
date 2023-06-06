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

	section_content(breadcrumb([t('Manage Appearance') => '', t('Slideshow') => site_url('manage_appearance/slideshow'), t('Edit Slideshow') => '']));

	section_content('
	<ul class="nav nav-pills mb-3" id="footerTab" role="pilllist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="footer-image-content-pill" data-bs-toggle="pill" data-bs-target="#footer-image-content-pill-pane" type="button" role="pill" aria-controls="footer-image-content-pill-pane" aria-selected="true">Footer Image & Content</button>
		</li>
		
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="footer-link1-pill" data-bs-toggle="pill" data-bs-target="#footer-link1-pill-pane" type="button" role="pill" aria-controls="footer-link1-pill-pane" aria-selected="false">Footer Link 1</button>
		</li>
		
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="footer-link2-pill" data-bs-toggle="pill" data-bs-target="#footer-link2-pill-pane" type="button" role="pill" aria-controls="footer-link2-pill-pane" aria-selected="false">Footer Link 2</button>
		</li>
		
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="footer-link2-pill" data-bs-toggle="pill" data-bs-target="#footer-link3-pill-pane" type="button" role="pill" aria-controls="footer-link3-pill-pane" aria-selected="false">Footer Link 3</button>
		</li>
	</ul>



	<div class="container-fluid px-0 mb-5">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-app-listform">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fad fa-images fa-fw me-2"></i> '.t('Edit Footer').'
				</div> 

				<div>
					<span class="float-md-right font-size-normal"><a href="javascript:void(0)" v-on:click="addNewForm(\'list_footer1\')">New Form</a></span>
				</div>
			</div>

			<div id="ar-form-submit">	
				<form action="'.site_url('manage_news/listform').'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">						
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>					

					<div class="col-12 mb-4" v-for="(info, index) in getListFooter1" :key="index">
						<div class="row mb-2">
							<div class="col-md-6">
								<h6>- Link {{ index+1 }}</h6>
							</div>

							<div class="col-md-6 text-md-end">
								<a href="javascript:void(0)" v-on:click="deleteForm(getListFooter1, index, info.id); showData = !showData" class="text-danger text-underline ar-alert-bootbox font-size-inherit" v-bind:data-url="\''.site_url('manage_appearance/deleteslideshow/').'\'">Delete Image</a>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3 mb-md-0">
								<label class="form-label">Icon</label>								

								<div class="input-group">
									<input type="text" :name="\'footer_right_link1[link_\'+index+\'][icon]\'" class="form-control font-size-inherit">
								</div>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Title</label>								

								<div class="input-group">
									<input type="text" :name="\'footer_right_link1[link_\'+index+\'][content]\'" class="form-control font-size-inherit">
								</div>
							</div>

							<div class="col-12">
								<label class="form-label">Link</label>								

								<div class="input-group">
									<input type="text" :name="\'footer_right_link1[link_\'+index+\'][link]\'" class="form-control font-size-inherit">
								
									<input type="hidden" :name="\'footer_right_link1[link_\'+index+\'][type]\'" :value="\'text\'">
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<div>
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit" value="'.t('Save').'">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>');


?>