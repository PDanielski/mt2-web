<?php


namespace App\Form;


class FormErrors {

    protected $fieldErrors = [];

    protected $globalErrors = [];

    public function addFieldError($fieldName, $errorMessage){
        $this->fieldErrors[$fieldName] = $errorMessage;
    }

    public function addGlobalError($errorMessage) {
        $this->globalErrors[$errorMessage];
    }

    public function hasErrors(): bool {
        return count($this->fieldErrors) > 0 || count($this->globalErrors) > 0;
    }

    public function toJson() {
        $schema = [
            'fieldErrors' => []
        ];

        foreach($this->fieldErrors as $fieldName => $fieldError) {
            $schema['fieldErrors'][] = [
                'field' => $fieldName,
                'message' => $fieldError
            ];
        }

        return json_encode($schema);
    }

}