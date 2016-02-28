<?php

namespace App\Acme\Transformers;

/**
 * Created by PhpStorm.
 * User: max
 * Date: 28/02/16
 * Time: 18:25
 */

class TagTransformer extends Transformer
{
    public function transform($tag)
    {
        return [
            'title' => $tag['title'],
            //'active' => (bool)$tag['active']
        ];
    }
}