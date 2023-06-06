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

	section_content(breadcrumb([t('Manage Section Content') => '', t('Footer Section') => '']));

	section_content('
	<div id="ar-app-listform">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="pilllist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="footer-image-content-tab" data-bs-toggle="pill" data-bs-target="#footer-image-content" type="button" role="tab" aria-controls="footer-image-content-pill-pane" aria-selected="true">Footer Image & Content</button>
			</li>
			
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="footer-link1-tab" data-bs-toggle="pill" data-bs-target="#footer-link1" type="button" role="tab" aria-controls="footer-link1-pill-pane" aria-selected="false">Footer Link 1</button>
			</li>
			
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="footer-link2-tab" data-bs-toggle="pill" data-bs-target="#footer-link2" type="button" role="tab" aria-controls="footer-link2-pill-pane" aria-selected="false">Footer Link 2</button>
			</li>
			
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="footer-link3-tab" data-bs-toggle="pill" data-bs-target="#footer-link3" type="button" role="tab" aria-controls="footer-link3-pill-pane" aria-selected="false">Footer Link 3</button>
			</li>
		</ul>

		<div class="tab-content" id="pills-tabContent">
			<div class="tab-pane fade show active" id="footer-image-content" role="tabpanel" aria-labelledby="footer-image-content-pill-tab" tabindex="0">
				Coming Soon
			</div>
			
			<div class="tab-pane fade" id="footer-link1" role="tabpanel" aria-labelledby="footer-link1-pill-tab" tabindex="1">
				'.$__footer_link_1.'
			</div>

			<div class="tab-pane fade" id="footer-link2" role="tabpanel" aria-labelledby="footer-link2-pill-tab" tabindex="2">
				'.$__footer_link_2.'
			</div>

			<div class="tab-pane fade" id="footer-link3" role="tabpanel" aria-labelledby="footer-link3-pill-tab" tabindex="3">
				'.$__footer_link_3.'
			</div>
		</div>
	</div>');


?>