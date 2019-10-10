<?php

function autoloader($name)
{
    include __DIR__ . '/' . $name . '.php'; 
}