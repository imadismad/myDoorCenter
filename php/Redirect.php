<?php
ob_start(); 
/*
 * DEFAULT_REDIRECT_PATH is use in the case that the redirect url is not set
 * it act as a default redirect path
 * DEFAULT_REDIRECT_PATH is set to / (root index) by default
 * It can be overide by define DEFAULT_REDIRECT_PATH before including/requiring this file :
 * define("DEFAULT_REDIRECT_PATH", "YOUR DEFAULT PATH HERE");
 */
if(!defined("DEFAULT_REDIRECT_PATH")) define("DEFAULT_REDIRECT_PATH", "/");


function goToRedirect() {
    $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : DEFAULT_REDIRECT_PATH;
    header("Location: ".$redirect);
    exit();
}

/**
 * Redirect to the given URL with original redirect save in URL if exist
 * @param string $url The page to go
 * @param bool $hasOtherOption If $url already has get option 
 */
function saveRedirect(string $url, bool $hasOtherOption = false) {
    header("Location: ".getUrlWithSaveRedirect($url, $hasOtherOption));
    exit();
}

/**
 * Return the given URL with original redirect save in it if exist
 * @param string $url The page to go
 * @param bool $hasOtherOption If $url already has get option 
 */
function getUrlWithSaveRedirect(string $url, bool $hasOtherOption = false) {
    if (isset($_GET["redirect"]))
        return setRedirect($url, $_GET["redirect"], $hasOtherOption);
    return $url;
}

/**
 * Return $url with $redirect set in parameters
 * @param string $url The page to go
 * @param string $redirect The redirect url
 * @param bool $hasOtherOption If $url already has get option
 */
function setRedirect(string $url, string $redirect, bool $hasOtherOption = false) {
    $modifier = $hasOtherOption ? "&" : "?"; 
    return "".$url.$modifier."redirect=".$redirect;
}

/**
 * Go to $url with $redirect set in parameters
 * @param string $url The page to go
 * @param string $redirect The redirect url
 * @param bool $hasOtherOption If $url already has get option
 */
function goToURL(string $url, string $redirect, bool $hasOtherOption = false) {
    header("Location: ".setRedirect($url, $redirect, $hasOtherOption));
    exit();
}
ob_end_flush();
?>
