<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="Cet email est déjà associé à un compte"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un email")
     */
    private $email;


    /* -------
        @Assert\NotBlank(message="Veuillez saisir un mot de passe")
        @Assert\EqualTo(
        propertyPath="confirmPassword",
        message="Les mots de passe ne sont pas identiques"
        )
    */

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    // ------- @Assert\NotBlank(message="Veuillez confirmer votre mot de passe")
     
    // public $confirmPassword;



    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un nom")
     */
    private $nom;




    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir un prénom")
     */
    private $prenom;


    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }


    /* 
        L'entity User est différente des autres entity dans le sens que c'est par cette entity qu'un utilisateur va s'authentifier
        Symfony gère la sécurité
        il faut implémenter la class UserInterface
        et rajouter les 5 methodes : password username roles salt et eraseCredentials

    */

    // identifiant

    public function getUsername() : ?string
    {
        return(string) $this->email;
    }

    public function getUserIdentifier()
    {

        return $this->email;

    }


    // Roles

    public function getRoles()
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    // Renvoie la string non encodé que l'utilisateur a saisi
    public function getSalt(){}


    // nettoyer le mdp
    public function eraseCredentials(){}

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    





}
