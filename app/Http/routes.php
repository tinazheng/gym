<?php

$router->get('/', function(){ return file_get_contents(__DIR__ . '/../../public/app/index.html'); });
