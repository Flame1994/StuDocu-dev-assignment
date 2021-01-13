<?php
namespace App\Repositories;

use App\Question;

/**
 */
class QuestionRepository implements Repository
{
    /**
     * @var Question $model
     */
    protected $question;

    /**
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * @param array $data
     *
     * @return Question
     */
    public function store(array $data): Question
    {
        return $this->question->create($data);
    }

    /**
     * @param $id
     *
     * @return Question|null
     */
    public function show($id): ?Question
    {
        return $this->question->find($id);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return Question
     */
    public function update(array $data, $id): Question
    {
        $question = $this->show($id);
        $question->update($data);

        return $question;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function destroy($id): int
    {
        return $this->question->destroy($id);
    }

    /**
     * @return Question[]
     */
    public function all()
    {
        return $this->question->all();
    }

    /**
     */
    public function reset()
    {
        $this->question
            ->where(Question::COLUMN_STATUS, 1)
            ->update(
                [
                    Question::COLUMN_STATUS => 0,
                ]
            );
    }
}
