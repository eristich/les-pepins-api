<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table('QUESTION')]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ID_Question')]
    private ?int $id = null;

    #[ORM\Column(name: 'Question_Lib', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(name: 'ID_Theme', nullable: false, referencedColumnName: 'ID_Theme')]
    private ?Theme $theme = null;

    /**
     * @var Collection<int, UserResponse>
     */
    #[ORM\OneToMany(targetEntity: UserResponse::class, mappedBy: 'ID_Reponse')]
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

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): static
    {
        $this->theme = $theme;

        return $this;
    }
}
