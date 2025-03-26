<?php

namespace App\Entity;

use App\Repository\UserResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserResponseRepository::class)]
#[ORM\Table('USER_REPONSES')]
class UserResponse
{
    #[ORM\Id]
    #[ORM\Column('ID_User')]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'ID_User', referencedColumnName: 'ID_Question', nullable: true)]
    private ?int $id = null;

    #[ORM\Id]
    #[ORM\Column('ID_Question')]
    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'ID_Question', referencedColumnName: 'ID_Question', nullable: true)]
    private ?int $question = null;

    #[ORM\Column('ID_Reponse')]
    #[ORM\ManyToOne(targetEntity: Response::class, inversedBy: 'reponses')]
    #[ORM\JoinColumn(name: 'ID_Reponse', referencedColumnName: 'ID_Reponse', nullable: true)]
    private ?int $reponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?int
    {
        return $this->question;
    }

    public function setQuestion(?int $question): static
    {
        $this->question = $question;
        return $this;
    }

    public function getReponse(): ?int
    {
        return $this->reponse;
    }

    public function setReponse(?int $reponse): static
    {
        $this->reponse = $reponse;
        return $this;
    }
}
