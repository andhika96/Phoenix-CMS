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

	section_content(breadcrumb(['Awesome Admin' => site_url('awesome_admin'), 'Add Admin Account' => '']));

	section_content('
	<div class="mb-5">
		<div class="bg-white p-4 p-md-5 rounded shadow-sm" id="ar-app-form">
			<div class="sk-notice-toast position-relative" aria-live="polite" aria-atomic="true"></div>

			<form action="'.site_url('awesome_admin/addadminaccount').'" method="post" reset="true" @submit="submitData" ref="formHTML">
				<div class="row mb-3">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Email Address</label>
					
					<div class="col-md-5">
						<input type="text" name="email" class="form-control">
					</div>
				</div>

				<div class="row mb-3">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Username</label>
					
					<div class="col-md-5">
						<input type="text" name="username" class="form-control">
					</div>
				</div>

				<div class="row mb-3">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Fullname</label>
					
					<div class="col-md-5">
						<input type="text" name="fullname" class="form-control">
					</div>
				</div>

				<div class="row mb-3">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Password</label>
					
					<div class="col-md-5">
						<input type="password" name="password" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 offset-md-5 mt-2 text-right">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika font-size-inherit" value="Save">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>