<?php

namespace App\Acme\Transformers;


/**
 * Created by PhpStorm.
 * User: max
 * Date: 1/12/15
 * Time: 21:56
 */

class TaskTransformer extends Transformer
{
    public function transform($task)
    {
        return [
            'name' => $task['name'],
            'priority' => $task['priority'],
            'is_done' => (bool)$task['done']
        ];
    }
}