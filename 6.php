<?php

namespace App\tree;

require_once __DIR__ . '/vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache', []),
        mkdir('nginx', [
            mkfile('.nginx.conf', ['size' => 800]),
        ]),
        mkdir('.consul', [
            mkfile('.config.json', ['size' => 1200]),
            mkfile('data', ['size' => 8200]),
            mkfile('raft', ['size' => 80]),
        ]),
    ]),
    mkfile('.hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
]);

function getHiddenFilesCount($tree)
{
    if (isFile($tree)) {
        $fileName = getName($tree);
        return str_starts_with($fileName, '.') ? 1 : 0;
    }
    $children = getChildren($tree);
    $hiddenFilesCount = array_map(fn($child) => getHiddenFilesCount($child), $children);

    return array_sum($hiddenFilesCount);
}

print_r(getHiddenFilesCount($tree));