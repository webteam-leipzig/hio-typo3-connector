<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RequestHioDoctoralProgramImportCommand extends RequestHioImportCommand
{
    protected const REQUESTED_ENTITY_TYPE = 'Doc';

    protected static $defaultName = 'hio:request:doctoralProgram:import';
}
