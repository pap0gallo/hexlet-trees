<?php

$tree = [
    'name' => 'div',
    'type' => 'tag-internal',
    'className' => 'hexlet-community',
    'children' => [
        [
            'name' => 'div',
            'type' => 'tag-internal',
            'className' => 'old-class',
            'children' => [],
        ],
        [
            'name' => 'div',
            'type' => 'tag-internal',
            'className' => 'old-class',
            'children' => [],
        ],
    ],
];

function changeClass($tree, $oldClass, $newClass)
{
    if ($tree['className'] === $oldClass) {
        $tree['className'] = $newClass;
    }

    if (array_key_exists('children', $tree)) {
        $tree['children'] = array_map(fn($child) => changeClass($child, $oldClass, $newClass), $tree['children']);
    }

    return $tree;
}

var_dump(changeClass($tree, 'old-class', 'new-class'));