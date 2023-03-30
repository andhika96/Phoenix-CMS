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

		<div class="col-md-8" id="ar-app-form">
			<div class="bg-white mb-5 p-3 p-md-4 rounded shadow-sm" id="ar-app-form">
				<div class="h5 pb-3 pb-md-3 mb-4 border-bottom" id="ar-content"><i class="fas fa-key fa-fw me-2"></i> Password</div>
				<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

				<div id="ar-form-submit">
					<form action="'.site_url('account/password').'" method="post" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
						<div class="row">
							<div class="col-12 mb-3">
								<div class="form-group">
									<label class="form-label">Old Password</label>
									<input type="password" name="old_password" placeholder="Old Password" class="form-control font-size-inherit" autocomplete="off">
								</div>
							</div>		

							<div class="col-12 mb-3">
								<div class="form-group">
									<label class="form-label">New Password</label>
									<input type="password" name="new_password" placeholder="New Password" class="form-control font-size-inherit" autocomplete="off">
								</div>
							</div>

							<div class="col-12 mb-3">
								<div class="form-group">
									<label class="form-label">Password Confirmation</label>
									<input type="password" name="password_conf" placeholder="Re-type new password" class="form-control font-size-inherit" autocomplete="off">
								</div>
							</div>

							<div class="col-12 text-end">
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="Save changes">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>');

?>