<?php

/**
 * A Debug-Helper-Class, which offer's output-methods for variable-data
 * 
 * @author TH<>
 */
class Debug
{
    /**
     * Echoes the data of the given variable well-formated and stops the code-flow
     * 
     * @author TH<>
     * 
     * @param mixed $var
     */
    static function p($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        exit;
    }
    
    /**
     * Echoes the data of the given variable well-formated, but doesn't stop the code-flow
     * 
     * @author TH<>
     * 
     * @param mixed $var
     */
    static function e($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}
