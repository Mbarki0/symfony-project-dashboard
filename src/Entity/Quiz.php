<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Level::class, inversedBy: 'quizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private $level;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class)]
    private $question;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: ProfileQuizResult::class)]
    private $profileQuizResults;

    public function __construct()
    {
        $this->question = new ArrayCollection();
        $this->profileQuizResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question[] = $question;
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * @return Collection<int, ProfileQuizResult>
     */
    public function getProfileQuizResults(): Collection
    {
        return $this->profileQuizResults;
    }

    public function addProfileQuizResult(ProfileQuizResult $profileQuizResult): self
    {
        if (!$this->profileQuizResults->contains($profileQuizResult)) {
            $this->profileQuizResults[] = $profileQuizResult;
            $profileQuizResult->setQuiz($this);
        }

        return $this;
    }

    public function removeProfileQuizResult(ProfileQuizResult $profileQuizResult): self
    {
        if ($this->profileQuizResults->removeElement($profileQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($profileQuizResult->getQuiz() === $this) {
                $profileQuizResult->setQuiz(null);
            }
        }

        return $this;
    }
}
