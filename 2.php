<?php

namespace App\removeFirstLevel;

// BEGIN (write your solution here)
function removeFirstLevel($tree)
{
    return array_reduce($tree, function ($acc, $item) {
        return is_array($item) ? array_merge($acc, $item) : $acc;
    }, []);
}
// END
