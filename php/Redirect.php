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
    header("Location: ".prependStaticDirIfNeed($redirect));
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
 * @param bool $prepend If prepend is true, prepend BASE_DIR_STATIC if needed
 */
function getUrlWithSaveRedirect(string $url, bool $hasOtherOption = false, bool $prepend = true) {
    if (isset($_GET["redirect"]))
        return setRedirect($url, $_GET["redirect"], $hasOtherOption, $prepend);
    return $prepend ? prependStaticDirIfNeed($url) : $url;
}

/**
 * Return $url with $redirect set in parameters
 * @param string $url The page to go
 * @param string $redirect The redirect url
 * @param bool $hasOtherOption If $url already has get option
 * @param bool $prepend If prepend is true, prepend BASE_DIR_STATIC if needed
 */
function setRedirect(string $url, string $redirect, bool $hasOtherOption = false, bool $prepend = true) {
    $modifier = $hasOtherOption ? "&" : "?"; 
    $result = "".$url.$modifier."redirect=".$redirect;
    return $prepend ? prependStaticDirIfNeed($result) : $result;
}

/**
 * Go to $url with $redirect set in parameters if specify
 * @param string $url The page to go
 * @param string $redirect The redirect url
 * @param bool $hasOtherOption If $url already has get option
 * @param bool $prepend If prepend is true, prepend BASE_DIR_STATIC if needed
 */
function goToURL(string $url, string $redirect = "", bool $hasOtherOption = false, bool $prepend = true) {
    if ($redirect === "")
        header("Location: ".prependStaticDirIfNeed($url));
    else if ($prepend)
        header("Location: ".prependStaticDirIfNeed(setRedirect($url, $redirect, $hasOtherOption)));
    else
        header("Location: ".setRedirect($url, $redirect, $hasOtherOption));
    exit();
}

/**
 * This function prepend the BASE_DIR_STATIC const if the given path is absolute
 * @param string $url The URL to prepend
 * @return string The URL prepend if it was absolute, the given url otherwise
 */
function prependStaticDirIfNeed(string $url) {
    if (!defined("BASE_DIR_STATIC")) {
        $path = strpos($lower = strtolower($scriptPath = $_SERVER['SCRIPT_NAME']), $projectFolder = 'mydoorcenter') !== false ?
            substr($scriptPath, 0, strpos($lower, $projectFolder) + strlen($projectFolder)) :
            '/';
        
        define("BASE_DIR_STATIC", rtrim($path, '/') . '/');
    }
    
    if (str_starts_with($url, "/"))
        return BASE_DIR_STATIC."".substr($url, 1);
    return $url;
}
ob_end_flush();