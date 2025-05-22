<?php

require_once __DIR__ . '/vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;


$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache'),
        mkdir('nginx', [
            mkfile('nginx.conf', ['size' => 800]),
        ]),
        mkdir('consul', [
            mkfile('config.json', ['size' => 1200]),
            mkfile('data', ['size' => 8200]),
            mkfile('raft', ['size' => 80]),
        ]),
    ]),
    mkfile('hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
]);


function collectFilesByName($node, $needle, $path, &$acc)
{
    $name = getName($node);
    $currentPath = ($name === '/') ? '' : "$path/$name";

    if(isFile($node)) {
        if(str_contains($name, $needle)) {
            $acc[] = $currentPath;
        }
        return;
    }

    foreach (getChildren($node) as $child) {
        collectFilesByName($child, $needle, $currentPath, $acc);
    }
}

function findFilesByName($tree, $needle)
{
    $acc = [];
    collectFilesByName($tree, $needle, '', $acc);
    return $acc;
}

var_dump(findFilesByName($tree, 'co'));