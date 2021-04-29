<?php

namespace App\Manager;

use App\Entity\Score;
use App\Repository\AnswerRepository;
use App\Repository\ScoreRepository;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * Class ScoreManager
 * @package App\Manager
 */
class ScoreManager
{
    private $entityManager;
    private $security;
    private $tutorialRepository;
    private $answerRepository;
    private $scoreRepository;

    /**
     * ScoreManager constructor.
     * 
     * @param EntityManagerInterface    $entityManager
     * @param Security                  $security
     * @param TutorialRepository        $tutorialRepository
     * @param AnswerRepository          $answerRepository
     * @param ScoreRepository           $scoreRepository
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security, TutorialRepository $tutorialRepository, AnswerRepository $answerRepository, ScoreRepository $scoreRepository)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->tutorialRepository = $tutorialRepository;
        $this->answerRepository = $answerRepository;
        $this->scoreRepository = $scoreRepository;
    }

    /**
     * Compute user's score for the quizz
     *
     * @param $request
     * 
     * @return void
     */
    public function SaveScore(Request $request): void
    {
        $tutorial = $this->tutorialRepository->selectTutorialWithQuizz($request->request->get('id_tuto'));

        $userQuestions = $request->request->get('quiz');
        $dbQuestions = $tutorial[0]->getQuestions();

        $userScore = 0;

        for ($i=0; $i<$dbQuestions->count(); $i++) {
            $userScore += $this->calcForQuestion($dbQuestions[$i], $userQuestions[$i]);
        }

        $user = $this->security->getUser();
        $targetTutorial = $this->tutorialRepository->find($request->request->get('id_tuto'));
        $score = new Score();
        $score->setScore($userScore);
        $score->setPlayedAt(new \DateTime());
        $score->setLearner($user);
        $score->setTutorial($targetTutorial);

        $bestScore = $this->scoreRepository->getMaxScoreFor($user, $targetTutorial)[0]['max_score'];
        if ($bestScore !== null) {
            if ($bestScore < $userScore) {
                $user->setWallet($user->getWallet() + ($userScore - $bestScore));
            }
        } else {
            $user->setWallet($user->getWallet() + $userScore);
        }

        $this->entityManager->persist($score);
        $this->entityManager->flush();
    }

    /**
     * Compare dataBase question and user question
     *
     * @param $dbQuestion
     * @param $userQuestion
     * 
     * @return float
     */
    private function calcForQuestion($dbQuestion, $userQuestion): float
    {
        $dbAnswers = $dbQuestion->getAnswers();
        $userAnswers = $userQuestion["answers"];

        $dbArray = [];
        $userArray = [];

        for ($i=0; $i<$dbAnswers->count(); $i++) {
            $dbArray[] = (int)$dbAnswers[$i]->getIsCorrect();
            $userArray[] =  (int)$userAnswers[$i]["value"];
        }

        return $this->computeScore($dbArray, $userArray);
    }

    /**
     * Compute user's score
     *
     * @param $db
     * @param $user
     * 
     * @return float
     */
    private function computeScore($db, $user): float
    {
        $dbCount = array_count_values($db)[1];
        $countSameAnswers = 0;
        $error = false;
        for ($i=0; $i<count($db); $i++) {

            if ($user[$i] && $db[$i]) {
                $countSameAnswers++;
            }

            if (!$db[$i] && $user[$i]) {
                $error = true;
            }
        }

        if ($countSameAnswers > 0 && $error == false) {
            return $countSameAnswers / $dbCount;
        } else {
            return 0;
        }
    }
}
