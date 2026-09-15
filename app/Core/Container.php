<?php
namespace App\Core;
final class Container {
    private array $entries = [];
    public function set(string $id, callable $factory): void { $this->entries[$id] = $factory; }
    public function get(string $id): object { return ($this->entries[$id])(); }
}
