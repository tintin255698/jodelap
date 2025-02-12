<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity(fields={"Email"}, message="Il y a déjà un utilsateur avec cet email")
 */
class User implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="json")
     *
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=ResaCoaching::class, mappedBy="user", orphanRemoval=true)
     */
    private $resaCoachings;

    public function __construct()
    {
        $this->resaCoachings = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->FirstName;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->Email;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        // unset the owning side of the relation if necessary
        if ($commentaire === null && $this->commentaire !== null) {
            $this->commentaire->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($commentaire !== null && $commentaire->getUser() !== $this) {
            $commentaire->setUser($this);
        }

        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|ResaCoaching[]
     */
    public function getResaCoachings(): Collection
    {
        return $this->resaCoachings;
    }

    public function addResaCoaching(ResaCoaching $resaCoaching): self
    {
        if (!$this->resaCoachings->contains($resaCoaching)) {
            $this->resaCoachings[] = $resaCoaching;
            $resaCoaching->setUser($this);
        }

        return $this;
    }

    public function removeResaCoaching(ResaCoaching $resaCoaching): self
    {
        if ($this->resaCoachings->removeElement($resaCoaching)) {
            // set the owning side to null (unless already changed)
            if ($resaCoaching->getUser() === $this) {
                $resaCoaching->setUser(null);
            }
        }

        return $this;
    }
}
