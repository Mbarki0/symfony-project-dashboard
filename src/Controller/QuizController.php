<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
//
use Symfony\Component\HttpFoundation\Response;
//
use App\Repository\LevelRepository;
use App\Repository\QuizRepository;
use App\Repository\QuestionRepository;
use App\Repository\ProfileQuizResultRepository;
use App\Entity\ProfileQuizResult;
//
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class QuizController extends AbstractController
{

    public function __construct(
        private LevelRepository $levelRepository,
        private QuizRepository $quizRepository,
        private QuestionRepository $questionRepository,
        private ProfileQuizResultRepository $profileQuizResultRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('/quizzes/{id}', name: 'app_quizzes', defaults: ['id' => null])]
    public function index($id, Request $request): Response
    {
        if($id)
        {
            $questions = $this->questionRepository->findBy(['quiz' => $id]);

            $quiz = $this->quizRepository->find($id);
            return $this->render('quizzes/show.html.twig', [
                'questions' => $questions,
                'quiz' => $quiz,
            ]);
            exit();
        }
        $quizzes = $this->quizRepository->findAll();
        $results = $this->profileQuizResultRepository->findBy(['quiz' => $quizzes, 'profile' => $this->getUser()]);
        $levels = $this->levelRepository->findAll();
        return $this->render('quizzes/index.html.twig', [
            'levels' => $levels,
            'quizzes' => $quizzes,
            'results' => $results
        ]);
    }

    #[Route('/evaluate/{id}', name: 'evaluate_quiz', defaults: ['id' => null])]
    public function evaluateQuiz($id, Request $request): Response {
        if(!$this->getUser())
            return $this->redirectToRoute('app_login');

        if(isset($_POST['submit'])) {
            $result = 0;
            $quiz = $this->quizRepository->find($id);
            $questions = $this->questionRepository->findBy(['quiz' => $quiz]);
            foreach($questions as $question)
            {
                $correct_selects = 0;
                $selects = 0;
                $corrects = $question->getCorrects();
                $options = $question->getOptions();
                for($option = 1; $option <= sizeof($options); $option++)
                {
                    if(isset($_POST[$question->getId().'-'.$option])) {
                        if(in_array($options[$option], $corrects))
                            $correct_selects++;
                        $selects++;
                    }
                }
                if($correct_selects == $selects and $correct_selects == sizeof($corrects) and $selects > 0)
                    $result++;
            }

            if(sizeof($questions) == 0)
                return $this->redirectToRoute('app_quizzes');
            $result = $result * 100 / sizeof($questions);
            $profileQuizResult = $this->profileQuizResultRepository->findBy([
                'profile' => $this->getUser(),
                'quiz' => $quiz
            ]);

            if($profileQuizResult) {
                $profileQuizResult[0]->setResult($result);
                $this->em->persist($profileQuizResult[0]);
            } else {
                $profileQuizResult = new ProfileQuizResult();
                $profileQuizResult->setQuiz($quiz);
                $profileQuizResult->setProfile($this->getUser());
                $profileQuizResult->setResult($result);
                $this->em->persist($profileQuizResult); 
            }
            
            $this->em->flush();
            return $this->redirectToRoute('app_quizzes');
        }
    }
}
