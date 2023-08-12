<?php

namespace App\Dto\Statistics;

class ExperimentDevicesShareValue
{
    private string $value;
    private int $count;

    public function __construct(string $value, int $count)
    {
        $this->value = $value;
        $this->count = $count;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
