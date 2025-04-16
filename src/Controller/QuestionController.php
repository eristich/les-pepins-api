<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Attribute\Model;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ThemeRepository;
use OpenApi\Attributes as OA;
use App\Entity\UserAnswer;
use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\Theme;

#[Route('/api/v1/question')]
final class QuestionController extends AbstractController
{
    #[OA\Response(
        response: 200,
        description: 'Get question collection with themes and answers',
        content: new Model(type: Theme::class, groups: ['question:get-collection'])
    )]
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



    #[OA\Parameter(
        name: 'questionId',
        description: 'The ID of the question to retrieve',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Parameter(
        name: 'answerId',
        description: 'The id of the selected answer to the question',
        in: 'path',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Response(
        response: 201,
        description: 'Create a new user answer',
    )]
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

        return new Response(201);
    }
}
