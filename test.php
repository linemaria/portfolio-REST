<?php
include("includes/config.php");

$s = new Course();
$p = new Work();

echo "<pre>";
var_dump($s->getCourses());
var_dump($p->getWorks());
echo "</pre>";