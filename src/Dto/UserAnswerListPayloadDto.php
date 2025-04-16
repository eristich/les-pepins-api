<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserAnswerListPayloadDto
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public ?int $questionId = null;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Positive]
    public ?int $answerId = null;
}