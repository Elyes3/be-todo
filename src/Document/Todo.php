<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]

class Todo
{
    /**
     * @MongoDB\Id
     */
    #[MongoDB\Id]
    protected $id;

    #[MongoDB\Field(type: 'string')]
    #[Assert\NotBlank]
    protected string $description;
    #[MongoDB\Field(type: 'int')]
    #[Assert\NotBlank]
    protected int $millis;
    #[MongoDB\Field(type: 'bool')]
    #[Assert\NotBlank]
    protected int $completed;
    // Getters and setters

    public function getId(): string{
        return $this->id;
    }
    public function getDescription(): string{
        return $this->description;
    }
    public function setDescription(string $description): void{
        $this->description = $description;
    }
    public function getMillis(): int{
        return $this->millis;
    }
    public function setMillis(int $millis): void{
        $this->millis = $millis;
    }
    public function getCompleted(): bool{
        return $this->completed;
    }
    public function setCompleted(bool $completed): void{
        $this->completed = $completed;
    }
}