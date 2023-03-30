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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Roles' => '']));

	section_content('
	<div class="mb-5">
		<div class="row" id="ar-app-listdata">
			<div class="col-md-6 mb-4 mb-md-0">
				<div class="arv6-box bg-white p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fad fa-project-diagram fa-fw me-2"></i> List of Roles</div>

					<div v-if="loadingWOPage" class="text-center p-5">
						<div class="spinner-border text-primary mb-2" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>

						<div class="h6">Loading ...</div>
					</div>

					<div v-else class="ar-data-load" style="display: none">
						<transition-group name="ar-fade" class="list-group list-group-flush ar-fetch-listdata-wopage" tag="ul" data-url="'.site_url('awesome_admin/getListRole').'">
							<li class="list-group-item list-group-item-action" v-for="(info, index) in getDataWOPage" v-bind:key="info.id" v-if="info.id">
								{{ info.name }} 

								<span v-if="info.code_name !== \'administrator\' && info.code_name !== \'owner\' && info.code_name !== \'web_master\' && info.code_name !== \'staff\'">
									<span class="float-end"><a :href="\''.site_url('awesome_admin/editrole/\'+info.id+\'').'\'">Edit</a> - <a href="javascript:void(0)" v-on:click="deleteData(getData, index, info.id); show = !show" class="ar-alert-bootbox" v-bind:data-url="\''.site_url('awesome_admin/deleterole/').'\'">Delete</a></span>
								</span>
							</li>
						</transition-group>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="arv6-box bg-white arv3-pc-content p-3 py-md-4 px-md-3 rounded shadow-sm">
					<div class="h5 pb-4 mb-3 border-bottom"><i class="fas fa-plus-square fa-fw me-2"></i> Add New Role</div>
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div id="ar-form-submit">
						<form action="'.site_url('awesome_admin/roles').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" ref="formHTML">
							<div class="form-group mb-3">
								<label class="form-label">Role Name</label>
								<input type="text" name="role_name" class="form-control font-size-inherit">
							</div>

							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit font-size-inherit" value="Add">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>');

?>