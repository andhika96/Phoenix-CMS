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
	<div class="container-fluid px-0">
		<div class="row" id="ar-app-listdata-header">
			<div class="col-md-6 mb-4 mb-md-0">
				<div class="arv6-box bg-white arv3-pc-content p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fad fa-folder-open fa-fw me-1"></i> '.t('List of Header Menu').'</div>

					<div v-if="loading" class="text-center p-5">
						<div class="spinner-border text-primary mb-2" role="status">
							<span class="sr-only"></span>
						</div>

						<div class="h6">Loading ...</div>
					</div>

					<div v-else class="ar-data-load" style="display: none">
						<transition-group name="ar-fade" class="list-group list-group-flush ar-fetch-listdata-header" tag="ul" data-url="'.site_url('manage_header/getListHeader').'">
							<li class="list-group-item list-group-item-action" v-for="(info, index) in getData" v-bind:key="info.id" v-if="info.id">
								{{ info.capitalize_hmenu_name }} <span class="float-end"><a :href="\''.site_url('manage_header/editpost/\'+info.id+\'').'\'">Edit</a> <a href="javascript:void(0)" v-on:click="deleteData(getData, index, info.id); showData = !showData" class="ar-alert-bootbox d-none" v-bind:data-url="\''.site_url('manage_header/deletecategory/').'\'">Delete</a></span>
							</li>
						</transition-group>
					</div>
				</div>
			</div>

			<div class="col-md-6" id="ar-form-submit">
				<div class="arv6-box bg-white arv3-pc-content p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fad fa-folder-plus fa-fw me-1"></i> '.t('Add New Header').'</div>
					
					<div class="h6 text-center mb-0">Coming Soon</div>
				</div>
			</div>
		</div>
	</div>');

?>