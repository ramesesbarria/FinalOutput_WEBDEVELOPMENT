<?php

namespace model;
require_once 'ValidInterface.php';


class Required implements ValidInterface
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
        if (strlen($this->value) == 0) {
            return "$this->name is required";
        }
        return '';
    }
}