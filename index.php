<?php
include __DIR__ . '/autoload.php';
spl_autoload_register('autoloader');

if(isset($_GET['ajax']))
    include __DIR__ . '/data.php';
else include __DIR__ . '/views/page.php';