<?php

require_once "../BDD/interBDDUser.php";

class UserUtils {
    private const COOKIE_NAME = "prenom";

    public static function disconnect() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION["id"]);
        unset($_SESSION["nom"]);
        unset($_SESSION["prenom"]);
        unset($_SESSION["mail"]);
        unset($_SESSION["ville"]);
        unset($_SESSION["genre"]);
        unset($_SESSION["CP"]);
        unset($_SESSION["tel"]);
        unset($_SESSION["naissance"]);
        unset($_SESSION["rue"]);
        unset($_SESSION["pays"]);
        unset($_COOKIE[UserUtils::COOKIE_NAME]);
        setcookie(UserUtils::COOKIE_NAME, "", -1,"/");
    }

    /**
     * @return bool Return if a user is connect
     */
    public static function isConnect(): bool {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        return isset($_SESSION["id"]) &&
            isset($_SESSION["nom"]) &&
            isset($_SESSION["prenom"]) &&
            isset($_SESSION["mail"]) &&
            isset($_SESSION["ville"])&&
            isset($_SESSION["genre"]) &&
            isset($_SESSION["CP"]) &&
            isset($_SESSION["tel"]) &&
            isset($_SESSION["naissance"]) &&
            isset($_SESSION["rue"]) &&
            isset($_SESSION["pays"]);
    }

    /**
     * 
     */
    public static function connect(string $mail, string $password): bool {
        $info = connexionUtilisateur($mail, $password);
        if ($info === false) return false;

        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION["id"] = $info["id"];
        $_SESSION["nom"] = $info["nom"];
        $_SESSION["prenom"] = $info["prenom"];
        $_SESSION["mail"] = $info["mail"];
        $_SESSION["ville"] = $info["ville"];
        $_SESSION["genre"] = $info["genre"];
        $_SESSION["CP"] = $info["CP"];
        $_SESSION["tel"] = $info["telephone"];
        $_SESSION["naissance"] = $info["naissance"];
        $_SESSION["rue"] = $info["rue"];
        $_SESSION["pays"] = $info["pays"];

        setcookie(UserUtils::COOKIE_NAME, $_SESSION["prenom"], time() + 60 * 60 * 24, "/");

        return true;
    }
}