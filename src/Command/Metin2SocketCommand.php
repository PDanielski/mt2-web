<?php


namespace App\Command;


use App\Api\Metin2SocketClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Metin2SocketCommand extends Command {

    protected $client;

    public function __construct(Metin2SocketClient $client) {
        parent::__construct();
        $this->client = $client;
    }

    public function configure() {
        $this
            ->setName('app:socket-command')
            ->setAliases(array('app:scmd'))
            ->addArgument('commandName', InputArgument::REQUIRED)
            ->addArgument('commandParams', InputArgument::IS_ARRAY)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $this->client->connect();
        $commandName = $input->getArgument('commandName');
        $response = $this->client->executeCommand($commandName, ...$input->getArgument('commandParams'));
        $output->writeln("<info>Risposta:</info>");
        $output->write("<comment>".$response."</comment>");
        $output->write("\n");

    }
}