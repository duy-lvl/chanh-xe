<?php

declare(strict_types=1);

namespace Domain\PathFinding\Models;

final class Node
{
    public function __construct(
        public int $id,
        public string $type,
    ){}

    public function getIndentifier(): string
    {
        return $this->id.'|'.$this->type;
    }
}
