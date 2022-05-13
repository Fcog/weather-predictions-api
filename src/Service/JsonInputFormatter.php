<?php

namespace App\Service;

use App\Entity\Prediction;
use Symfony\Component\Serializer\SerializerInterface;

class JsonInputFormatter
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    public function deserialize(string $data)
    {
        $this->serializer->deserialize($data, Prediction::class, 'json');
    }
}
