<?php

interface IActionContainer {

    /**
     * returns action string for Action static factory
     * @return unknown_type
     */
    function getActionString();

    /**
     * adds parameter to the token
     * @return String
     */
    //function addParam($name, $value);

    /**
     * clears action string content
     * @return unknown_type
     */
    function clearActionString();

    /**
     * returns name of the action string variable
     * @return unknown_type
     */
    function getActionVariableName();
}