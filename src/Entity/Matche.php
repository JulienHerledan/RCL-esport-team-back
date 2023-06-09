<?php

namespace App\Entity;

use App\Repository\MatcheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MatcheRepository::class)
 */
class Matche
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @Groups({"matches"})
     * @Assert\NotNull
     * @Assert\Length(min=1 , max=32)
     */
    private $opponent;

    /**
     * @ORM\Column(type="date")
     * @Groups({"matches"})
     * @Assert\Type("\DateTime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     * @Groups({"matches"})
     * @Assert\Regex(pattern= "#^\d+\s*-\s*\d+$#")
     * @Assert\Length(min=3 , max=16)
     */
    private $score;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     * @Groups({"matches"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"matches"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Competition::class, inversedBy="matches")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"matches"})
     * @Assert\NotNull
     */
    private $competition;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"matches"})
     * @Assert\Url
     * @Assert\NotNull
     * @Assert\Length(min=1 , max=255)
     */
    private $opponentIcon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    public function setOpponent(string $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
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

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

    public function getOpponentIcon(): ?string
    {
        return $this->opponentIcon;
    }

    public function setOpponentIcon(string $opponentIcon): self
    {
        $this->opponentIcon = $opponentIcon;

        return $this;
    }
}
