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
	<div class="container-fluid">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm">
			<div class="h5 pb-3 pb-md-3 mb-4 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fas fa-columns fa-fw mr-2"></i> Manage Sections
					<div class="mt-3 font-size-normal font-weight-normal"><i class="fas fa-info-circle fa-fw mr-1 text-info"></i> Halaman ini berfungsi untuk mengganti bagian header dan footer (section) pada halaman depan, seperti mengganti logo, link footer, footer message, dsb.</div>
				</div>
			</div>

			<ul class="list-group list-group-flush ar-list-group-flush">');
	
	$res = $db->sql_select("select * from ml_section order by id asc");
	while ($row = $db->sql_fetch_single($res))
	{
		section_content('
				<li class="list-group-item list-group-item-action px-0">
					<div class="row no-gutters">
						<div class="col-12 col-sm-auto pr-sm-3 mb-2 mb-sm-0">
							<div class="d-flex justify-content-center align-items-center text-center rounded ar-thumb-undefined" style="background: #4eb9ec !important">
								<div><i class="fa-inverse fas fa-swatchbook fa-3x"></i></div>
							</div>
						</div>

						<div class="col-12 col-sm-8 text-left">
							<h5 class="lh-6 text-truncate"><a href="'.site_url('manage/editsection/'.$row['uri']).'" class="text-decoration-none">'.$row['name'].'</a></h5>
							<div class="text-muted">'.get_date($row['updated']).'</div>
						</div>
					</div>
				</li>');
	}		

	section_content('
			</ul>
		</div>
	</div>');

?>