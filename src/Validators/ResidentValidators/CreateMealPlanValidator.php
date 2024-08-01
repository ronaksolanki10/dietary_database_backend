<?php

namespace App\Validators\ResidentValidators;

use Rakit\Validation\Validator;
use App\Validators\BaseValidator;
use App\Helpers\Request;

/**
 * Validator for creating a resident meal plan.
 */
class CreateMealPlanValidator extends Validator
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
		    'resident_id' => 'required',
		    'food_item_id' => 'required'
		]);

		return $this->process();
	}
}