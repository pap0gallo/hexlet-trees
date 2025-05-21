<?php

namespace App\tree;

require_once __DIR__ . '/vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

$tree = mkdir(
    'my documents', [
        mkfile('avatar.jpg', ['size' => 100]),
        mkfile('passport.jpg', ['size' => 200]),
        mkfile('family.jpg',  ['size' => 150]),
        mkfile('addresses',  ['size' => 125]),
        mkdir('presentations')
    ]
);

//BEGIN (write your solution here)
function compressImages($tree)
{
    $treeName = getName($tree);
    $treeMeta = getMeta($tree);
    $newChildren = array_map(function ($item) {
        if (!isFile($item)) {
            return $item;
        }

        $name = getName($item);
        $meta = getMeta($item);
        if (str_ends_with($name, '.jpg')) {
            $meta['size'] /= 2;
        }
        return mkfile($name, $meta);
    }, getChildren($tree));

    return mkdir($treeName, $newChildren, $treeMeta);
}
//END

$newTree = compressImages($tree);



print_r($newTree);