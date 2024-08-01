<?php

namespace App\Validators;

/**
 * Trait for base validation functionality.
 */
trait BaseValidator
{
	public $validation;

	/**
	 * Process the validation and return the result.
	 *
	 * @return array
	 */
	public function process()
	{
		$this->validation->validate();
		if ($this->validation->fails()) {
			$error = $this->validation->errors()->firstOfAll()[array_key_first($this->validation->errors()->firstOfAll())];
			if (is_array($error)) {
				$error = $error[array_key_first($error)];
			}

			return ['success' => false, 'error' => $error, 'status' => 400];
		}

		return ['success' => true, 'input' => $this->validation->getValidData()];
	}
}