<?php

namespace App\Console\Commands;

use App\Repositories\QuestionRepository;
use Illuminate\Console\Command;

/**
 */
class QAndAReset extends Command
{
    /**
     * Reset constants.
     */
    protected const CONFIRM_RESET = 'ʕ •ᴥ•ʔ > Do you want to reset all your questions and answers?';
    protected const RESET_COMPLETE = 'ʕ •ᴥ•ʔ > Everything has been reset!';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the interactive command line based Q and A system.';

    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        parent::__construct();

        $this->questionRepository = $questionRepository;
    }

    /**
     */
    public function handle()
    {
        if ($this->confirm(self::CONFIRM_RESET)) {
            $this->questionRepository->reset();

            $this->info(self::RESET_COMPLETE);
        }
    }
}
