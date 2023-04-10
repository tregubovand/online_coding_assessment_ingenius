<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entities;

use InvalidArgumentException;

final class Company
{
    public function __construct(
        public string $name,
        public string $streetAddress,
        public string $city,
        public string $zipCode,
        public string $phone,
        public string $emailAddress,
    ) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty.');
        }
        if (empty(trim($streetAddress))) {
            throw new InvalidArgumentException('Street address cannot be empty.');
        }
        if (empty(trim($city))) {
            throw new InvalidArgumentException('City cannot be empty.');
        }
        if (empty(trim($zipCode))) {
            throw new InvalidArgumentException('Zip code cannot be empty.');
        }
        if (empty(trim($phone))) {
            throw new InvalidArgumentException('Phone cannot be empty.');
        }
        if (empty(trim($emailAddress))) {
            throw new InvalidArgumentException('Email address cannot be empty.');
        }
    }
}
