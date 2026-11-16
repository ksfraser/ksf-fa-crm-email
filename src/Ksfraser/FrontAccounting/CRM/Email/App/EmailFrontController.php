<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Email\App;

use ksfraser\FrontAccounting\Common\App\AbstractFrontController;

class EmailFrontController extends AbstractFrontController
{
    public function __construct(
        EmailAppShell $appShell,
        string $fallbackSecurityArea,
        string $path_to_root
    ) {
        parent::__construct($appShell, $fallbackSecurityArea, $path_to_root);
    }
}
