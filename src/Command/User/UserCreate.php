<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Entity\User;
use App\Service\UserManager\UserManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserCreate extends Command
{
    public function __construct(
        private LoggerInterface $logger,
        private UserManagerInterface $userManager,
        private ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('user:create')
            ->setDescription('Create a user')
            ->addArgument('email', InputArgument::REQUIRED, 'The user email address')
            ->addArgument('username', InputArgument::REQUIRED, 'The username used to authenticate the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password used to authenticate the user')
            ->addOption('locale', 'L', InputOption::VALUE_OPTIONAL, 'The user locale', 'en')
            ->addOption('admin', 'A', InputOption::VALUE_NONE, 'Grants the user administrator privileges');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();
        $user
            ->setEmail($input->getArgument('email'))
            ->setEnabled(true)
            ->setLocale($input->getOption('locale'))
            ->setPlainPassword($input->getArgument('password'))
            ->setPlainPasswordConfirmation($input->getArgument('password'))
            ->setPrivacyPolicy(true)
            ->setUsername($input->getArgument('username'));

        if ($input->getOption('admin')) {
            $user->addRole('ROLE_ADMIN');
        }

        if (count($violations = $this->validator->validate($user, groups: ['write'])) !== 0) {
            foreach ($violations as $violation) {
                $message = sprintf('"%s": %s', $violation->getPropertyPath(), $violation->getMessage());
                $this->logger->error($message);
                $io->error($message);
            }

            return self::FAILURE;
        }

        $this->userManager->createUser($user);

        $message = sprintf('The user "%s" has been created.', $user->getUsername());
        $this->logger->info($message);
        $io->success($message);

        return self::SUCCESS;
    }
}
