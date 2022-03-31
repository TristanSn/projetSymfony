<?php
namespace App\Dto;

class RechercheDto{

    private $input;

    public function __construct(){

    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     */
    public function setInput($input): void
    {
        $this->input = $input;
    }
}