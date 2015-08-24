<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ChangePasswordCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd-user:user:password')
            ->setDescription('Change user password')
            ->setDefinition(array(
                new InputArgument('userName', InputArgument::REQUIRED, 'Username'),
                new InputArgument('password', InputArgument::REQUIRED, 'Password'),
              ))
            ->setHelp(<<<EOT
The <info>mesd-user:user:password</info> command updates a users password:

This interactive shell will ask you for a username and a password.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $userName = $input->getArgument('userName');
        $password = $input->getArgument('password');

        $userManager = $this->getContainer()->get("mesd_user.user_manager");
        $user        = $userManager->findOneByUsernameOrEmail($userName);

        // Check to see if user exists
        if (!$user) {
            $output->writeln(sprintf('<error>Error: User %s does not exist</error>', $userName));
        }
        else {
            $user->setPlainPassword($password);
            $userManager->updateUser($user);
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

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askHiddenResponseAndValidate(
                $output,
                'Please enter new password:',
                function($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }

    }
}
