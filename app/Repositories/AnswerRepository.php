<?php
namespace App\Repositories;

use App\Answer;

/**
 */
class AnswerRepository implements Repository
{
    /**
     * @var Answer $model
     */
    protected $answer;

    /**
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @param array $data
     *
     * @return Answer
     */
    public function store(array $data): Answer
    {
        return $this->answer->create($data);
    }

    /**
     * @param $id
     *
     * @return Answer|null
     */
    public function show($id): ?Answer
    {
        return $this->answer->find($id);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return Answer
     */
    public function update(array $data, $id): Answer
    {
        $answer = $this->show($id);
        $answer->update($data);

        return $answer;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function destroy($id): int
    {
        return $this->answer->destroy($id);
    }

    /**
     * @return Answer[]
     */
    public function all()
    {
        return $this->answer->all();
    }

    /**
     */
    public function truncate()
    {
        $this->answer->truncate();
    }
}
