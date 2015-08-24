<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class JoinUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd-user:user:join')
            ->setDescription('Join user to group')
            ->setDefinition(array(
                new InputArgument('userName',  InputArgument::REQUIRED, 'Username'),
                new InputArgument('groupName', InputArgument::REQUIRED, 'Group Name'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:user:join</info> command joins a user to a group:

This interactive shell will ask you for a username and a group name.

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

        $userName  = $input->getArgument('userName');
        $groupName = $input->getArgument('groupName');

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");

        $style = new OutputFormatterStyle('magenta');
        $output->getFormatter()->setStyle('warning', $style);

        // Check to see if user has this group already
        if ($userManager->hasGroup($userName, $groupName)) {
            $output->writeln(sprintf('<error>Error: User %s already belongs to group %s</error>', $userName, $groupName));
        }
        // If no, then join group
        else {
            $userManager->joinUser($userName, $groupName);
            $output->writeln(sprintf('<comment>Joined user <info>%s</info> to group <info>%s</info></comment>', $userName, $groupName));
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
