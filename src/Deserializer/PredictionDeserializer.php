<?php

namespace App\Deserializer;

use App\Contract\PartnerInterface;
use App\Dto\PartnerMetadata;
use App\Dto\PredictionData;
use App\Entity\Location;
use App\Entity\Prediction;
use App\Exception\NonExistentTempScaleException;
use App\Repository\PredictionRepository;
use App\Service\TempScaleFactoryService;
use Doctrine\ORM\EntityManagerInterface;

class PredictionDeserializer
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PredictionRepository $predictionRepository,
        private TempScaleFactoryService $tempScaleFactory,
    )
    {
    }

    /**
     * @throws NonExistentTempScaleException
     */
    public function deserialize(
        array $decodedPredictionsData,
        PartnerMetadata $decodedMetaData,
        Location $location,
        PartnerInterface $partner
    )
    {
        foreach ($decodedPredictionsData as $predictionData) {
            $prediction = $this->setPrediction(
                $predictionData,
                $decodedMetaData,
                $location,
                $partner
            );

            $this->entityManager->persist($prediction);
        }

        $this->entityManager->flush();
    }

    /**
     * TODO Use the serializer component
     *
     * @throws NonExistentTempScaleException
     */
    private function setPrediction(
        PredictionData $predictionData,
        PartnerMetadata $partnerMetadata,
        Location $location,
        PartnerInterface $partner
    ): Prediction
    {
        $prediction = $this->predictionRepository->findBy([
            'partner_id' => $partner->getId(),
            'time' => $predictionData->getTime(),
            'date' => $partnerMetadata->getDate(),
        ]);

        if (empty($prediction)) {
            $prediction = new Prediction();
            $prediction->setLocation($location);
            $prediction->setPartnerId($partner->getId());
            $prediction->setDate($partnerMetadata->getDate());
            $prediction->setTime($predictionData->getTime());
        }

        $tempScale = $this->tempScaleFactory->create(
            $partnerMetadata->getTempScale(),
            $predictionData->getTemp()
        );
        $prediction->setTemperature($tempScale);

        return $prediction;
    }
}
