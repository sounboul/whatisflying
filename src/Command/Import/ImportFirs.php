<?php

declare(strict_types=1);

namespace App\Command\Import;

use App\Entity\Fir;
use App\Factory\FirFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ImportFirs extends AbstractImportCommand
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected FirFactoryInterface $firFactory,
        protected LoggerInterface $logger,
        protected ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('import:firs')
            ->setDescription('Import FIRs from a CSV file');
    }

    protected function createOrUpdateEntity(array $csv): object
    {
        $entity = $this->entityManager
            ->getRepository(Fir::class)
            ->findOneBy(['icaoCode' => $csv['icao_code']]);

        $entity ??= new Fir();
        $entity->update($this->firFactory->createFromCsv($csv));

        return $entity;
    }

    protected function getEntityClassName(): string
    {
        return Fir::class;
    }
}
