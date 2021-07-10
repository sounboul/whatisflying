<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Fix;
use App\Factory\FixFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportFixes extends AbstractImportCommand
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected FixFactoryInterface $fixFactory,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:fixes')
            ->setDescription('Import fixes from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $entity = $this->entityManager
            ->getRepository(Fix::class)
            ->findOneBy(['slug' => $csv['slug']]);

        $entity ??= new Fix();
        $entity->update($this->fixFactory->createFromCsv($csv));

        return $entity;
    }

    protected function getEntityClassName(): string
    {
        return Fix::class;
    }
}
