<?php

namespace App\Repository;

use App\Dto\Statistics\ExperimentDevicesCountItem;
use App\Dto\Statistics\ExperimentDevicesShare;
use App\Dto\Statistics\ExperimentDevicesShareValue;
use App\Entity\DeviceExperimentValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeviceExperimentValue>
 *
 * @method DeviceExperimentValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceExperimentValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceExperimentValue[]    findAll()
 * @method DeviceExperimentValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceExperimentValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceExperimentValue::class);
    }

    /**
     * @return ExperimentDevicesCountItem[]
     */
    public function getExperimentsDevicesCount(): array
    {
        /* @var ExperimentDevicesCountItem[] $experimentDevicesCountItems */
        $experimentDevicesCountItems = $this->_em
            ->createQuery(sprintf('
                SELECT NEW %s(ev.experimentId, COUNT(dev.id)) AS count
                FROM %s dev
                JOIN dev.experimentValue ev
                GROUP BY ev.experimentId
            ', ExperimentDevicesCountItem::class, DeviceExperimentValue::class))
            ->getResult();
        $newExperimentDevicesCountItems = [];

        foreach ($experimentDevicesCountItems as $experimentDevicesCountItem) {
            $experimentId = $experimentDevicesCountItem->getExperimentId();
            $newExperimentDevicesCountItems[$experimentId] = $experimentDevicesCountItem;
        }

        return $newExperimentDevicesCountItems;
    }

    /**
     * @return ExperimentDevicesShare[]
     */
    public function getExperimentsDevicesShares(): array
    {
        $experimentDevicesSharesItems = $this->_em
            ->createQuery(sprintf('
                SELECT ev.experimentId, ev.value, COUNT(ev.value) AS count
                FROM %s dev
                JOIN dev.experimentValue ev
                GROUP BY ev.experimentId, ev.value
            ', DeviceExperimentValue::class))
            ->getResult();
        $experimentDevicesSharesItemsByExperiment = [];

        foreach ($experimentDevicesSharesItems as $experimentDevicesSharesItem) {
            $experimentId = $experimentDevicesSharesItem['experimentId'];

            if (!isset($experimentDevicesSharesItemsByExperiment[$experimentId])) {
                $experimentDevicesSharesItemsByExperiment[$experimentId] = new ExperimentDevicesShare($experimentId);
            }

            $experimentDevicesSharesItemsByExperiment[$experimentId]->addValue(
                new ExperimentDevicesShareValue(
                    $experimentDevicesSharesItem['value'],
                    $experimentDevicesSharesItem['count']
                )
            );
        }

        return $experimentDevicesSharesItemsByExperiment;
    }
}
