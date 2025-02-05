<?php
// tests/TaskManagerTest.php

use PHPUnit\Framework\TestCase;
use Loris\testTrain\TaskManager;

class TaskManagerTest extends TestCase
{
    public function testAddTask()
    {
        $tm = new TaskManager();
        $tm->addTask("Tâche 1", "2025-12-01");

        $tasks = $tm->getTasks();
        $this->assertCount(1, $tasks);
        $this->assertEquals("Tâche 1", $tasks[0]['name']);
        $this->assertEquals("2025-12-01", $tasks[0]['deadline']);
    }

    public function testRemoveTask()
    {
        $tm = new TaskManager();
        $tm->addTask("Tâche 1");
        $tm->addTask("Tâche 2");

        $tm->removeTask(0);
        $tasks = $tm->getTasks();
        $this->assertCount(1, $tasks, "Après suppression, il ne doit rester qu'une tâche.");
        $this->assertEquals("Tâche 2", $tasks[0]['name'], "La tâche restante doit être 'Tâche 2'.");
    }

    public function testGetTasks()
    {
        $tm = new TaskManager();
        $this->assertEmpty($tm->getTasks(), "La liste des tâches doit être vide au départ.");

        $tm->addTask("Tâche 1");
        $this->assertNotEmpty($tm->getTasks(), "La liste des tâches ne doit plus être vide après un ajout.");
    }

    public function testGetTask()
    {
        $tm = new TaskManager();
        $tm->addTask("Tâche 1", "2025-12-01");

        $task = $tm->getTask(0);
        $this->assertEquals("Tâche 1", $task['name']);
        $this->assertEquals("2025-12-01", $task['deadline']);
    }

    public function testRemoveInvalidIndexThrowsException()
    {
        $this->expectException(\OutOfBoundsException::class);

        $tm = new TaskManager();
        $tm->removeTask(0); // Il n'y a aucune tâche à l'index 0, l'exception doit être levée.
    }

    public function testGetInvalidIndexThrowsException()
    {
        $this->expectException(\OutOfBoundsException::class);

        $tm = new TaskManager();
        $tm->getTask(0); // Aucune tâche présente, donc exception attendue.
    }

    public function testTaskOrderAfterRemoval()
    {
        $tm = new TaskManager();
        $tm->addTask("Tâche 1");
        $tm->addTask("Tâche 2");
        $tm->addTask("Tâche 3");

        $tm->removeTask(1); // Suppression de "Tâche 2"
        $tasks = $tm->getTasks();

        $this->assertCount(2, $tasks, "Il doit rester 2 tâches après suppression.");
        $this->assertEquals("Tâche 1", $tasks[0]['name'], "La première tâche doit être 'Tâche 1'.");
        $this->assertEquals("Tâche 3", $tasks[1]['name'], "La deuxième tâche doit être 'Tâche 3' (réindexée).");
    }
}
