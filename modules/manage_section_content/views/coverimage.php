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
		<div class="arv6-box bg-white p-3 p-md-4 rounded">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-images fa-fw me-2"></i> Cover Image</div>

			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Page</th>
						<th scope="col">Option</th>
					</tr>
				</thead>

				<tbody>');

	$i = 1;
	foreach ($row as $key => $value) 
	{
		section_content('
					<tr>
						<th scope="row">'.$i.'</th>
						<td>'.ucfirst($value['name']).'</td>
						<td><a href="'.site_url('manage_appearance/editcoverimage/'.$value['name']).'" class="btn btn-light font-size-inherit"><i class="fas fa-edit"></i></a></td>
					</tr>');

		$i++;
	}

	section_content('
				</tbody>
			</table>
		</div>
	</div>');

?>