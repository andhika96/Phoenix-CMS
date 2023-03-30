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

	section_content('
	<div class="container-fluid">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-listgallery">
			<div class="h5 pb-3 pb-md-4 mb-4 border-bottom d-flex justify-content-between align-items-center"><div><i class="fas fa-images fa-fw mr-2"></i> Gallery</div> <div><span class="float-md-right font-size-normal"><a href="javascript:void(0);" v-on:click="openNewCatPopup">Add New Category</a></div></div>

			<transition-group name="ar-fade" tag="ul" class="list-group list-group-flush ar-list-group-flush ar-fetch-listgallery" data-uri="'.site_url('manage/getListGallery').'">
				<li class="list-group-item list-group-item-action px-0" v-for="(info, index) in getData" v-bind:key="info.id">
					<div class="row no-gutters">
						<div class="col-md-9">
							<div class="row no-gutters">
								<div class="col-12 col-sm-auto pr-sm-3 mb-2 mb-sm-0">
									<div v-if="info.thumbnail == \'\'">
										<div class="d-flex justify-content-center align-items-center text-center rounded ar-thumb-undefined" style="background: #4eb9ec !important">
											<div><i class="fa-inverse fas fa-images fa-3x"></i></div>
										</div>
									</div>

									<div v-else>
										<div class="d-flex justify-content-center align-items-center text-center rounded shadow-sm ar-thumb-undefined" :style="{ \'background-image\': \'url(\' + info.thumbnail + \')\', \'background-position\': \'center center\', \'background-size\': \'cover\', \'background-repeat\': \'no-repeat\' }"></div>
									</div>
								</div>

								<div class="col-12 col-sm-8 text-left">
									<a :href="\''.site_url('manage/listphotos/\'+info.code+\'').'\'">
										<h5 class="lh-6 text-truncate">{{ info.name }}</h5>
									</a>

									<p class="font-size-inherit mb-2">{{ info.caption }}</p>
								</div>
							</div>
						</div>

						<div class="col-md-3 d-flex align-items-center justify-content-end">
							<a :href="\''.site_url('manage/editgallery/\'+info.id+\'').'\'">Edit</a> - <a href="javascript:void(0)" v-on:click="initDeletePopupData(getData, index, info.id); show = !show" class="ar-alert-bootbox" v-bind:data-url="\''.site_url('manage/deletegallery/').'\'">Delete</a>
						</div>
					</div>
				</li>
			</transition-group>

			<!--- Start Modal --->
			<div class="modal fade" id="NewCatGallModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="NewCatGallModal" aria-hidden="true">
				<div id="ar-toast-web" class="sk-notice-toast d-none d-md-block position-relative" aria-live="polite" aria-atomic="true"></div>

				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Add New Category for Gallery</h5>
							<button type="button" class="close" aria-label="Close" v-on:click="closeNewCatPopup">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body p-0 pt-3">
							<div id="ar-toast-mobile" class="sk-notice-toast d-block d-md-none position-relative" aria-live="polite" aria-atomic="true"></div>

							<form action="'.site_url('manage/gallery').'" method="post" class="px-3 pb-3" wbtn-block="1" data-reset="true" @submit="submit" ref="formHTML">
								<div class="form-group mb-3">
									<label>Category Name</label>
									<input type="text" name="newcategory" class="form-control">
								</div>

								<div class="form-group mb-3">
									<label>Caption</label>
									<textarea name="caption" rows="6" class="form-control"></textarea>
								</div>

								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-bnight-blue" value="Add">
							</form>
						</div>
					</div>
				</div>
			</div>
			<!--- End of Modal --->

		</div>
	</div>');

?>