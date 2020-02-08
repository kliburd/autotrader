<?php

/**
 * Registers a plugin for hook $hook_name
 * @param $hook_name String 
 * @param $handler String function name. Data would be passed through this function and returned.
 * 
 */
function register_plugin($hook_name,$handler){
    session_start();
    //if(!isset($_SESSION[$hook_name])) if(trim($hook_name)!="" && trim($handler)!="") $_SESSION[$hook_name][]=$handler; 
    if(trim($hook_name)!="" && trim($handler)!="" && !in_array($handler, $_SESSION[$hook_name])) $_SESSION[$hook_name][]=$handler;
    
}

/**
 * Deregisters a plugin for hook $hook_name
 * @param $hook_name String 
 * @param $handler String function name.
 * 
 */
function deregister_plugin($hook_name,$handler){
    session_start();
    if(($key = array_search($handler, $_SESSION[$hook_name])) !== false) unset($_SESSION[$hook_name][$key]);
}

/**
 * Calls all registered functuins registered for the hook $hook_name
 * @param $hook_name String 
 * @param &$args String the argument is passed by reference. It can be an array of arguments as well. it solely depends on function to handle and return appropriate data back.
 * For ex:
 * function handler(&$args){
 *     $args=str_replace("Category", "Model", $args);
 *     return $args;
 * }
 * 
 */
 
function call_plugin($hook_name,&$args){
    session_start();
    $return=$args;
    if(isset($_SESSION[$hook_name])){
     foreach($_SESSION[$hook_name] as $handler){
       if(function_exists($handler)) $return=$handler($args);
     }
    }
    return $return;
}

function add_member_menu($menuName,$handler,$mem_level=1){
    session_start();
    $menuarray=array($handler,$mem_level);
    if(!isset($_SESSION["bmenu"][$menuName])) if(trim($menuName)!="" && trim($handler)!="") $_SESSION["bmenu"][$menuName]=$menuarray;
}

?>