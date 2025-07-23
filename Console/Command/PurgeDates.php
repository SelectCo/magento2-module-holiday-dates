<?php

namespace SelectCo\HolidayDates\Console\Command;

use Magento\Framework\Console\Cli;
use SelectCo\HolidayDates\Model\Holidays\PurgeDates as Dates;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PurgeDates extends Command
{
    /**
     * @var Dates
     */
    private $purgeDates;

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('holidaydates:purge');
        $this->setDescription('Purge holiday dates');
    }

    /**
     * @param Dates $purgeDates
     */
    public function __construct(Dates $purgeDates)
    {
        parent::__construct();
        $this->purgeDates = $purgeDates;
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->purgeDates->execute();

        return Cli::RETURN_SUCCESS;
    }
}
