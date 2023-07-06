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

	section_content(breadcrumb([t('Manage Header') => site_url('manage_header'), t('Edit Header Menu') => '']));

	section_content('
	<style>
	.list-group-item 
	{
		cursor: move;
	}

	.ghost 
	{
		opacity: 0.5;
		background: #c8ebfb;
	}
	</style>

	<div class="container-fluid px-0" id="ar-app-listdata-header">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div class="row">
				<div class="col-md-6">
					<form action="'.site_url('manage_header/editpost/'.$id).'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" with-list-slideshow-page="false" with-list-coverimage-page="false" form-file-reset="true" ref="formHTML">
						<div class="ar-fetch-listdata-header mb-3" data-url="'.site_url('manage_header/getListHeaderMenuDetail/'.$id).'">
							<div v-if="getData == \'\'">
								No menu
							</div>

							<div v-else>
								<draggable v-model="getData" ghost-class="ghost" class="list-group">
									<div v-for="(item, index) in getData" :key="item.menu_type" class="list-group-item">
										<div class="row g-1">
											<div class="col-md-10 mb-3 mb-md-0 d-flex align-items-center">
												<i class="fas fa-arrows-alt-v fa-fw me-1"></i> {{ item.menu_name }}
											</div>

											<div class="col-auto d-flex align-items-center">
												<a href="javascript:void(0)" class="btn btn-link font-size-inherit" v-on:click="removeMenu(index)">'.t('Remove').'</a>
											</div>
										</div>
									</div>
								</draggable>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 offset-md-8 text-end">
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Save').'">
							</div>
						</div>
					</form>
				</div>

				<div class="col-md-6">
					<div class="row">
						<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Menu Type').'</label>

						<div class="col-md-8 mb-3">
							<select class="form-select font-size-inherit" aria-label="Select Menu Type" v-on:change="selectMenuType($event)">
								<option value="">Select</option>
								<option value="page">Page</option>
								<option value="custom_link">Custom Link</option>
							</select>

							<input type="hidden" name="get_menu_type" class="menu_type">
						</div>
					</div>

					<div class="row ar-form-header-type-page">
						<label class="col-md-4 col-form-label pr-md-0 text-md-end">'.t('Lists of Page').'</label>
						
						<div class="col-md-8 mb-3">
							<select name="menu_id" class="form-select font-size-inherit" aria-label="Select Menu" v-model="getNewMenu">
								<option value="">Select Menu</option>');
								
						foreach ($menus as $key => $value) 
						{	
							section_content('
								<option value="'.$value['name'].'">'.ucfirst($value['name']).'</option>');
						}

		section_content('
							</select>
						</div>
					</div>

					<div class="row ar-form-header-type-custom" style="display: none">
						<label class="col-md-4 col-form-label pr-md-0 text-md-end">'.t('Menu Name').'</label>
						
						<div class="col-md-8 mb-3">
							<input type="text" name="menu_name" class="form-control" v-model="getNewCustomMenu.menu_name">
						</div>

						<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Menu Link').'</label>
						
						<div class="col-md-8 mb-3">
							<input type="text" name="menu_link" class="form-control" v-model="getNewCustomMenu.menu_link">
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 offset-md-8 text-end">
							<a href="#!" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" v-on:click="addMenu">'.t('Add').'</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>');

?>