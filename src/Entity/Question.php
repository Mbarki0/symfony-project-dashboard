<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 1000, nullable: true)]
    private $text;

    #[ORM\Column(type: 'array', nullable: true)]
    private $corrects = [];

    #[ORM\Column(type: 'array', nullable: true)]
    private $options = [];

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'question')]
    #[ORM\JoinColumn(nullable: false)]
    private $quiz;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCorrects(): ?array
    {
        return $this->corrects;
    }

    public function setCorrects(?array $corrects): self
    {
        $this->corrects = $corrects;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }
}
