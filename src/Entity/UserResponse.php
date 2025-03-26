<?php

namespace App\Entity;

use App\Repository\UserResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserResponseRepository::class)]
#[ORM\Table('USER_REPONSES')]
class UserResponse
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userResponses')]
    #[ORM\JoinColumn(name: 'ID_User', referencedColumnName: 'ID_User', nullable: false)]
    private ?User $id = null;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'userResponses')]
    #[ORM\JoinColumn(name: 'ID_Question', referencedColumnName: 'ID_Question', nullable: false)]
    private ?Question $question = null;

    // todo: replace column "reponse" name by "response"
    #[ORM\ManyToOne(targetEntity: Response::class, inversedBy: 'userResponses')]
    #[ORM\JoinColumn(name: 'ID_Reponse', referencedColumnName: 'ID_Reponse', nullable: false)]
    private ?Response $reponse = null;
}
