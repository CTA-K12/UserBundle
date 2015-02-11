<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListRoleCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:role:list')
            ->setDescription('List roles')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>mesd:user:role:list</info> command lists security roles

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $roleManager =  $this->getContainer()->get("mesd_user.role_manager");

        $roles = $roleManager->getRoles();

        if (is_array($roles)) {
            $table = $this->getHelper('table');
            $table->setHeaders(array('Role', 'Description'));
            foreach ($roles as $role) {
                $table->addRow(
                    array(
                        $role->getName(),
                        $role->getDescription()
                        )
                    );
            }

            $table->render($output);
        }
        else {
            $output->writeln(sprintf('<comment>No roles exist. Use <info>mesd:user:role:create</info> to create a new role.<comment>'));
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}