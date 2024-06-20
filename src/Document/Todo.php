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
}