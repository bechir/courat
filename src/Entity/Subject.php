<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject implements JsonSerializable
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
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Planning", mappedBy="subjects")
     */
    private $subjectPlannings;

    public function __construct()
    {
        $this->subjectPlannings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'code' => substr($this->code, 8),
        ];
    }

    /**
     * @return Collection|Planning[]
     */
    public function getSubjectPlannings(): Collection
    {
        return $this->subjectPlannings;
    }

    public function addSubjectPlanning(Planning $subjectPlanning): self
    {
        if (!$this->subjectPlannings->contains($subjectPlanning)) {
            $this->subjectPlannings[] = $subjectPlanning;
            $subjectPlanning->addSubject($this);
        }

        return $this;
    }

    public function removeSubjectPlanning(Planning $subjectPlanning): self
    {
        if ($this->subjectPlannings->contains($subjectPlanning)) {
            $this->subjectPlannings->removeElement($subjectPlanning);
            $subjectPlanning->removeSubject($this);
        }

        return $this;
    }
}
