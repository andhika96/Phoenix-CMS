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

namespace Aruna\Config;

defined('BASEPATH') OR exit('No direct script access allowed');

include BASEPATH.'libraries/Init_validation.php';

use Aruna\Init\Validation as InitValidation;

class validation extends InitValidation
{
	/* Create your custom rule function in this class */

	public function charlength($value)
	{
		if (strlen($value) <= 2)
		{
			$this->set_message('charlength', 'The {field} field must be at least 3 characters in length.');
			return false;
		}
		else
		{
			return true;
		}
	}
}

?>