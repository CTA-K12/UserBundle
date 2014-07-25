<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class DemoteGroupCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:group:demote')
            ->setDescription('Demote group to remove role')
            ->setDefinition(array(
                new InputArgument('groupName', InputArgument::REQUIRED, 'Group Name'),
                new InputArgument('roleName',  InputArgument::REQUIRED, 'Role Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:group:demote</info> command removes a security role from a group:

This interactive shell will ask you for a group and a role name.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $groupName = $input->getArgument('groupName');
        $roleName  = $input->getArgument('roleName');

        try {
            $groupManager =  $this->getContainer()->get("mesd_user.group_manager");
        } catch (\Exception $e) {
            throw new \Exception("mesd_user.group_manager service could not be found. Did you define a group_class under the mesd_user config?", 0, $e);
        }

        $groupManager->demoteGroup($groupName, $roleName);

        $output->writeln(sprintf('<comment>Demoted group <info>%s</info> removing role <info>%s</info></comment>', $groupName, $roleName));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('groupName')) {
            $groupName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the group name:',
                function($groupName) {
                    if (empty($groupName)) {
                        throw new \Exception('You must provide a group');
                    }

                    return $groupName;
                }
            );
            $input->setArgument('groupName', $groupName);
        }

        if (!$input->getArgument('roleName')) {
            $roleName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the role name:',
                function($roleName) {
                    if (empty($roleName)) {
                        return null;
                    }
                    return $roleName;
                }
            );
            $input->setArgument('roleName', $roleName);
        }

    }
}