<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait HasPriorityTrait
{
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $priority = null;

    /**
     * Get the value of priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @return  self
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }
}
