<?php

namespace App\Enums;

use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum DeviceModelClassName: string
{
    use Names;
    use Values;

    case LIGHTING = 'Lighting';
}
