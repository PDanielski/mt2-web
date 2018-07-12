<?php

namespace App\Command;

use App\Warmer\Warmable;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class WarmupCommandTest extends KernelTestCase {

    public function testConstructor(){
        $command = new WarmupCommand(new class implements LoggerInterface {
            public function emergency($message, array $context = array()) {
                return true;
            }

            public function alert($message, array $context = array()) {
                return true;
            }

            public function critical($message, array $context = array()) {
                return true;
            }

            public function error($message, array $context = array()) {
                return true;
            }

            public function warning($message, array $context = array()) {
                return true;
            }

            public function notice($message, array $context = array()) {
                return true;
            }

            public function info($message, array $context = array()) {
                return true;
            }

            public function debug($message, array $context = array()) {
                return true;
            }

            public function log($level, $message, array $context = array()) {
                return true;
            }

        });

        $this->assertInstanceOf(WarmupCommand::class, $command);
    }

    public function testCommandExecution(){
        $kernel = self::bootKernel();
        $container = self::$kernel->getContainer();
        $application = new Application($kernel);

        /** @var WarmupCommand $command */
        $command = $container->get('test.'.WarmupCommand::class);

        $flags = [
            false,
            false,
            false
        ];

        foreach($flags as $index => &$flag) {
            $command->registerWarmable('test'.$index, new class($flag) implements Warmable {

                protected $flag;

                public function __construct(bool &$flag) {
                    $this->flag = &$flag;
                }

                public function warmup(): void {
                    $this->flag = true;
                }

            });
        }

        $application->add($command);

        $registeredCommand = $application->find('app:warmup');
        $commandTester = new CommandTester($registeredCommand);

        for($i = 0, $count = count($flags); $i < $count; $i++) {
            $commandTester->execute([
                'warmableName' => 'test'.$i
            ]);
            $this->assertTrue($flags[$i]);
        }

    }


}