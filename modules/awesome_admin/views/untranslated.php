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

	section_content(breadcrumb(['Awesome Admin' => site_url('awesome_admin'), 'Translate' => site_url('awesome_admin/translate'), 'Untranslated' => '']));

	section_content('
	<div class="mb-5">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm" id="ar-translate">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<span class="fa-layers fa-fw fa-lg mr-2">
						<i class="fad fa-language mt-1"></i>
						<span class="fa-layers-counter fa-layers-top-right bg-danger shadow-sm mt-1"><i class="fas fa-times"></i></span>
					</span>
					
					Untranslated
				</div>

				<div class="font-weight-normal font-size-normal">
					You currently in <strong>'.ucfirst(get_language()).'</strong> language
				</div>
			</div>

			<form action="'.site_url('awesome_admin/translated').'" method="post" @submit.prevent="submit" ref="formHTML" class="ar-translate-form">');

		$i = 0;
		$res = $db->sql_prepare("select * from ml_language where lang = :lang and lang_to = :lang_to order by id desc limit $offset, $num_per_page");
		$bindParam = $db->sql_bindParam(['lang' => get_language(), 'lang_to' => ''], $res);
		while ($row = $db->sql_fetch_single($bindParam))
		{
			section_content('
				<div class="mb-3">
					<div class="form-group">
						<label>('.$row['lang_from'].')</label>

						<textarea name="lang['.$i.'][to]" class="form-control" rows="2">'.$row['lang_to'].'</textarea>
						<input type="hidden" name="lang['.$i.'][id]" value="'.$row['id'].'">
					</div>
				</div>');

			$i++;
		}

		if ( ! $db->sql_counts($res))
		{
			section_content('<div class="text-danger text-center">No data</div>');
		}

		if ($db->sql_counts($res))
		{
			section_content('
				<div class="text-right">
					<input type="hidden" name="step" value="post">
					<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
					<input type="submit" class="btn btn-malika-submit" value="Save">
				</div>');
		}

		$res_page = $db->sql_prepare("select count(lang) as num from ml_language where lang = :lang and lang_to = :lang_to");
		$bindParam_page = $db->sql_bindParam(['lang' => get_language(), 'lang_to' => ''], $res_page);
		$total_page = $db->sql_fetch_single($bindParam_page);

		$config['total_rows'] 	= $total_page['num'];
		$config['base_url']		= 'awesome_admin/translated';
		$config['style_class']	= 'justify-content-center';

		section_content('
			</form>

			<div class="pt-3">'.pagination($config).'</div>
		</div>
	</div>');

?>