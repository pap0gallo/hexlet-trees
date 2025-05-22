<?php

namespace App\du;

require_once __DIR__ . '/vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\isDirectory;
use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\reduce;

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

// BEGIN (write your solution here)
function sizeCounter($tree)
{
    if (!isDirectory($tree)) {
        $fileMeta = getMeta($tree);
        return $fileMeta['size'];
    }

    return array_sum(array_map(fn($child) => sizeCounter($child), getChildren($tree)));
}

function du($tree)
{
    $result = array_map(function ($child) {
        $childName = getName($child);
        return [$childName, sizeCounter($child)];
    }, getChildren($tree));
    usort($result, fn($a, $b) => $b[1] <=> $a[1]);

    return $result;
}

var_dump(du($tree));
// END
