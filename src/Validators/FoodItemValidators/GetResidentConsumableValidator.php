<?php

namespace App\Validators\FoodItemValidators;

use Rakit\Validation\Validator;
use App\Validators\BaseValidator;
use App\Helpers\Request;

/**
 * Validator for retrieving consumable food items for a resident.
 */
class GetResidentConsumableValidator extends Validator
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
		    'resident_id' => 'required|integer'
		]);

		return $this->process();
	}
}