<?php
/**
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2017
 *
 * @see      https://www.github.com/janhuang
 * @see      http://www.fast-d.cn/
 */

namespace FastD\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Testing.
 */
class ApiWatcher extends Command
{
    protected function configure()
    {
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
    }
}
