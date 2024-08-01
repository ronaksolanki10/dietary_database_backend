<?php

namespace App\Validators\Common;

use Rakit\Validation\Validator;
use App\Validators\BaseValidator;
use App\Helpers\Request;

/**
 * Validator for file uploads in the create with upload process.
 */
class CreateWithUploadValidator extends Validator
{
    use BaseValidator;

    /**
     * Perform the validation process.
     *
     * @return array
     */
    public function doValidation()
    {
        $this->validation = $this->make(Request::post(), [
            'file' => 'required|uploaded_file:0,5000k,csv'
        ]);

        return $this->process();
    }
}