<?php

namespace App\Console;

use Illuminate\Console\Command;

/**
 */
abstract class QAndACommand extends Command
{
    /**
     * Base options constants.
     */
    protected const OPTION_BACK = 'back';
    protected const OPTION_BACK_SHORT = 'b';
    protected const OPTION_BACK_DESCRIPTION = 'Go back.';
    protected const OPTION_QUIT = 'quit';
    protected const OPTION_QUIT_SHORT = 'q';
    protected const OPTION_QUIT_DESCRIPTION = 'Quit.';
    protected const BASE_OPTIONS = [
        self::OPTION_BACK => self::OPTION_BACK_DESCRIPTION,
        self::OPTION_QUIT => self::OPTION_QUIT_DESCRIPTION,
    ];

    /**
     * Prompt constants.
     */
    protected const PROMPT = 'ʕ •ᴥ•ʔ > %s';
    protected const PROMPT_QUITING_APPLICATION = 'Are you sure you want to quit?';

    /**
     * Info constants.
     */
    protected const INFO_GOODBYE = 'ʕ•ᴥ•ʔﾉ♡ Bye! Hope to see you soon!';

    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     */
    public function handle()
    {
        $choice = $this->choice(vsprintf(self::PROMPT, [$this->menuTitle()]), $this->allOptions());

        $this->handleAllOptions($choice);
    }

    /**
     * @return string
     */
    abstract protected function menuTitle(): string;

    /**
     * @return string[]
     */
    abstract protected function menuOptions(): array;

    /**
     * @param string $option
     */
    abstract protected function handleMenuOptions(string $option);

    /**
     */
    abstract protected function previousCommand();

    /**
     * @param string $prompt
     *
     * @return string
     */
    protected function prompt(string $prompt): string
    {
        do {
            $input = trim($this->ask(vsprintf(self::PROMPT, [$prompt])));
        } while (empty($input));

        $this->handleBaseOptions($input);

        return $input;
    }

    /**
     * @return string[]
     */
    private function baseOptions(): array
    {
        return self::BASE_OPTIONS;
    }

    /**
     * @return string[]
     */
    protected function allOptions(): array
    {
        return array_merge($this->menuOptions(), $this->baseOptions());
    }

    /**
     * @param string $option
     */
    protected function handleBaseOptions(string $option = null)
    {
        switch ($option) {
            case self::OPTION_BACK:
            case self::OPTION_BACK_SHORT:
                $this->previousCommand();
                break;
            case self::OPTION_QUIT:
            case self::OPTION_QUIT_SHORT:
                $this->confirmQuit();
                break;
        }
    }

    /**
     * @param string $option
     */
    protected function handleAllOptions(string $option)
    {
        $this->handleBaseOptions($option);
        $this->handleMenuOptions($option);
    }

    /**
     */
    private function confirmQuit()
    {
        if ($this->confirm(self::PROMPT_QUITING_APPLICATION)) {
            $this->info(self::INFO_GOODBYE);
        } else {
            $this->previousCommand();
        }
    }
}
