<?php

if($devMode) {
    error_reporting(-1);
    ini_set("display_errors", 1);
}

//Autoload classes from classes/classFile.php
spl_autoload_register(function($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

session_start();
$devmode = false;

if($devMode) {
      
   // Db settings (remote - studenter.miun.se)
   define("DBHOST", "localhost");
   define("DBUSER", "moment6");
   define("DBPASS", "password");
   define("DBDATABASE", "moment6");
      
} else {
          //db-inställningar
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "lias1700");
    define("DBPASS", "qZCqyBMbUz");
    define("DBDATABASE", "lias1700");
}