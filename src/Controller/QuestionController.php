<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ThemeRepository;
use App\Entity\UserAnswer;
use App\Entity\Question;
use App\Entity\Answer;

#[Route('/api/v1/question')]
final class QuestionController extends AbstractController
{
    #[Route(
        path: 's', 
        name: 'api.v1.question.get-collection', 
        methods: [Request::METHOD_GET]
    )]
    public function getAll(
        SerializerInterface     $serializer,
        ThemeRepository         $themeRepository
    ): Response
    {
        $themes = $themeRepository->findAll();
        return new Response(
            $serializer->serialize($themes, 'json', ['groups' => ['question:get-collection']]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    #[Route(
        path: '/{questionId}/answer/{answerId}',
        name: 'api.v1.user-answer.post',
        methods: ['POST'],
        requirements: [
            'questionId'    => Requirement::DIGITS,
            'answerId'      => Requirement::DIGITS
        ]
    )]
    public function postAnswer(
        #[MapEntity(Question::class, 'questionId')] Question    $question,
        #[MapEntity(Answer::class, 'answerId')] Answer          $answer,
        SerializerInterface                                     $serializer,
        EntityManagerInterface                                  $entityManager,
    ): Response
    {
        $userAnswer = new UserAnswer();
        $userAnswer->setUser($this->getUser()); // todo: replace with a real user solution
        $userAnswer->setQuestion($question);
        $userAnswer->setAnswer($answer);

        $question->addUserAnswer($userAnswer);
        $entityManager->persist($userAnswer);
        $entityManager->flush();

        return new Response(
            $serializer->serialize($question, 'json', ['groups' => ['question:get-collection']]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
