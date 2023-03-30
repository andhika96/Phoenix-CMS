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

	section_content(breadcrumb(['Gallery' => site_url('manage/gallery'), 'List of Photos' => '', $row['name'] => '']));

	section_content('
	<link rel="stylesheet" href="'.base_url('assets/plugins/dropzone/5.7.0/dist/min/dropzone.min.css').'">

	<div class="container-fluid">
		<div id="ar-list-photo-dashboard">
			<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm ar-fetch-listphoto" id="ar-listphotos" data-uri="'.site_url('manage/getListPhotos/'.$row['id']).'">
				<div class="h5 pb-3 pb-md-4 mb-4 border-bottom d-flex justify-content-between align-items-center"><div><i class="fas fa-images fa-fw mr-2"></i> List of Photos</div> <div><span class="float-md-right font-size-normal"><a href="javascript:void(0);" v-on:click="openNewUploadPopup">Upload Photos</a></div></div>

				<div v-if="loading" class="text-center py-3 lead">Loading ...</div>

				<div v-else-if="isData" class="text-center text-danger">
					{{ msgData }}
				</div>

				<div v-else>
					<div v-if="loadingnextpage" class="d-flex justify-content-center h4 my-5 py-5 vh-100">Loading ...</div>

					<div v-else>
						<transition-group name="custom-classes-transition" enter-active-class="animate__animated animate__fadeIn animate__faster" tag="div" class="row" uk-lightbox="animation: slide">
							<div class="col-md-3 mb-4 text-center" v-for="(info, index) in getData" v-bind:key="info.id">
								<a :href="\'\'+info.uri+\'\'" data-type="image" data-alt="Image" class="rounded">
									<div class="d-flex justify-content-center align-items-center text-center rounded shadow-sm ar-thumb-undefined mb-2" :style="{ \'background-image\': \'url(\' + info.thumbnail + \')\', \'background-position\': \'center center\', \'background-size\': \'cover\', \'background-repeat\': \'no-repeat\', \'width\': \'100% !important\', \'height\': \'150px !important\' }"></div>
								</a>

								<button type="button" v-on:click="initDeletePopupData(getData, index, info.id); show = !show" class="btn btn-link p-0 ar-alert-bootbox" v-bind:data-url="\''.site_url('manage/deletephoto/').'\'">Delete</button>
							</div>
						</transition-group>
					</div>
					
					<paginate :page-count="pageCount" :page-range="pageRange" :container-class="\'pagination mt-4\'" :page-class="\'page-item\'" :prev-class="\'page-item\'" :next-class="\'page-item\'" :page-link-class="\'page-link\'" :prev-link-class="\'page-link\'" :next-link-class="\'page-link\'" :click-handler="clickPaginate" v-model="currPage"></paginate>
				</div>

				<!--- Start Modal --->
				<div class="modal fade" id="NewPhotoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="NewCatGallModal" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Upload Photos</h5>
								<button type="button" class="close" aria-label="Close" v-on:click="closeNewUploadPopup">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<div class="modal-body p-1">
								<form action="'.site_url('manage/getUploadPhoto').'" method="post" enctype="multipart/form-data" class="dropzone" id="ar-file-upload">
									<div class="fallback">
										<input type="file" name="photos">
									</div>

									<input type="hidden" class="btn-gallery" name="getcatid" value="'.$row['id'].'">
									<input type="hidden" class="btn-token" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								</form>
							</div>
						</div>
					</div>
				</div>
				<!--- End of Modal --->
			</div>
		</div>
	</div>');

?>