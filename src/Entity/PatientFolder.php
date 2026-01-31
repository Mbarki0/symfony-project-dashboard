<?php

namespace App\Entity;

use App\Repository\PatientFolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PatientFolderRepository::class)]
class PatientFolder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $LAN;

    #[ORM\Column(type: 'array', length: 100, nullable: true)]
    private $LAS = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $RC;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $hemogramme;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $FS;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CC;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $MPO;

    #[ORM\Column(type: 'array', nullable: true)]
    private $MP = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CI;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cytospin;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $TP;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $TCA;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $DD;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $AEH;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $calcemie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $creat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CRP;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $PCT;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $LDH;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $BB;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $AA;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $AR;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $BOM;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $CF;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $BM;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $DF;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $MCC;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $corticosensibilite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $evolution;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $createdBy;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $updatedBy;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[GEDMO\Timestampable(on: 'create')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[GEDMO\Timestampable(on: 'update')]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $AU;

    #[ORM\ManyToOne(targetEntity: Patient::class, inversedBy: 'patientFolders')]
    private $patient;

    #[ORM\OneToMany(mappedBy: 'patientFolder', targetEntity: ImageFolder::class)]
    private $imageFolders;

    public function __construct()
    {
        $this->createdBy = $this->updatedBy = 0;
        $this->imageFolders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLAN(): ?bool
    {
        return $this->LAN;
    }

    public function setLAN(?bool $LAN): self
    {
        $this->LAN = $LAN;

        return $this;
    }

    public function getLAS(): ?array
    {
        return $this->LAS;
    }

    public function setLAS(?array $LAS): self
    {
        $this->LAS = $LAS;

        return $this;
    }

    public function getRC(): ?string
    {
        return $this->RC;
    }

    public function setRC(?string $RC): self
    {
        $this->RC = $RC;

        return $this;
    }

    public function getHemogramme(): ?string
    {
        return $this->hemogramme;
    }

    public function setHemogramme(?string $hemogramme): self
    {
        $this->hemogramme = $hemogramme;

        return $this;
    }

    public function getFS(): ?string
    {
        return $this->FS;
    }

    public function setFS(?string $FS): self
    {
        $this->FS = $FS;

        return $this;
    }

    public function getCC(): ?string
    {
        return $this->CC;
    }

    public function setCC(?string $CC): self
    {
        $this->CC = $CC;

        return $this;
    }

    public function getMPO(): ?string
    {
        return $this->MPO;
    }

    public function setMPO(?string $MPO): self
    {
        $this->MPO = $MPO;

        return $this;
    }

    public function getMP(): ?array
    {
        return $this->MP;
    }

    public function setMP(?array $MP): self
    {
        $this->MP = $MP;

        return $this;
    }

    public function getCI(): ?string
    {
        return $this->CI;
    }

    public function setCI(?string $CI): self
    {
        $this->CI = $CI;

        return $this;
    }

    public function getCytospin(): ?string
    {
        return $this->cytospin;
    }

    public function setCytospin(?string $cytospin): self
    {
        $this->cytospin = $cytospin;

        return $this;
    }

    public function getTP(): ?string
    {
        return $this->TP;
    }

    public function setTP(?string $TP): self
    {
        $this->TP = $TP;

        return $this;
    }

    public function getTCA(): ?string
    {
        return $this->TCA;
    }

    public function setTCA(?string $TCA): self
    {
        $this->TCA = $TCA;

        return $this;
    }

    public function getDD(): ?string
    {
        return $this->DD;
    }

    public function setDD(?string $DD): self
    {
        $this->DD = $DD;

        return $this;
    }

    public function getAEH(): ?string
    {
        return $this->AEH;
    }

    public function setAEH(?string $AEH): self
    {
        $this->AEH = $AEH;

        return $this;
    }

    public function getCalcemie(): ?string
    {
        return $this->calcemie;
    }

    public function setCalcemie(?string $calcemie): self
    {
        $this->calcemie = $calcemie;

        return $this;
    }

    public function getCreat(): ?string
    {
        return $this->creat;
    }

    public function setCreat(?string $creat): self
    {
        $this->creat = $creat;

        return $this;
    }

    public function getCRP(): ?string
    {
        return $this->CRP;
    }

    public function setCRP(?string $CRP): self
    {
        $this->CRP = $CRP;

        return $this;
    }

    public function getPCT(): ?string
    {
        return $this->PCT;
    }

    public function setPCT(?string $PCT): self
    {
        $this->PCT = $PCT;

        return $this;
    }

    public function getLDH(): ?string
    {
        return $this->LDH;
    }

    public function setLDH(?string $LDH): self
    {
        $this->LDH = $LDH;

        return $this;
    }

    public function getBB(): ?string
    {
        return $this->BB;
    }

    public function setBB(?string $BB): self
    {
        $this->BB = $BB;

        return $this;
    }

    public function getAA(): ?string
    {
        return $this->AA;
    }

    public function setAA(?string $AA): self
    {
        $this->AA = $AA;

        return $this;
    }

    public function getAR(): ?string
    {
        return $this->AR;
    }

    public function setAR(?string $AR): self
    {
        $this->AR = $AR;

        return $this;
    }

    public function getBOM(): ?string
    {
        return $this->BOM;
    }

    public function setBOM(?string $BOM): self
    {
        $this->BOM = $BOM;

        return $this;
    }

    public function getCF(): ?string
    {
        return $this->CF;
    }

    public function setCF(?string $CF): self
    {
        $this->CF = $CF;

        return $this;
    }

    public function getBM(): ?string
    {
        return $this->BM;
    }

    public function setBM(?string $BM): self
    {
        $this->BM = $BM;

        return $this;
    }

    public function getDF(): ?string
    {
        return $this->DF;
    }

    public function setDF(?string $DF): self
    {
        $this->DF = $DF;

        return $this;
    }

    public function getMCC(): ?string
    {
        return $this->MCC;
    }

    public function setMCC(?string $MCC): self
    {
        $this->MCC = $MCC;

        return $this;
    }

    public function getCorticosensibilite(): ?string
    {
        return $this->corticosensibilite;
    }

    public function setCorticosensibilite(?string $corticosensibilite): self
    {
        $this->corticosensibilite = $corticosensibilite;

        return $this;
    }

    public function getEvolution(): ?string
    {
        return $this->evolution;
    }

    public function setEvolution(?string $evolution): self
    {
        $this->evolution = $evolution;

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
        $this->updatedAt = $updatedAt = 0;

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

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getAU(): ?string
    {
        return $this->AU;
    }

    public function setAU(?string $AU): self
    {
        $this->AU = $AU;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @return Collection<int, ImageFolder>
     */
    public function getImageFolders(): Collection
    {
        return $this->imageFolders;
    }

    public function addImageFolder(ImageFolder $imageFolder): self
    {
        if (!$this->imageFolders->contains($imageFolder)) {
            $this->imageFolders[] = $imageFolder;
            $imageFolder->setPatientFolder($this);
        }

        return $this;
    }

    public function removeImageFolder(ImageFolder $imageFolder): self
    {
        if ($this->imageFolders->removeElement($imageFolder)) {
            // set the owning side to null (unless already changed)
            if ($imageFolder->getPatientFolder() === $this) {
                $imageFolder->setPatientFolder(null);
            }
        }

        return $this;
    }
}
