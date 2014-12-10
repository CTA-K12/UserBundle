<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class DemoteUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd-user:user:demote')
            ->setDescription('Demote user to remove a role')
            ->setDefinition(array(
                new InputArgument('userName', InputArgument::REQUIRED, 'Username'),
                new InputArgument('roleName',  InputArgument::REQUIRED, 'Role Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:user:demote</info> command removes a security role from a user:

This interactive shell will ask you for a username and a role name.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('userName');
        $roleName  = $input->getArgument('roleName');

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");

        $style = new OutputFormatterStyle('magenta');
        $output->getFormatter()->setStyle('warning', $style);

        // Check to see if user has this role standalone
        if (!$userManager->hasRoleStandalone($userName, $roleName)) {
            $output->writeln(sprintf('<error>Error: User %s does not have standalone role %s</error>', $userName, $roleName));
        }
        // If yes, then remove role
        else {
            $userManager->demoteUser($userName, $roleName);
            $output->writeln(sprintf('<comment>Demoted user <info>%s</info> to remove role <info>%s</info></comment>', $userName, $roleName));
        }

        // Check if groups are in use, and if yes,
        // check if user has role via group.
        if ($this->getContainer()->hasParameter("mesd_user.group_class")) {
            if ($userManager->hasRoleFromGroups($userName, $roleName)) {
                $output->writeln(sprintf('<warning>Warning: User %s still has role %s from group</warning>', $userName, $roleName));
            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('userName')) {
            $userName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the username:',
                function($userName) {
                    if (empty($userName)) {
                        throw new \Exception('You must provide a username');
                    }

                    return $userName;
                }
            );
            $input->setArgument('userName', $userName);
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