<?php

namespace React\Promise;

class Queue implements QueueInterface
{
    private $queue = [];

    public function enqueue(callable $task)
    {
        $length = array_push($this->queue, $task);

        if ($length !== 1) {
            return;
        }

        $this->drain();
    }

    public function drain()
    {
        for ($i = 0; isset($this->queue[$i]); $i++) {
            $task = $this->queue[$i];
            $task();
        }

        $this->queue = [];
    }
}
