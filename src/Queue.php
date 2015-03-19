<?php

namespace React\Promise;

class Queue
{
    private $queue = [];

    public function enqueueHandlers(array $handlers, $value)
    {
        $this->enqueue(function () use ($handlers, $value) {
            foreach ($handlers as $handler) {
                $handler($value);
            }
        });
    }

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
