<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Email\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\App\TabRegistration;

class EmailAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('email', 'index.php', 'view', 'email_accounts');

        $this->registerTab(new TabRegistration(
            'email_accounts',
            'Email Accounts',
            'SA_EMAIL_VIEW',
            null,
            10,
            0,
            null,
            null,
            array()
        ));
    }
}
