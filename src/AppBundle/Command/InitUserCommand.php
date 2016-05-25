<?php

namespace AppBundle\Command;

use Biobanques\UserBundle\Entity\User;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @codeCoverageIgnore
 */
class InitUserCommand extends ContainerAwareCommand
{

    /**
     *
     * @return Collection
     *      */
    public function getCollection() {


        return $this->getContainer()->get('mongo')->getCollection('user');
    }

    protected function configure() {
        $this
                ->setName('user:createAdmin')
                ->setDescription('Create first system admin in database')
                ->addArgument(
                        'login', InputArgument::REQUIRED, 'Admin login'
                )
                ->addArgument(
                        'password', InputArgument::REQUIRED, 'Admin password'
                )
                ->addArgument(
                        'password2', InputArgument::REQUIRED, 'Please repeat password'
                )

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {


        $name = $input->getArgument('login');
        $password = $input->getArgument('password');
        $verifPassword = $input->getArgument('password2');


        $encoder = $this->getContainer()->get('security.password_encoder');

        $adminUser = new User($this->getCollection());
        if ($this->getCollection()->find()->where('username', $name)->count() != 0) {
            $output->writeln('Login already exists, please change it.');
        } elseif ($password != $verifPassword) {
            $output->writeln('Error on password validation : both provided passwords must be the equals.');
        } else {
            $adminUser->username = $name;
            $adminUser->password = $encoder->encodePassword($adminUser, $password);
            $adminUser->roles = ['ROLE_ADMIN', 'ROLE_USER'];
            if ($adminUser->save())
                $output->writeln('User created with provided credentials');
            else
                $output->writeln('An error occured');
        }
    }

}