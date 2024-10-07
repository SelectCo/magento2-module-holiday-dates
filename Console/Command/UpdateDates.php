<?php

namespace SelectCo\HolidayDates\Console\Command;

use Magento\Framework\Console\Cli;
use SelectCo\HolidayDates\Model\Holidays\UpdateDates as Dates;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateDates extends Command
{
    /**
     * @var Dates
     */
    private $updateDates;

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('holidaydates:update');
        $this->setDescription('Update holiday dates');
    }

    /**
     * @param Dates $updateDates
     */
    public function __construct(Dates $updateDates)
    {
        parent::__construct();
        $this->updateDates = $updateDates;
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->updateDates->execute();

        return Cli::RETURN_SUCCESS;
    }
}
