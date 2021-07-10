<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Service\UserManager\UserManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class UserDelete extends Command
{
    public function __construct(
        private LoggerInterface $logger,
        private UserManagerInterface $userManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('user:delete')
            ->setDescription('Delete a user')
            ->addArgument('username', InputArgument::REQUIRED, 'The username used to authenticate the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (is_null($user = $this->userManager->getUserByUsername($input->getArgument('username')))) {
            $message = sprintf('The user "%s" does not exists.', $input->getArgument('username'));
            $this->logger->error($message);
            $io->error($message);

            return self::FAILURE;
        }

        $this->userManager->deleteUser($user);

        $message = sprintf('The user "%s" has been deleted.', $user->getUsername());
        $this->logger->info($message);
        $io->success($message);

        return self::SUCCESS;
    }
}
