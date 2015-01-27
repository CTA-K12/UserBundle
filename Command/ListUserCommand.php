<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:user:list')
            ->setDescription('List users')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>mesd:user:user:list</info> command lists users

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");

        $users = $userManager->getUsers();

        if (is_array($users)) {
            $table = $this->getHelper('table');
            $table->setHeaders(array('Username', 'Email', 'Enabled', 'Locked','Expired', 'Cred. Exp.'));
            foreach ($users as $user) {
                $table->addRow(
                    array(
                        $user->getUsername(),
                        $user->getEmail(),
                        $user->getEnabled() ? 'True' : 'False',
                        $user->getLocked()  ? 'True' : 'False',
                        $user->getExpired() ? 'True' : 'False',
                        $user->getCredentialsExpired() ? 'True' : 'False',
                        )
                    );
            }

            $table->render($output);
        }
        else {
            $output->writeln(sprintf('<comment>No users exist. Use <info>mesd:user:user:create</info> to create a new user.<comment>'));
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}