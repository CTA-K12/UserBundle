<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Mesd\UserBundle\Model\UserManager;

class CreateRoleCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:create-role')
            ->setDescription('Create a role.')
            ->setDefinition(array(
                new InputArgument('name', InputArgument::REQUIRED, 'The Role Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'The Role Description'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:create-role</info> command creates a security role:

This interactive shell will ask you for a role name and description.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name          = $input->getArgument('name');
        $description   = $input->getArgument('description');

        $userManager =  $this->getContainer()->get("mesd_user.user_manager");
        $userManager->createRole($name, $description);

        $output->writeln(sprintf('Created role <comment>%s</comment>', $name));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a role name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Role name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('description')) {
            $description = $this->getHelper('dialog')->ask(
                $output,
                'Please choose a description:',
                function($description) {
                    return $description;
                }
            );
            $input->setArgument('description', $description);
        }

    }
}