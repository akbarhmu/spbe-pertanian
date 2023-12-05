<?php

    /**
     * Form Input With Validation
     *
     * Generates a form input field with optional validation error display.
     *
     * @param string $type        Input type (e.g., text, email, password)
     * @param string $id          Input name and ID
     * @param string|null $value  Input value (default: null)
     * @param bool $required      Indicates whether the input is required (default: false)
     * @param string|null $placeholder  Input placeholder (default: null)
     * @param string|null $class  Additional CSS class for the input (default: null)
     *
     * @return string             The HTML code for the form input with optional validation error display
     */
    function form_input_with_validation($type, $id, $value = null, $required = false, $placeholder = null, $class = null)
    {
        $requiredAttribute = $required ? 'required' : '';
        $placeholderText = $placeholder ? $placeholder : '';
        $classAttribute = $class ? $class : '';
        $valueAttribute = ($value && $type != 'password') ? $value : old($id);
        $error = validation_show_error($id, 'single_error');
        $isInvalid = (isset(validation_errors()[$id])) ? 'is-invalid' : '';
        $accept = ($type == 'file') ? 'accept=".jpg,.jpeg,.png"' : '';

        return <<<HTML
        <input type="$type" id="$id" $accept class="form-control $classAttribute $isInvalid" name="$id" value="$valueAttribute" $requiredAttribute placeholder="$placeholderText">
        $error
        HTML;
    }

    function show_alert_message()
    {
        if (session()->getFlashdata('alert_message') !== NULL) {
            $data = session()->getFlashdata('alert_message');
            $type = $data['type'];
            $message = $data['message'];
            $icon = $data['icon'];

            return <<<HTML
            <div class="alert alert-$type">
                <span class="$icon me-3"></span> $message
            </div>
            HTML;
        }
    }
