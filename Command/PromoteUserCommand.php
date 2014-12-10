<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class PromoteUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd-user:user:promote')
            ->setDescription('Promote user to have a role')
            ->setDefinition(array(
                new InputArgument('userName', InputArgument::REQUIRED, 'Username'),
                new InputArgument('roleName',  InputArgument::REQUIRED, 'Role Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:user:promote</info> command adds a security role to a user:

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
        if ($userManager->hasRoleStandalone($userName, $roleName)) {
            $output->writeln(sprintf('<error>Error: User %s aleady has standalone role %s</error>', $userName, $roleName));
        }
        // If no, then add role
        else {
            $userManager->promoteUser($userName, $roleName);
            $output->writeln(sprintf('<comment>Promoted user <info>%s</info> to have role <info>%s</info></comment>', $userName, $roleName));
        }

        // Check if groups are in use, and if yes,
        // check if user has role via group.
        if ($this->getContainer()->hasParameter("mesd_user.group_class")) {
            if ($userManager->hasRoleFromGroups($userName, $roleName)) {
                $output->writeln(sprintf('<info>Info: User %s has role %s from group as well</info>', $userName, $roleName));
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