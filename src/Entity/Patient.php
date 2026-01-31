<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $gender;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[GEDMO\Timestampable(on: 'create')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[GEDMO\Timestampable(on: 'update')]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $createdBy;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $updatedBy;

    #[ORM\Column(type: 'date', nullable: true)]
    private $birthDate;

    #[ORM\OneToMany(mappedBy: 'patient', targetEntity: PatientFolder::class)]
    private $patientFolders;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ip;

    public function __construct()
    {
        $this->patientFolders = new ArrayCollection();
        $this->createdBy = $this->updatedBy = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPatientFolder(): ?PatientFolder
    {
        return $this->patientFolder;
    }

    public function setPatientFolder(?PatientFolder $patientFolder): self
    {
        $this->patientFolder = $patientFolder;

        return $this;
    }

    /**
     * @return Collection<int, PatientFolder>
     */
    public function getPatientFolders(): Collection
    {
        return $this->patientFolders;
    }

    public function addPatientFolder(PatientFolder $patientFolder): self
    {
        if (!$this->patientFolders->contains($patientFolder)) {
            $this->patientFolders[] = $patientFolder;
            $patientFolder->setPatient($this);
        }

        return $this;
    }

    public function removePatientFolder(PatientFolder $patientFolder): self
    {
        if ($this->patientFolders->removeElement($patientFolder)) {
            // set the owning side to null (unless already changed)
            if ($patientFolder->getPatient() === $this) {
                $patientFolder->setPatient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->ip;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
