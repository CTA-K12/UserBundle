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
            ->setName('mesd-user:user:list')
            ->setDescription('List users')
            ->setDefinition(array(
                new InputOption('username', null, InputOption::VALUE_OPTIONAL, 'Username of user(s) to view, use * for wildcard'),
                new InputOption('detail', null, InputOption::VALUE_NONE, 'Show user detail view (verbose)'),
            ))
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

        $username = $input->getOption('username');
        $detail   = $input->getOption('detail');

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");

        // Determine if the group manager has been enabled
        try {
            $groupManager =  $this->getContainer()->get("mesd_user.group_manager");

        } catch (\Exception $e) {
            $groupManager =  null;
        }

        // If specific username or username patter was requested
        if ($username) {
            $users = $userManager->findByUsername($username);
        }
        else {
            $users = $userManager->getUsers();
        }

        // Show basic list
        if (!$detail) {
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

        // Show detail view
        else {
            foreach ($users as $user) {

                // Output User Details
                $output->writeln('');
                $output->writeln('<info>==============================================</info>');
                $output->writeln('<info>User: </info><comment>' . $user->getUsername() . '</comment>');
                $output->writeln('<info>==============================================</info>');
                $output->writeln('<info>        Email:  </info><comment>' . $user->getEmail() . '</comment>');
                $output->writeln('<info>      Enabled:  </info><comment>' . ($user->getEnabled() ? 'True' : 'False') . '</comment>');
                $output->writeln('<info>       Locked:  </info><comment>' . ($user->getLocked()  ? 'True' : 'False') . '</comment>');
                $output->writeln('<info>      Expired:  </info><comment>' . ($user->getExpired() ? 'True' : 'False') . '</comment>');
                $output->writeln('<info>   Expires At:  </info><comment>' . $user->getExpiresAt() . '</comment>');
                $output->writeln('<info>   Cred. Exp.:  </info><comment>' . ($user->getCredentialsExpired() ? 'True' : 'False') . '</comment>');
                $output->writeln('<info>   Last Login:  </info><comment>' . $user->getLastLogin() . '</comment>');
                $output->writeln('<info>Paswd Req. At:  </info><comment>' . $user->getLastLogin() . '</comment>');
                $output->writeln('<info>----------------------------------------------</info>');

                // Output User Roles
                $output->writeln('<info>Roles:</info>');
                $roleCollection = $user->getRole();
                if (0 < count($roleCollection)) {
                    $table = $this->getHelper('table');
                    $table->setHeaders(array('Role', 'Description'));
                    $table->setRows(array());
                    foreach ($roleCollection as $key => $role) {
                        $table->addRow(
                            array(
                                $role->getName(),
                                $role->getDescription(),
                            )
                        );
                    }
                    $table->render($output);
                }
                else {
                    $output->writeln('<comment>No Roles Assigned</comment>');
                }

                $output->writeln('');

                 // If Groups enabled, output User Groups
                if ($groupManager) {
                    $output->writeln('<info>Groups:</info>');
                    $groupCollection = $user->getGroup();
                    if (0 < count($groupCollection)) {
                        $table = $this->getHelper('table');
                        $table->setHeaders(array('Group', 'Description', 'Roles'));
                        $table->setRows(array());
                        foreach ($groupCollection as $key => $group) {
                            $roleNames = $group->getRoleNames();
                            $table->addRow(
                                array(
                                    $group->getName(),
                                    $group->getDescription(),
                                    (0 < count($roleNames)) ? $roleNames[0] : '[No Role Assigned]'
                                )
                            );
                        }
                        $table->render($output);
                    }
                    else {
                        $output->writeln('<comment>No Groups Assigned</comment>');
                    }
                }

            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}