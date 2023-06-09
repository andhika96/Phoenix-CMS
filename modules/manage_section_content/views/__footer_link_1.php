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

	echo '
	<div class="container-fluid px-0 mb-5">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fad fa-list-ul fa-fw me-2"></i> '.t('Edit Footer Link').' 1
				</div> 

				<div>
					<span class="float-md-right font-size-normal"><a href="javascript:void(0)" v-on:click="addNewForm(\'list_footer1\')">New Form</a></span>
				</div>
			</div>

			<div id="ar-form-submit-1">	
				<form action="'.site_url('manage_section_content/footer').'" method="post" enctype="multipart/form-data" @submit.prevent="multipleSubmit($event, \'1\')" ref="formHTML1" button-block="false" button-rounded-pill="false" font-size-large="false">						
					<div class="toast ar-notice-toast-1 position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>					

					<div class="col-12 mb-4" v-for="(info, index) in getListFooter1" :key="index">
						<div class="row mb-2">
							<div class="col-md-6">
								<h6>- Link {{ index+1 }}</h6>
							</div>

							<div class="col-md-6 text-md-end">
								<a href="javascript:void(0)" v-on:click="deleteForm(getListFooter1, index); showData = !showData" class="text-danger text-underline ar-alert-bootbox font-size-inherit" v-bind:data-url="\''.site_url('manage_appearance/deleteslideshow/').'\'">Delete Link</a>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3 mb-md-0">
								<label class="form-label">Icon</label>								

								<div class="input-group">
									<span class="input-group-text" id="basic-addon1"><i :id="\'IconPreviewListFooter1_\'+index+\'\'" :class="\'\'+info.icon+\'\'"></i></span>
									<input type="text" :name="\'footer_right_link1[\'+index+\'][icon]\'" class="form-control font-size-inherit" :id="\'IconInputListFooter1_\'+index+\'\'" :value="\'\'+info.icon+\'\'">
									<button :class="\'btn btn-outline-secondary font-size-inherit GetFAIconListFooter1 GetIconPickerListFooter1_\'+index+\'\'" :data-iconpicker-input="\'input#IconInputListFooter1_\'+index+\'\'" :data-iconpicker-preview="\'i#IconPreviewListFooter1_\'+index+\'\'" type="button"><i class="fad fa-search fa-fw me-1"></i> Search Icon</button>
								</div>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Title</label>								

								<div class="input-group">
									<input type="text" :name="\'footer_right_link1[\'+index+\'][content]\'" class="form-control font-size-inherit" :value="\'\'+info.content+\'\'">
								</div>
							</div>

							<div class="col-12">
								<label class="form-label">Link</label>								

								<div class="input-group">
									<input type="text" :name="\'footer_right_link1[\'+index+\'][link]\'" class="form-control font-size-inherit" :value="\'\'+info.link+\'\'">
								
									<input type="hidden" :name="\'footer_right_link1[\'+index+\'][type]\'" :value="\'text\'">
								</div>
							</div>
						</div>
					</div>

					<div class="d-flex justify-content-end">
						<div>
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit-1" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit btn-malika-submit-1" value="'.t('Save').'">
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>';


?>