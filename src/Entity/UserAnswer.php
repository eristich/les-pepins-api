<?php

namespace App\Entity;

use App\Repository\UserAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAnswerRepository::class)]
#[ORM\Table('USER_REPONSES')]
class UserAnswer
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'ID_User', referencedColumnName: 'ID_User', nullable: false)]
    private ?User $user = null;
    
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'ID_Question', referencedColumnName: 'ID_Question', nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(targetEntity: Answer::class, inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(name: 'ID_Reponse', referencedColumnName: 'ID_Reponse', nullable: false)]
    private ?Answer $answer = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): static
    {
        $this->answer = $answer;

        return $this;
    }
}
