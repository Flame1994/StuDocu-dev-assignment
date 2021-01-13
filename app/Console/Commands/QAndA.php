<?php

namespace App\Console\Commands;

use App\Console\QAndACommand;

/**
 */
class QAndA extends QAndACommand
{
    /**
     * Command constants.
     */
    protected const TITLE = 'Do you want to add questions or view previously answered ones?';
    protected const MAIN_MENU_OPTION_ADD_QUESTIONS = 'add';
    protected const MAIN_MENU_ADD_QUESTIONS_DESCRIPTION = 'Add new questions.';
    protected const MAIN_MENU_OPTION_VIEW_QUESTIONS = 'view';
    protected const MAIN_MENU_VIEW_QUESTIONS_DESCRIPTION = 'View and practise questions.';
    protected const MAIN_MENU_OPTIONS = [
        self::MAIN_MENU_OPTION_ADD_QUESTIONS => self::MAIN_MENU_ADD_QUESTIONS_DESCRIPTION,
        self::MAIN_MENU_OPTION_VIEW_QUESTIONS => self::MAIN_MENU_VIEW_QUESTIONS_DESCRIPTION,
    ];

    /**
     * Info constants.
     */
    protected const INFO_WELCOME = 'Welcome! I\'m Sprinkles and I will be your learning guide! ʕ •ᴥ•ʔゝ';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qanda:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs an interactive command line based Q And A system.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string[]
     */
    protected function menuOptions(): array
    {
        return self::MAIN_MENU_OPTIONS;
    }

    /**
     */
    public function handle()
    {
        $this->info(self::INFO_WELCOME);

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
        return self::TITLE;
    }

    /**
     * @param string $option
     */
    protected function handleMenuOptions(string $option)
    {
        switch ($option) {
            case self::MAIN_MENU_OPTION_ADD_QUESTIONS:
                $this->call('qanda:add-questions');
                break;
            case self::MAIN_MENU_OPTION_VIEW_QUESTIONS:
                $this->call('qanda:answer-questions');
                break;
        }
    }
}
