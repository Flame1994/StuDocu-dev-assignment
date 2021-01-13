<?php

namespace App\Console\Commands;

use App\Console\QAndACommand;
use App\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;

/**
 */
class AnswerQuestions extends QAndACommand
{
    /**
     * Command constants.
     */
    protected const TITLE_ANSWER_QUESTIONS = 'Let\'s answer some questions! What do you want to do?';
    protected const OPTION_CHOOSE = 'choose';
    protected const OPTION_CHOOSE_DESCRIPTION = 'Choose a question to answer';
    protected const OPTIONS = [
        self::OPTION_CHOOSE => self::OPTION_CHOOSE_DESCRIPTION,
    ];

    /**
     * Prompt constants.
     */
    protected const PROMPT_QUESTION_ID = 'Enter the ID of the question you want to answer.';

    /**
     * Error constants.
     */
    protected const ERROR_QUESTION_NOT_FOUND = 'ʕ≧ᴥ≦ʔ > Unfortunately I couldn\'t find the question! Make sure to enter the correct id.';
    protected const ERROR_INCORRECT_ANSWER = 'ʕ≧ᴥ≦ʔ > Your answer didn\'t match the one I found!';

    /**
     * Info constants.
     */
    protected const INFO_CORRECT_ANSWER = 'ᕦʕ •ᴥ•ʔᕤ > Nice! Your answer is correct.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:answer-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Answer questions.';

    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * @var AnswerRepository
     */
    protected $answerRepository;

    /**
     * @param QuestionRepository $questionRepository
     * @param AnswerRepository $answerRepository
     */
    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository)
    {
        parent::__construct();

        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    /**
     */
    public function handle()
    {
        $this->showAllQuestionAndProgress();

        parent::handle();
    }

    /**
     */
    protected function previousCommand()
    {
        $this->call('qanda:interactive');
    }

    /**
     * @return string
     */
    protected function menuTitle(): string
    {
        return self::TITLE_ANSWER_QUESTIONS;
    }

    /**
     * @return string[]
     */
    protected function menuOptions(): array
    {
        return self::OPTIONS;
    }

    /**
     * @param string $option
     */
    protected function handleMenuOptions(string $option)
    {
        switch ($option) {
            case self::OPTION_CHOOSE:
                $this->handleQuestion();
                break;
        }
    }

    /**
     */
    private function handleQuestion()
    {
        $this->answerQuestionById($this->prompt(self::PROMPT_QUESTION_ID));

        $this->handle();
    }

    /**
     * @param string $id
     */
    private function answerQuestionById(string $id)
    {
        $question = $this->questionRepository->show($id);

        if (is_null($question)) {
            $this->error(self::ERROR_QUESTION_NOT_FOUND);
        } else {
            $answer = $this->askQuestion($question);
            $this->handleAnswer($question, $answer);
        }
    }

    /**
     * @param Question|null $question
     * @param string $answer
     */
    private function handleAnswer(?Question $question, string $answer)
    {
        if (strcasecmp($question->answer->answer, $answer) == 0) {
            $this->info(self::INFO_CORRECT_ANSWER);

            $question->status = 1;
            $question->save();
        } else {
            $this->error(self::ERROR_INCORRECT_ANSWER);
        }
    }

    /**
     * @param Question $question
     *
     * @return string
     */
    private function askQuestion(Question $question): string
    {
        return $this->prompt($question->question);
    }

    /**
     */
    private function showAllQuestionAndProgress()
    {
        $this->showQuestions();
        $this->showProgress();
    }

    /**
     */
    private function showQuestions()
    {
        $this->table(
            [
                Question::COLUMN_ID,
                Question::COLUMN_QUESTION,
            ],
            Question::all(
                [
                    Question::COLUMN_ID,
                    Question::COLUMN_QUESTION,
                ]
            )->toArray()
        );
    }

    /**
     */
    private function showProgress()
    {
        $answeredQuestions = Question::where(Question::COLUMN_STATUS, 1)->get()->toArray();

        $progress = $this->output->createProgressBar(Question::all()->count());
        $progress->start();
        $progress->setProgress(count($answeredQuestions));
        $progress->clear();
        $progress->display();
    }
}
