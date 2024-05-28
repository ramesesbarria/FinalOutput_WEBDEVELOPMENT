<?php


namespace model;

interface ValidInterface
{
    public function __construct($name, $value);

    public function validate();
}