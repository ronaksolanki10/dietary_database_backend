<?php

namespace App\Validators\FoodItemValidators;

use Rakit\Validation\Validator;
use App\Validators\BaseValidator;
use App\Helpers\Request;

/**
 * Validator for creating food items.
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
		    'category' => 'required|in:'.$_ENV['FOOD_CATEGORIES'],
		    'iddsi_levels' => 'required|array',
		    'iddsi_levels.*' => 'required|integer|in:'.$_ENV['IDDSI_LEVELS']
		]);

		return $this->process();
	}
}