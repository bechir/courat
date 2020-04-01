<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DayRepository")
 */
class Day
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // /**
    //  * @return Collection|Planning[]
    //  */
    // public function getPlannings(): Collection
    // {
    //     return $this->plannings;
    // }

    // public function addPlanning(Planning $planning): self
    // {
    //     if (!$this->plannings->contains($planning)) {
    //         $this->plannings[] = $planning;
    //         $planning->addDay($this);
    //     }

    //     return $this;
    // }

    // public function removePlanning(Planning $planning): self
    // {
    //     if ($this->plannings->contains($planning)) {
    //         $this->plannings->removeElement($planning);
    //         $planning->removeDay($this);
    //     }

    //     return $this;
    // }
}
