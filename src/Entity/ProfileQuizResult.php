<?php

namespace App\Entity;

use App\Repository\ProfileQuizResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileQuizResultRepository::class)]
class ProfileQuizResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'profileQuizResults')]
    #[ORM\JoinColumn(nullable: false)]
    private $profile;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'profileQuizResults')]
    #[ORM\JoinColumn(nullable: false)]
    private $quiz;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2, nullable: true)]
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

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

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }
}
