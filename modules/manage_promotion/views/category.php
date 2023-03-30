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

	if (get_module_actived('promotion') == 0)
	{
		section_content('
		<div class="bg-warning p-3 rounded mb-3 text-dark bg-opacity-25">
			<i class="fad fa-exclamation-triangle fa-lg fa-fw me-1"></i> '.t('The {1} page has been disabled, but you can still manage content from this page', ucfirst(get_module('promotion', 'name'))).'
		</div>');
	}

	section_content(breadcrumb([t('Manage Promotion') => site_url('manage_promotion'), t('List of Category') => '']));

	section_content('
	<div class="container-fluid px-0">
		<div class="row" id="ar-app-listdata">
			<div class="col-md-6 mb-4 mb-md-0">
				<div class="arv6-box bg-white arv3-pc-content p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fad fa-folder-open fa-fw me-1"></i> '.t('List of Category').'</div>

					<div v-if="loadingWOPage" class="text-center p-5">
						<div class="spinner-border text-primary mb-2" role="status">
							<span class="sr-only"></span>
						</div>

						<div class="h6">Loading ...</div>
					</div>

					<div v-else class="ar-data-load" style="display: none">
						<transition-group name="ar-fade" class="list-group list-group-flush ar-fetch-listdata-wopage" tag="ul" data-url="'.site_url('manage_promotion/getListCategories').'">
							<li class="list-group-item list-group-item-action" v-for="(info, index) in getDataWOPage" v-bind:key="info.id" v-if="info.id">
								{{ info.name }} <span class="float-end"><a :href="\''.site_url('manage_promotion/editcategory/\'+info.id+\'').'\'">Edit</a> - <a href="javascript:void(0)" v-on:click="deleteData(getDataWOPage, index, info.id); showData = !showData" class="ar-alert-bootbox" v-bind:data-url="\''.site_url('manage_promotion/deletecategory/').'\'">Delete</a></span>
							</li>
						</transition-group>
					</div>
				</div>
			</div>

			<div class="col-md-6" id="ar-form-submit">
				<div class="arv6-box bg-white arv3-pc-content p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fad fa-folder-plus fa-fw me-1"></i> '.t('Add New Category').'</div>
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<form action="'.site_url('manage_promotion/category').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" ref="formHTML">
						<div class="form-group mb-3">
							<label class="form-label">'.t('Category Name').'</label>
							<input type="text" name="newcategory" class="form-control">
						</div>

						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit" value="'.t('Add').'">
					</form>
				</div>
			</div>
		</div>
	</div>');

?>