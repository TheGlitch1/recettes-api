<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\HasIdTrait;
use App\Entity\Traits\HasNameTrait;
use App\Repository\SourceRepository;
use App\Entity\Traits\HasDescriptionTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
class Source
{
    use HasIdTrait;
    use HasNameTrait;
    use HasDescriptionTrait;
    use TimestampableEntity;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }
}
