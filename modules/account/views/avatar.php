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
	<div class="row">
		<div class="col-md-4 mb-4">
			<div class="bg-white arv3-pc-content p-3 rounded shadow-sm">
				<div class="h5 pb-3 pb-md-3 mb-3 border-bottom"><i class="fas fa-cog fa-fw me-2"></i> Account Menu</div>

				<div class="list-group list-group-flush">
					<a href="'.site_url('account/index').'" class="list-group-item px-2 py-3"><i class="fas fa-address-card fa-fw me-1"></i> Account Settings</a>
					<a href="'.site_url('account/password').'" class="list-group-item px-2 py-3"><i class="fas fa-key fa-fw me-1"></i> Password</a>
					<a href="'.site_url('account/avatar').'" class="list-group-item px-2 py-3"><i class="fas fa-user-circle fa-fw me-1"></i> Avatar</a>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="bg-white mb-5 p-3 p-md-4 rounded shadow-sm" id="ar-app-form-croppie">
				<div class="h5 pb-3 pb-md-3 mb-4 border-bottom"><i class="fas fa-user-circle fa-fw me-2"></i> Avatar</div>
				<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

				<form action="'.site_url('account/avatar').'" method="post" enctype="multipart/form-data" button-block="false" data-reset="false" datafile-reset="false" @submit="submit" ref="formHTML">
					<div class="row mb-4">
						<div class="col-md-6 offset-md-3">
							<div class="croppie rounded h-auto"></div>

							<div class="custom-file">
								<label for="formFile" class="form-label">Choose file</label>
								<input type="file" name="userfile" class="form-control font-size-inherit upload" id="formFile" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 offset-md-3 text-end">
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-normal" value="Save changes">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>');

?>