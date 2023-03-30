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

	section_content(breadcrumb(['Sections' => site_url('manage/sections'), 'Edit Section' => '', $name_page => '']));

	section_content('
	<div <div class="container-fluid" id="ar-app-form">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>
			
			<form action="'.site_url('manage/editsection/'.$row['uri']).'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">');

	$json_decode = json_decode($row['var'], true);

	foreach ($json_decode as $keys => $values) 
	{
		$section_title = str_replace("_", " ", $keys);
		$section_title = ucwords($section_title);

		section_content('
				<div class="h5 pb-3 mb-3 border-bottom"><i class="fas fa-columns fa-fw mr-2"></i> '.$section_title.'</div>
				<div class="row mb-4">
					<div class="col-md-6">
						<div class="row">');

		foreach ($values as $key => $value) 
		{
			if ( ! empty($value['alias']))
			{
				$label = str_replace("_", " ", $value['alias']);
				$label = ucwords($label);
			}
			else
			{
				$label = str_replace("_", " ", $key);
				$label = ucwords($label);
			}

			if ($value['type'] == 'file')
			{	
				section_content('
								<div class="col-12 form-group mb-3">
									<label class="form-label">'.$label.'</label>
									<input type="'.$value['type'].'" name="get_'.$keys.'['.$key.']" class="form-control" id="file">
								</div>');
			}
			elseif ($value['type'] == 'text')
			{
				$title_link = isset($value['link']) ? 'Title link here' : '';

				section_content('
								<div class="col-12 form-group mb-3">
									<label class="form-label">'.$label.'</label>
									<input type="'.$value['type'].'" name="get_'.$keys.'['.$key.']" placeholder="'.$title_link.'" class="form-control" value="'.$value['content'].'">');

							if (isset($value['link']))
							{	
								section_content('
									<input type="'.$value['type'].'" name="get_'.$keys.'['.$key.'_link]" placeholder="Link here" class="form-control mt-2" value="'.$value['link'].'">');
							}

				section_content('
								</div>');
			}
		}

		section_content('
						</div>
					</div>

					<div class="col-md-6">
						<div class="row">');

		foreach ($values as $key => $value) 
		{
			if ( ! empty($value['alias']))
			{
				$label = str_replace("_", " ", $value['alias']);
				$label = ucwords($label);
			}
			else
			{
				$label = str_replace("_", " ", $key);
				$label = ucwords($label);
			}

			if ($value['type'] == 'textarea')
			{
				section_content('
								<div class="col-12 mb-3">
									<div class="form-group">
										<label class="form-label">'.$label.'</label>
										<textarea name="get_'.$keys.'['.$key.']" rows="12" class="form-control">'.$value['content'].'</textarea>
									</div>
								</div>');
			}
		}

		section_content('
						</div>
					</div>
				</div>');
	}

	section_content('
				<input type="hidden" name="step" value="post">
				<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
				<input type="submit" class="btn btn-bnight-blue btn-malika-submit" value="Submit">
			</form>
		</div>
	</div>');

?>