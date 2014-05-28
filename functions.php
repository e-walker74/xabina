<?php 
function d($var, $line = ''){
    echo '<pre>';
        if($line){
            echo '++++++++++++++++++++++++++++++++++++++++++++++' . $line . '++++++++++++++++++++++++++++++++++++++++++++++++';
        }
        print_r($var);
        if($line){
            echo '++++++++++++++++++++++++++++++++++++++++++++++' . $line . '++++++++++++++++++++++++++++++++++++++++++++++++';
        }
    echo '</pre>';
}

function dd($var){
    echo '<pre>';
        var_dump($var);
    echo '</pre>';
}

function dm($obj){
    echo '<pre>';
        echo '<-- CLASS: -->'; d(get_class($obj));
        echo '<-- METHODS: -->'; d(get_class_methods(get_class($obj)));
    echo '</pre>';
}