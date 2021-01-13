<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 */
class QAndATest extends TestCase
{
    use RefreshDatabase;

    /**
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    /**
     */
    public function testQuit()
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'quit')
            ->expectsQuestion('Are you sure you want to quit?', 'yes')
            ->expectsOutput('ʕ•ᴥ•ʔﾉ♡ Bye! Hope to see you soon!')
            ->assertExitCode(0);
    }

    /**
     * @return Question
     */
    public function testAddQuestionAndAnswer()
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'add')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s add some questions! What do you want to do?', 'add')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Enter the question', 'How old am I?')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Enter the answer to "How old am I?"', '26')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s add some questions! What do you want to do?', 'quit')
            ->expectsQuestion('Are you sure you want to quit?', 'yes')
            ->assertExitCode(0);

        $question = Question::where('question', 'How old Am I?')->firstOrFail();

        $this->assertDatabaseHas('answers', [
            Answer::COLUMN_ANSWER => '26',
            Answer::COLUMN_QUESTION_ID => $question->id,
        ]);

        return $question;
    }

    /**
     * @depends testAddQuestionAndAnswer
     *
     * @param Question $question
     */
    public function testAnswerQuestionSuccess(Question $question)
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'view')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s answer some questions! What do you want to do?', 'choose')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Enter the ID of the question you want to answer.', $question->id)
            ->expectsQuestion('ʕ •ᴥ•ʔ > ' . $question->question, $question->answer->answer)
            ->expectsOutput('ᕦʕ •ᴥ•ʔᕤ > Nice! Your answer is correct.')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s answer some questions! What do you want to do?', 'quit')
            ->expectsQuestion('Are you sure you want to quit?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseHas('questions', [
            Question::COLUMN_QUESTION => 'How old am I?',
            Question::COLUMN_STATUS => 1,
        ]);
    }

    /**
     * @depends testAddQuestionAndAnswer
     *
     * @param Question $question
     */
    public function testAnswerQuestionFailed(Question $question)
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'view')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s answer some questions! What do you want to do?', 'choose')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Enter the ID of the question you want to answer.', $question->id)
            ->expectsQuestion('ʕ •ᴥ•ʔ > ' . $question->question, '50')
            ->expectsOutput('ʕ≧ᴥ≦ʔ > Your answer didn\'t match the one I found!')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s answer some questions! What do you want to do?', 'quit')
            ->expectsQuestion('Are you sure you want to quit?', 'yes')
            ->assertExitCode(0);

        $this->assertDatabaseHas('questions', [
            Question::COLUMN_QUESTION => 'How old am I?',
            Question::COLUMN_STATUS => 0,
        ]);
    }

    /**
     */
    public function testBack()
    {
        $this->artisan('qanda:interactive')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'add')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Let\'s add some questions! What do you want to do?', 'back')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to add questions or view previously answered ones?', 'quit')
            ->expectsQuestion('Are you sure you want to quit?', 'yes')
            ->assertExitCode(0);
    }

    /**
     * @depends testAddQuestionAndAnswer
     */
    public function testReset()
    {
        $this->artisan('qanda:reset')
            ->expectsQuestion('ʕ •ᴥ•ʔ > Do you want to reset all your questions and answers?', 'yes')
            ->expectsOutput('ʕ •ᴥ•ʔ > Everything has been reset!');

        static::assertFalse(Question::where(Question::COLUMN_STATUS, 1)->exists());
    }
}
