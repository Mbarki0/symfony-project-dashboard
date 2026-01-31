<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Profile implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string', length: 30)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 30)]
    private $lastName;

    #[ORM\Column(type: 'boolean')]
    private $manageImages;

    #[ORM\Column(type: 'boolean')]
    private $manageQuiz;

    #[ORM\Column(type: 'boolean')]
    private $managePatients;

    #[ORM\Column(type: 'boolean')]
    private $manageAll;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $createdBy;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $updatedBy;

    #[ORM\Column(type: 'datetime_immutable')]
    #[GEDMO\Timestampable(on: 'create')]
    private $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[GEDMO\Timestampable(on: 'update')]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: ProfileQuizResult::class)]
    private $profileQuizResults;

    public function __construct()
    {
        $this->role = new ArrayCollection();
        $this->manageAll = false;
        $this->manageQuiz = false;
        $this->manageImages = false;
        $this->managePatients = false;
        $this->createdBy = $this->updatedBy = 0;
        $this->profileQuizResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        if($this->isManageAll() or $this->isManageQuiz() or $this->isManageImages() or $this->isManagePatients()){
            $roles[] = 'ROLE_ADMIN';
            if($this->isManageAll())
                $roles[] = 'ROLE_SUPER_ADMIN';
            if($this->isManageQuiz())
                $roles[] = 'ROLE_QUIZZES';    
            if($this->isManageImages())
                $roles[] = 'ROLE_IMAGES';
            if($this->isManagePatients())
                $roles[] = 'ROLE_PATIENTS';
        }

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isManageImages(): ?bool
    {
        return $this->manageImages;
    }

    public function setManageImages(bool $manageImages): self
    {
        $this->manageImages = $manageImages;

        return $this;
    }

    public function isManageAll(): ?bool
    {
        return $this->manageAll;
    }

    public function setManageAll(bool $manageAll): self
    {
        $this->manageAll = $manageAll;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isManagePatients(): ?bool
    {
        return $this->managePatients;
    }

    public function setManagePatients(?bool $managePatients): self
    {
        $this->managePatients = $managePatients;

        return $this;
    }

    public function isManageQuiz(): ?bool
    {
        return $this->manageQuiz;
    }

    public function setManageQuiz(bool $manageQuiz): self
    {
        $this->manageQuiz = $manageQuiz;

        return $this;
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
            $profileQuizResult->setProfile($this);
        }

        return $this;
    }

    public function removeProfileQuizResult(ProfileQuizResult $profileQuizResult): self
    {
        if ($this->profileQuizResults->removeElement($profileQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($profileQuizResult->getProfile() === $this) {
                $profileQuizResult->setProfile(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->email;
    }

}
