<?php

namespace Mesd\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class CreateGroupCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mesd:user:group:create')
            ->setDescription('Create a group')
            ->setDefinition(array(
                new InputArgument('name',        InputArgument::REQUIRED, 'Group Name'),
                new InputArgument('description', InputArgument::OPTIONAL, 'Group Description'),
              ))
            ->setHelp(<<<EOT
The <info>mesd:user:group:create</info> command creates a security role:

This interactive shell will ask you for a group name and description.

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

        try {
            $groupManager =  $this->getContainer()->get("mesd_user.group_manager");
        } catch (\Exception $e) {
            throw new \Exception("mesd_user.group_manager service could not be found. Did you define a group_class under the mesd_user config?", 0, $e);
        }

        $groupManager->createGroup($name, $description);

        $output->writeln(sprintf('Created group <comment>%s</comment>', $name));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a group name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Group name can not be empty');
                    }

                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }

        if (!$input->getArgument('description')) {
            $description = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a description (optional):',
                function($description) {
                    if (empty($description)) {
                        return null;
                    }
                    return $description;
                }
            );
            $input->setArgument('description', $description);
        }

    }
}