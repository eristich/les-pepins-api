<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
#[ORM\Table('REPONSE')]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ID_Reponse')]
    private ?int $id = null;

    #[ORM\Column(name: 'Reponse_Lib', length: 255, nullable: true)]
    private ?string $name = null;

    // todo: replace column type "double" by "float"
    #[ORM\Column(name: 'Poids', nullable: true)]
    private ?float $weight = null;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(name: 'ID_Question', referencedColumnName: 'ID_Question', nullable: false)]
    private ?Question $question = null;

    /**
     * @return Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'reponse', cascade: ['persist', 'remove'])]
    private Collection $userResponses;

    public function __construct()
    {
        $this->userResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

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
}
