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
            ->setName('mesd-user:group:list')
            ->setDescription('List groups and their roles')
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

        // Verify the group manager has been enabled
        try {
            $groupManager =  $this->getContainer()->get("mesd_user.group_manager");
        } catch (\Exception $e) {
            throw new \Exception("mesd_user.group_manager service could not be found. Did you define a group_class under the mesd_user config?", 0, $e);
        }

        $groups = $groupManager->getGroups();

        if (is_array($groups)) {
            $table = $this->getHelper('table');
            $table->setHeaders(array('Group', 'Description', 'Roles'));
            foreach ($groups as $group) {
                $roleNames = $group->getRoleNames();
                sort($roleNames);
                $table->addRow(
                    array(
                        $group->getName(),
                        $group->getDescription(),
                        (0 < count($roleNames)) ? $roleNames[0] : '[No Role Assigned]'
                    )
                );

                unset($roleNames[0]);

                if (0 < count($roleNames)) {
                    foreach ($roleNames as $role) {
                        $table->addRow(
                            array(
                                '',
                                '',
                                $role
                            )
                        );
                    }
                }
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