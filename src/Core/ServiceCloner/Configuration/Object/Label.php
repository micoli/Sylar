<?php

declare(strict_types=1);

namespace App\Core\ServiceCloner\Configuration\Object;

final class Label
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
