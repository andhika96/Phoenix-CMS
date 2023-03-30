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

	section_content(breadcrumb([t('Manage Appearance') => '', t('Logo') => '']));

	section_content('
	<div class="container-fluid px-0" id="ar-app-listdata">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<form action="'.site_url('manage_appearance/logo').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" ref="formHTML">
				<div class="row g-2 mb-4">
					<label for="formFileDesktopHomepageLogo" class="col-md-2 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Desktop Homepage Logo').'</label>
					
					<div class="col-md-5">
						<input class="form-control font-size-inherit" type="file" name="logo[desktop_homepage]" id="formFileDesktopHomepageLogo">
					</div>

					<div class="col-md-2">
						<input class="form-control font-size-inherit" type="text" name="logo_desktop_homepage_size" id="formFileDesktopHomepageLogo" placeholder="Size in px" value="'.get_logo(1, 'size').'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="formFileDesktopHomepageLogo" class="col-md-2 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Mobile Homepage Logo').'</label>
					
					<div class="col-md-5">
						<input class="form-control font-size-inherit" type="file" name="logo[mobile_homepage]" id="formFileDesktopHomepageLogo">
					</div>

					<div class="col-md-2">
						<input class="form-control font-size-inherit" type="text" name="logo_mobile_homepage_size" id="formFileDesktopHomepageLogo" placeholder="Size in px" value="'.get_logo(2, 'size').'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="formFileDesktopDashboardLogo" class="col-md-2 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Desktop Dashboard Logo').'</label>
					
					<div class="col-md-5">
						<input class="form-control font-size-inherit" type="file" name="logo[desktop_dashboard]" id="formFileDesktopDashboardLogo">
					</div>

					<div class="col-md-2">
						<input class="form-control font-size-inherit" type="text" name="logo_desktop_dashboard_size" id="formFileDesktopDashboardLogo" placeholder="Size in px" value="'.get_logo(3, 'size').'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="formFileMobileHomepageLogo" class="col-md-2 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Mobile Dashboard Logo').'</label>
					
					<div class="col-md-5">
						<input class="form-control font-size-inherit" type="file" name="logo[mobile_dashboard]" id="formFileMobileHomepageLogo">
					</div>

					<div class="col-md-2">
						<input class="form-control font-size-inherit" type="text" name="logo_mobile_dashboard_size" id="formFileMobileHomepageLogo" placeholder="Size in px" value="'.get_logo(4, 'size').'">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 offset-md-6 mt-2 text-end">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Save').'">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>