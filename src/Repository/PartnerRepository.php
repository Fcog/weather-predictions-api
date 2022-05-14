<?php

namespace App\Repository;

use App\Entity\Partner;

class PartnerRepository
{
    private array $collection;

    public function __construct()
    {
        $this->collection = [];
    }

    public function add(Partner $partner): void
    {
        $this->collection[] = $partner;
    }

    public function remove(Partner $partner): void
    {
        if (($key = array_search($partner, $this->collection)) !== false) {
            unset($this->collection[$key]);
        }
    }

    /**
     * @return array<int, Partner>
     */
    public function getAll(): array
    {
        return $this->collection;
    }
}
