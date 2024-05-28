<?php

namespace model;
require_once 'ValidInterface.php';


class RequireImage implements ValidInterface
{

    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;

    }

    public function validate(): string
    {
        if (strlen($this->value['name']) == 0) {
            return "$this->name is Required";
        }

        return '';
    }
}

