<?php

namespace loris\testTrain;

class TaskManager
{
    private $tasks = [];

    public function __construct()
    {
        $this->tasks = [];
    }

    // Ajouter un paramètre $deadline
    public function addTask(string $task, string $deadline = null)
    {
        $this->tasks[] = [
            'name' => $task,
            'deadline' => $deadline
        ];
    }

    public function removeTask(int $index)
    {
        if (!isset($this->tasks[$index])) {
            throw new \OutOfBoundsException("Index de tâche invalide: $index");
        }
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }

    // getTasks() renvoie maintenant un tableau de tableaux associatifs
    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getTask(int $index): array
    {
        if (!isset($this->tasks[$index])) {
            throw new \OutOfBoundsException("Index de tâche invalide: $index");
        }
        return $this->tasks[$index];
    }
}