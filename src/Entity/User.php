<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=180, unique=true)
   * @Groups({"users", "comments"})
   * @Assert\Email(mode="html5")
   */
  private $email;

  /**
   * @ORM\Column(type="json")
   * @Groups({"users"})
   */
  private $roles = [];


  /**
   * @var string The hashed password
   * @ORM\Column(type="string")
   * @Assert\Regex(pattern="/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)(?=.*?[#?!@$%^&*-]).{8,}$/", message="Le mot de passe n'est pas assez sécurisé.")
   */
  private $password;

  /**
   * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
   */
  private $articles;

  /**
   * @ORM\Column(type="boolean")
   * @Groups({"articles"})
   */
  private $isActive;

  /**
   * @ORM\Column(type="datetime_immutable")
   */
  private $createdAt;

  /**
   * @ORM\Column(type="datetime_immutable", nullable=true)
   */
  private $updatedAt;

  /**
   * @ORM\OneToMany(targetEntity=Member::class, mappedBy="createdBy")
   */
  private $members;

  /**
   * @ORM\OneToMany(targetEntity=Apply::class, mappedBy="acceptedBy")
   */
  private $applies;

  /**
   * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author")
   */
  private $comments;

  /**
   * @ORM\Column(type="string", length=16)
   * @Groups({"articles", "members", "users", "comments"})
   * @Assert\Regex(pattern="#^[a-zA-Z0-9]{4,16}$#")
   * @Assert\Length(min=4, max=16)
   */
  private $nickname;

  public function __construct()
  {
    $this->articles = new ArrayCollection();
    $this->members = new ArrayCollection();
    $this->applies = new ArrayCollection();
  }

  public function __toString()
  {
    return $this->nickname;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
    return (string)$this->email;
  }

  /**
   * @deprecated since Symfony 5.3, use getUserIdentifier instead
   */
  public function getUsername(): string
  {
    return $this->email;
  }


  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  public function setRoles(array $roles): self
  {
    $this->roles = $roles;

    return $this;
  }

  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(?string $password): self
  {

    if ($password !== null)
      $this->password = $password;

    return $this;
  }

  /**
   * Returning a salt is only needed, if you are not using a modern
   * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
   *
   * @see UserInterface
   */
  public function getSalt(): ?string
  {
    return null;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials(): void
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  /**
   * @return Collection<int, Article>
   */
  public function getArticles(): Collection
  {
    return $this->articles;
  }

  public function addArticle(Article $article): self
  {
    if (!$this->articles->contains($article)) {
      $this->articles[] = $article;
      $article->setAuthor($this);
    }

    return $this;
  }

  public function removeArticle(Article $article): self
  {
    if ($this->articles->removeElement($article)) {
      // set the owning side to null (unless already changed)
      if ($article->getAuthor() === $this) {
        $article->setAuthor(null);
      }
    }

    return $this;
  }


  public function isIsActive(): ?bool
  {
    return $this->isActive;
  }

  public function setIsActive(bool $isActive): self
  {
    $this->isActive = $isActive;

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
      $member->setCreatedBy($this);
    }

    return $this;
  }

  public function removeMember(Member $member): self
  {
    if ($this->members->removeElement($member)) {
      // set the owning side to null (unless already changed)
      if ($member->getCreatedBy() === $this) {
        $member->setCreatedBy(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, Apply>
   */
  public function getApplies(): Collection
  {
    return $this->applies;
  }

  public function addApply(Apply $apply): self
  {
    if (!$this->applies->contains($apply)) {
      $this->applies[] = $apply;
      $apply->setAcceptedBy($this);
    }

    return $this;
  }

  public function removeApply(Apply $apply): self
  {
    if ($this->applies->removeElement($apply)) {
      // set the owning side to null (unless already changed)
      if ($apply->getAcceptedBy() === $this) {
        $apply->setAcceptedBy(null);
      }
    }

    return $this;
  }

  public function getNickname(): ?string
  {
    return $this->nickname;
  }

  public function setNickname(string $nickname): self
  {
    $this->nickname = $nickname;

    return $this;
  }

  /**
   * @return Collection<int, Article>
   */
  public function getComments(): Collection
  {
    return $this->comments;
  }

  public function addComment(Comment $comment): self
  {
    if (!$this->comments->contains($comment)) {
      $this->comments[] = $comment;
      $comment->setAuthor($this);
    }

    return $this;
  }

  public function removeComment(Comment $article): self
  {
    if ($this->comments->removeElement($article)) {
      // set the owning side to null (unless already changed)
      if ($article->getAuthor() === $this) {
        $article->setAuthor(null);
      }
    }

    return $this;
  }
}
