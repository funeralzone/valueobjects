<?php

declare(strict_types=1);

namespace Funeralzone\ValueObjects\Examples\Fruit;

use Funeralzone\ValueObjects\Enums\EnumTrait;

/**
 * @method static NonNullFastening BUTTON()
 * @method static NonNullFastening CLIP()
 * @method static NonNullFastening PIN()
 * @method static NonNullFastening ZIP()
 */
final class NonNullFastening implements Fastening
{
    use EnumTrait;

    public const BUTTON = 0;
    public const CLIP = 1;
    public const PIN = 2;
    public const ZIP = 3;
}
