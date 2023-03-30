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

	section_content(breadcrumb(['Awesome Admin' => site_url('awesome_admin'), 'Roles' => site_url('awesome_admin/roles'), 'Edit Role' => '']));

	section_content('
	<div class="mb-5">
		<div class="arv6-box bg-white p-4 p-md-5 rounded shadow-sm" id="ar-app-form">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div id="ar-form-submit">
				<form action="'.site_url('awesome_admin/editrole/'.$id).'" method="post" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
					<div class="row mb-3">
						<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-end">Role Name</label>
						
						<div class="col-md-5">
							<input type="text" name="role_name" class="form-control" value="'.$name.'">
						</div>

						<div class="col-md-4 offset-md-5 mt-2 text-end">
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit font-size-inherit" value="Save">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>');

?>