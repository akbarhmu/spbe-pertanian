<?php

    /**
     * Form Input With Validation
     *
     * Generates a form input field with optional validation error display.
     *
     * @param string $type        Input type (e.g., text, email, password)
     * @param string $id          Input name and ID
     * @param string $label       Input label
     * @param string|null $value  Input value (default: null)
     * @param bool $required      Indicates whether the input is required (default: false)
     * @param string|null $placeholder  Input placeholder (default: null)
     * @param string|null $class  Additional CSS class for the input (default: null)
     *
     * @return string             The HTML code for the form input with optional validation error display
     */
    function form_input_with_validation($type, $id, $label, $value = null, $required = false, $placeholder = null, $class = null)
    {
        $requiredAttribute = $required ? 'required' : '';
        $placeholderText = $placeholder ? $placeholder : $label;
        $classAttribute = $class ? $class : '';
        $valueAttribute = $value ? $value : old($id);
        $error = validation_show_error($id, 'single_error');
        $isInvalid = (isset(validation_errors()[$id])) ? 'is-invalid' : '';

        return <<<HTML
        <input type="$type" id="$id" class="form-control $classAttribute $isInvalid" name="$id" value="$valueAttribute" $requiredAttribute placeholder="$placeholderText">
        $error
        HTML;
    }
