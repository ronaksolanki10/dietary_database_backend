<?php

namespace App\Validators\AuthValidators;

use App\Validators\BaseValidator;
use App\Helpers\Request;
use Rakit\Validation\Validator;

/**
 * Class LoginValidator
 *
 * Handles validation for login requests.
 */
class LoginValidator extends Validator
{
    use BaseValidator;

    /**
     * Perform validation for login credentials.
     *
     * @return array The result of the validation process.
     */
    public function doValidation(): array
    {
        $this->validation = $this->make(Request::post(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        return $this->process();
    }
}