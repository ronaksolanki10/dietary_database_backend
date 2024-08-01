<?php

namespace App\Validators\ResidentValidators;

use Rakit\Validation\Validator;
use App\Validators\BaseValidator;
use App\Helpers\Request;

/**
 * Validator for creating a resident.
 */
class CreateValidator extends Validator
{
	use BaseValidator;

	/**
	 * Perform validation on the request data.
	 *
	 * @return array
	 */
	public function doValidation() 
	{
		$this->validation = $this->make(Request::post(), [
		    'name' => 'required',
		    'iddsi_level' => 'required|integer|in:'.$_ENV['IDDSI_LEVELS']
		]);

		return $this->process();
	}
}