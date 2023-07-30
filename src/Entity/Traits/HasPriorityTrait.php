<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait HasPriorityTrait
{
    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['Recipe:item:get'])]
    private ?int $priority = null;

    /**
     * Get the value of priority
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @return  self
     */
    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
