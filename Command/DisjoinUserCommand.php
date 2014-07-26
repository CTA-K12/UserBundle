<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class DisjoinUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:user:disjoin')
            ->setDescription('Disjoin user from group')
            ->setDefinition(array(
                new InputArgument('userName',  InputArgument::REQUIRED, 'Username'),
                new InputArgument('groupName', InputArgument::REQUIRED, 'Group Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:user:disjoin</info> command disjoins a user from a group:

This interactive shell will ask you for a username and a group name.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName  = $input->getArgument('userName');
        $groupName = $input->getArgument('groupName');

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");

        $style = new OutputFormatterStyle('magenta');
        $output->getFormatter()->setStyle('warning', $style);

        // Check to see if user has this group
        if (!$userManager->hasGroup($userName, $groupName)) {
            $output->writeln(sprintf('<error>Error: User %s doesn\'t belong to the group %s</error>', $userName, $groupName));
        }
        // If yes, then disjoin group
        else {
            $userManager->disjoinUser($userName, $groupName);
            $output->writeln(sprintf('<comment>Disjoined user <info>%s</info> from group <info>%s</info></comment>', $userName, $groupName));
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

        if (!$input->getArgument('groupName')) {
            $groupName = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter the group name:',
                function($groupName) {
                    if (empty($groupName)) {
                        return null;
                    }
                    return $groupName;
                }
            );
            $input->setArgument('groupName', $groupName);
        }

    }
}