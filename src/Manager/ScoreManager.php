<?php

namespace App\Manager;

use App\Entity\Score;
use App\Repository\AnswerRepository;
use App\Repository\TutorialRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * ScoreManager constructor.
     * 
     * @param EntityManagerInterface    $entityManager
     * @param Security                  $security
     * @param TutorialRepository        $tutorialRepository
     * @param AnswerRepository          $answerRepository
     * 
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security, TutorialRepository $tutorialRepository, AnswerRepository $answerRepository)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->tutorialRepository = $tutorialRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     * Compute user's score for the quizz
     *
     * @param $request
     */
    public function newSaveScore($request)
    {
        $tutorial = $this->tutorialRepository->selectTutorialWithQuizz($request->request->get('id_tuto'));

        $userQuestions = $request->request->get('quiz');
        $dbQuestions = $tutorial[0]->getQuestions();

        $userScore = 0;

        for($i=0; $i<$dbQuestions->count(); $i++) {
            $userScore += $this->calcForQuestion($dbQuestions[$i], $userQuestions[$i]);
        }

        $score = new Score();
        $score->setScore($userScore);
        $score->setPlayedAt(new \DateTime());
        $score->setLearner($this->security->getUser());
        $score->setTutorial($this->tutorialRepository->find($request->request->get('id_tuto')));

        $this->entityManager->persist($score);
        $this->entityManager->flush();
    }

    /**
     * Compare dataBase question and user question
     *
     * @param $dbQuestion
     * @param $userQuestion
     * @return float
     */
    private function calcForQuestion($dbQuestion, $userQuestion): float
    {
        $dbAnswers = $dbQuestion->getAnswers();
        $userAnswers = $userQuestion["answers"];

        $dbArray = [];
        $userArray = [];

        for($i=0; $i<$dbAnswers->count(); $i++) {
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
     * @return float
     */
    private function computeScore($db, $user): float
    {
        $dbCount = array_count_values($db)[1];
        $countSameAnswers = 0;
        $error = false;
        for($i=0; $i<count($db); $i++) {

            if($user[$i] && $db[$i]) {
                $countSameAnswers++;
            }

            if(!$db[$i] && $user[$i]) {
                $error = true;
            }
        }

        if($countSameAnswers > 0 && $error == false) {
            return $countSameAnswers / $dbCount;
        } else {
            return 0;
        }
    }
}