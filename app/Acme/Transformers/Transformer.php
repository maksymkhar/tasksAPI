<?php

namespace App\Acme\Transformers;

/**
 * Created by PhpStorm.
 * User: max
 * Date: 1/12/15
 * Time: 21:53
 */

abstract class Transformer {


    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items->toArray());
    }

    public abstract function transform($item);

}