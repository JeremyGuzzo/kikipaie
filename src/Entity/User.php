<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\GreaterThan(0, message = "Personne ne tape dans la caisse !")
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $spending;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupUsed;

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

    public function getSpending()
    {
        return $this->spending;
    }

    public function setSpending($spending): self
    {
        $this->spending = $spending;

        return $this;
    }

    public function getGroupUsed(): ?Group
    {
        return $this->groupUsed;
    }

    public function setGroupUsed(?Group $groupUsed): self
    {
        $this->groupUsed = $groupUsed;

        return $this;
    }
}
