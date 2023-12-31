<?php

declare(strict_types=1);

namespace Rawilk\Settings\Support;

class ValueSerializer
{
    public function serialize($value): string
    {
        return serialize($value);
    }

    public function unserialize(string $serialized)
    {
        return unserialize($serialized);
    }
}
