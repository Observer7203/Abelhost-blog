<?php

require __DIR__ . '/../vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();
$compiler->setImportPaths(__DIR__ . '/../scss');

$scss = file_get_contents(__DIR__ . '/../scss/main.scss');
$css = $compiler->compileString($scss)->getCss();

file_put_contents(__DIR__ . '/../public/assets/css/main.css', $css);

echo "CSS compiled\n";