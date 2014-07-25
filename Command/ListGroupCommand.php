<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ListGroupCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:group:list')
            ->setDescription('Create a group')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>mesd:user:group:list</info> command lists security groups

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            $groupManager =  $this->getContainer()->get("mesd_user.group_manager");
        } catch (\Exception $e) {
            throw new \Exception("mesd_user.group_manager service could not be found. Did you define a group_class under the mesd_user config?", 0, $e);
        }

        $groups = $groupManager->getGroups();

        if (is_array($groups)) {
            $table = $this->getHelper('table');
            $table->setHeaders(array('Role', 'Description'));
            foreach ($groups as $group) {
                $table->addRow(
                    array(
                        $group->getName(),
                        $group->getDescription()
                        )
                    );
            }

            $table->render($output);
        }
        else {
            $output->writeln(sprintf('<comment>No groups exist. Use <info>mesd:user:group:create</info> to create a new group.<comment>'));
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}