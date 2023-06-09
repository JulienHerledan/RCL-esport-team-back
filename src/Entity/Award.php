<?php

namespace App\Entity;

use App\Repository\AwardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AwardRepository::class)
 */
class Award
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"members"})
     * @Assert\Range(min = 1, max = 3, minMessage = "Votre rang ne peut être supérieur à 1st.", maxMessage = "Votre rang ne peut être inférieur à 3rd.")
     * @Assert\NotNull
     */
    private $rank;

    /**
     * @ORM\ManyToMany(targetEntity=Member::class, inversedBy="awards")
     * @Assert\Count(min = 1)
     */
    private $members;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"members"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $competition;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->competition->getName(). ' rang: ' . $this->rank;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        $this->members->removeElement($member);

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }
}
