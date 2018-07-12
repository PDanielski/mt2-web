<?php


namespace App\Command;


use App\Warmer\Warmable;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WarmupCommand extends Command {

    /** @var array[string]Warmable */
    protected $registry;

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        parent::__construct();
        $this->logger = $logger;
    }

    public function configure() {
        $this
            ->setName('app:warmup')
            ->setAliases(['app:wu'])
            ->addArgument('warmableName', InputArgument::REQUIRED)
            ->setDescription('This command allows you to warmup a registered object implementing the Warmable interface');
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $warmableName = $input->getArgument('warmableName');

        if($warmableName == 'all') {
            foreach($this->registry as $name => $warmable) {
                $this->warmup($name, $output);
            }
        } else {
            $this->warmup($warmableName, $output);
        }

    }

    public function registerWarmable(string $name, Warmable $warmable) {
        $this->registry[$name] = $warmable;
    }

    protected function warmup(string $name, OutputInterface $output) {
        if(!isset($this->registry[$name])){
            $output->writeln("<error>{$name} is not registered</error>");
        } else {
            $warmable = $this->registry[$name];

            $start = microtime(true);

            $warmable->warmup();

            $output->writeln("<info>{$name} warmed successfully</info>");
            $this->logger->info("Warmable '{$name}' warmed successfully",
                [
                    'warmableName' => $name,
                    'executionTime' => microtime(true) - $start
                ]);
        }
    }

}