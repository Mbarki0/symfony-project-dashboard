<?php

namespace App\Entity;

use App\Repository\ImageFolderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageFolderRepository::class)]
class ImageFolder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $path;

    #[ORM\ManyToOne(targetEntity: PatientFolder::class, inversedBy: 'imageFolders')]
    #[ORM\JoinColumn(nullable: false)]
    private $patientFolder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function __toString() {
        return (string) $this->id;
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

}
