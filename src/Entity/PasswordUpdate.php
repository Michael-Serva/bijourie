<?php 

// "entity" non ORM

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class PasswordUpdate
{

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre ancien mot de passe")
     */
    private $oldPassword;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner votre nouveau mot de passe")
     * @Assert\EqualTo(
     *  propertyPath="confirmPassword",
     *  message="Les mots de passe ne sont pas identiques"
     *  )
     */
    private $newPassword;


    /**
     * @Assert\NotBlank(message="Veuillez confirmer votre nouveau mot de passe")
     */
    private $confirmPassword;



    public function getOldPassword() : ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword) : self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }


    public function getNewPassword() : ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword) : self
    {
        $this->newPassword = $newPassword;
        return $this;
    }



    public function getConfirmPassword() : ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword) : self
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }
















}