<?php 

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO 
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: '3', max: '200')]
    public string $nom;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $service;

    #[Assert\NotBlank]
    #[Assert\Length(min: '20', max: '500')]
    public string $message;
}