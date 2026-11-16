<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\CRM\Email\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\Menu\FAModuleMenu;
use Ksfraser\FrontAccounting\CRM\Email\Controller\EmailTabController;

class EmailAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('email', 'index.php', 'view', 'email_accounts');

        $this->add_module(_("Email"));

        $menu = new FAModuleMenu(
            'modules/ksf_FA_CRM_Email/index.php',
            'view',
            ''
        );

        $menu->addItem('email_accounts', _("Email Accounts"), MENU_INQUIRY)
             ->registerWithApp($this, 'SA_EMAIL_VIEW');

        $this->add_extensions();
    }
}
