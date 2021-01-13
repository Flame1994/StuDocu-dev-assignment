<?php

namespace App\Console\Commands;

use App\Answer;
use App\Console\QAndACommand;
use App\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;

/**
 */
class AddQuestions extends QAndACommand
{
    /**
     * Command constants.
     */
    protected const TITLE_ADD_QUESTIONS = 'Let\'s add some questions! What do you want to do?';
    protected const OPTION_ADD_QUESTION = 'add';
    protected const OPTION_ADD_QUESTION_DESCRIPTION = 'Add a new question';
    protected const OPTIONS = [
        self::OPTION_ADD_QUESTION => self::OPTION_ADD_QUESTION_DESCRIPTION,
    ];

    /**
     * Prompt constants.
     */
    protected const PROMPT_ENTER_QUESTION = 'Enter the question';
    protected const PROMPT_ENTER_ANSWER = 'Enter the answer to "%s"';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:add-questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add questions.';

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
        return self::TITLE_ADD_QUESTIONS;
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
            case self::OPTION_ADD_QUESTION:
                $this->AddQuestion();
                break;
        }
    }

    /**
     */
    private function AddQuestion()
    {
        $question = $this->prompt(self::PROMPT_ENTER_QUESTION);
        $answer = $this->prompt(vsprintf(self::PROMPT_ENTER_ANSWER, [$question]));

        $question = $this->questionRepository->store(
            [
                Question::COLUMN_QUESTION => $question,
                Question::COLUMN_STATUS => 0,
            ]
        );
        $this->answerRepository->store(
            [
                Answer::COLUMN_QUESTION_ID => $question->id,
                Answer::COLUMN_ANSWER => $answer,
            ]
        );


        $this->handle();
    }
}
