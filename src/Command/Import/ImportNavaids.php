<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Navaid;
use App\Factory\NavaidFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportNavaids extends AbstractImportCommand
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected NavaidFactoryInterface $navaidFactory,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:navaids')
            ->setDescription('Import navaids from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $entity = $this->entityManager
            ->getRepository(Navaid::class)
            ->findOneBy(['slug' => $csv['slug']]);

        $entity ??= new Navaid();
        $entity->update($this->navaidFactory->createFromCsv($csv));

        return $entity;
    }

    protected function getEntityClassName(): string
    {
        return Navaid::class;
    }
}
