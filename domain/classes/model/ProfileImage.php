<?php

namespace model;
require_once 'ValidInterface.php';


class ProfileImage implements ValidInterface
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
        $types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
        if (strlen($this->value['name']) > 0 && !in_array($this->value['type'], $types)) {
            return "$this->name must be image";
        }
        return '';
    }
}

