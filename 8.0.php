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


function findFilesByName(array $tree, string $string, string $root = ''): array
{
    $results = [];
    $name = getName($tree);
    $path = ($name === '/') ? '' : "$root/$name";

    if (isFile($tree)) {
        if (str_contains($name, $string)) {
            return [$path];
        }
        return [];
    }

    foreach (getChildren($tree) as $child) {
        foreach (findFilesByName($child, $string, $path) as $found) {
            $results[] = $found;
        }
    }

    return $results;
}

var_dump(findFilesByName($tree, 'co'));