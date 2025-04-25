<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Attribute\Model;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ThemeRepository;
use OpenApi\Attributes as OA;
use App\Entity\UserAnswer;
use App\Dto\UserAnswerDto;
use App\Entity\Question;
use App\Entity\Answer;
use App\Entity\User;
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



    #[OA\RequestBody(
        description: 'User answer to the question',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: UserAnswerDto::class))
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Create a new user answer',
    )]
    #[Route(
        path: '/user-answers',
        name: 'api.v1.user-answers.post',
        methods: ['POST'],
    )]
    public function postAnswer(
        EntityManagerInterface                          $entityManager,
        Request                                         $request,
        SerializerInterface                             $serializer,
    ): Response
    {
        /** @var UserAnswerDto[] $userAnswerListPayloadDto */
        $userAnswerListPayloadDto = $serializer->deserialize($request->getContent(), UserAnswerDto::class . '[]', 'json');

        $user = new User();
        $entityManager->persist($user);

        foreach ($userAnswerListPayloadDto as $dto) {
            // ⚡ Utilise des références légères (pas de requête ici)
            $question = $entityManager->getReference(Question::class, $dto->questionId);
            $answer = $entityManager->getReference(Answer::class, $dto->answerId);

            // 🧪 Vérifie que les entités existent vraiment
            if (!$entityManager->getUnitOfWork()->isInIdentityMap($question)) {
                $question = $entityManager->find(Question::class, $dto->questionId);
            }
            if (!$entityManager->getUnitOfWork()->isInIdentityMap($answer)) {
                $answer = $entityManager->find(Answer::class, $dto->answerId);
            }

            if (!$question || !$answer) {
                return new JsonResponse([
                    'error' => 'Question or Answer not found',
                    'questionId' => $dto->questionId,
                    'answerId' => $dto->answerId,
                ], Response::HTTP_BAD_REQUEST);
            }

            // todo: verifier si la reponse fournit par l'utilisateur fait partie des reponses possible a la question

            $userAnswer = new UserAnswer();
            $userAnswer->setUser($user);
            $userAnswer->setQuestion($question);
            $userAnswer->setAnswer($answer);

            $entityManager->persist($userAnswer);
        }

        $entityManager->flush();

        return new Response(201);
    }
}
