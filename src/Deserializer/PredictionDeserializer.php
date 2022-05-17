<?php

namespace App\Deserializer;

use App\Contract\InputFormatter;
use App\Dto\PartnerMetadata;
use App\Dto\PredictionData;
use App\Entity\Location;
use App\Partner\PartnerBase;
use App\Entity\Prediction;
use App\Exception\InvalidTempScaleException;
use App\Repository\PredictionRepository;
use App\Service\TempScaleFactoryService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * If Symfony's deserializer is used this Class won't be needed.
 */
class PredictionDeserializer implements InputFormatter
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PredictionRepository $predictionRepository,
        private TempScaleFactoryService $tempScaleFactory,
    )
    {
    }

    /**
     * @throws InvalidTempScaleException
     */
    public function deserialize(
        array $decodedPredictionsData,
        PartnerMetadata $decodedMetaData,
        Location $location,
        PartnerBase $partner
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
     * @throws InvalidTempScaleException
     */
    private function setPrediction(
        PredictionData $predictionData,
        PartnerMetadata $partnerMetadata,
        Location $location,
        PartnerBase $partner
    ): Prediction
    {
        $prediction = $this->predictionRepository->findOneBy([
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
