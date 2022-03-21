<?php
include("includes/config.php");

//Anslut till db
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno > 0){
    die('Fel vid anslutning [' . $db->connect_error . ']');
}

//sql för att skapa tabell
$sql = "DROP TABLE IF EXISTS courses;";
$sql .= "CREATE TABLE `courses` (
    `id` int(2) PRIMARY KEY AUTO_INCREMENT,
    `coursename` varchar(50) NOT NULL,
    `school` varchar(50) NOT NULL,
    `start` varchar(50) NOT NULL,
    `stop` varchar(50) NOT NULL,
    `created` timestamp NOT NULL DEFAULT current_timestamp()
  );";

  $sql .= "DROP TABLE IF EXISTS works;";
  $sql .= "CREATE TABLE `works` (
      `id` int(2) PRIMARY KEY AUTO_INCREMENT,
      `workplace` varchar(50) NOT NULL,
      `title` varchar(50) NOT NULL,
      `start` varchar(50) NOT NULL,
      `stop` varchar(50) NOT NULL,
      `created` timestamp NOT NULL DEFAULT current_timestamp()
    );";

 $sql .= "DROP TABLE IF EXISTS websites;";
  $sql .= "CREATE TABLE websites(
     id INT(11) PRIMARY KEY AUTO_INCREMENT,
      title VARCHAR(64) NOT NULL,
      description text NOT NULL,
       url text NOT NULL,
      created TIMESTAMP NOT NULL DEFAULT current_timestamp()
       );";


  
  //Skriv ut sql-fråga
  echo "<pre>$sql</pre>";

  //Skicka sql-fråga till db
  if($db->multi_query($sql)) {
      echo "<p>Tabeller installerades korrekt!</p>";
  } else {
      echo "<p class='error'>Fel vid installation av tabeller!</p>";
  }