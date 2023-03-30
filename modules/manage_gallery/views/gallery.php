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

	section_content(breadcrumb([t('Manage Gallery') => site_url('manage_gallery'), $row['name'] => '']));

	section_content('
	<!-- Custom CSS -->
	<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css">

	<style>
	.dropzone
	{
		border-radius: 0.5rem;
		border: 2px solid #ff8484 !important;
	}
	</style>

	<div class="container-fluid px-0" id="ar-listimages">
		<div class="arv6-box bg-white rounded shadow-sm p-4 ar-fetch-listimage" data-url="'.site_url('manage_gallery/getListImages/'.$row['id']).'">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center"><div><i class="fad fa-folder-open fa-fw me-1"></i> '.t('List of Image').' '.$row['name'].'\'s</div> <div><span class="float-md-right font-size-normal"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#uploadImageModal">'.t('Upload Image').'</a></div></div>

			<div v-if="loading" class="text-center py-3 lead">Loading ...</div>

			<div v-else-if="isData" class="text-center text-danger">
				{{ msgData }}
			</div>

			<div v-else>
				<div v-if="loadingnextpage" class="d-flex justify-content-center h4 my-5 py-5 vh-100">Loading ...</div>

				<div v-else>
					<transition-group name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster" tag="div" class="row g-3" uk-lightbox="animation: slide">
						<div class="col-3 col-md-auto text-center" v-for="(info, index) in getData" v-bind:key="info.id">
							<a href="#!" data-type="image" data-alt="Image" class="rounded d-block">
								<img :src="\'\'+info.thumbnail2+\'\'" class="img-fluid" style="width: 125px">
							</a>

							<button type="button" v-on:click="initDeletePopupData(getData, index, info.id); show = !show" class="btn btn-link p-0 ar-alert-bootbox" v-bind:data-url="\''.site_url('manage_gallery/deleteimage/').'\'">Delete</button>
						</div>
					</transition-group>
				</div>
				
				<paginate :page-count="pageCount" :page-range="pageRange" :container-class="\'pagination flex-wrap justify-content-center mt-4\'" :page-class="\'page-item font-size-inherit\'" :prev-class="\'page-item font-size-inherit\'" :next-class="\'page-item font-size-inherit\'" :page-link-class="\'page-link font-size-inherit\'" :prev-link-class="\'page-link font-size-inherit\'" :next-link-class="\'page-link font-size-inherit\'" :click-handler="clickPaginate" v-model="currentPage"></paginate>
			</div>

			<!-- Modal Upload -->
			<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<h1 class="modal-title fs-5" id="uploadImageModalLabel">Upload Image or Photo</h1>
							<button type="button" class="btn-close" v-on:click="closeNewUploadPopup" aria-label="Close"></button>
						</div>

						<div class="modal-body">
							<form action="'.site_url('manage_gallery/upload_images').'" method="post" enctype="multipart/form-data" class="dropzone" id="my-great-dropzone">
								<div class="fallback">
									<input type="file" name="images" class="d-none" multiple>
								</div>

								<input type="hidden" class="btn-gallery" name="getcatid" value="'.$row['id'].'">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">							
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>');

?>