<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Email\Service;
use Ksfraser\FrontAccounting\CRM\Email\DTO\EmailDTO;
use Ksfraser\FrontAccounting\CRM\Email\Repository\EmailRepository;
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
final class EmailService {
    private $repo;
    public function __construct(?EmailRepository $repo = null) { $this->repo = $repo ?? new EmailRepository(); }
    public function resolveById(int $id, ?RelatedRecordDto $dto = null): array {
        $row = $this->repo->findById($id);
        if ($row === null) {
            return array('dto' => new RelatedRecordDto('ksf_crm_email_account', '0', 'ksf_crm_email_account', '0', null), 'fields' => $this->fieldMap(), 'labels' => $this->labelMap(), 'url' => '#', 'label' => _('Email Account #') . (string) $id);
        }
        $r = EmailDTO::fromArray($row);
        $dto = $dto ?? new RelatedRecordDto('ksf_crm_email_account', (string) $r->account_id, 'ksf_crm_email_account', (string) $r->account_id, null);
        return array(
            'dto' => $dto,
            'fields' => array(
                'account_id' => (string) $r->account_id,
                'name' => $r->name,
                'email_address' => $r->email_address,
                'smtp_host' => $r->smtp_host,
                'smtp_port' => $r->smtp_port,
                'is_default' => $r->is_default,
            ),
            'labels' => $this->labelMap(),
            'url' => '/modules/ksf_FA_CRM_Email/pages/email_account_form.php?action=edit&account_id=' . $r->account_id,
            'label' => $r->getDisplayLabel(),
        );
    }
    public function listAll(): array {
        $rows = $this->repo->findAll();
        $results = array();
        foreach ($rows as $row) {
            $r = EmailDTO::fromArray($row);
            $results[] = array(
                'id' => $r->account_id,
                'dto' => new RelatedRecordDto('ksf_crm_email_account', (string) $r->account_id, 'ksf_crm_email_account', (string) $r->account_id, null),
                'fields' => array(
                    'account_id' => (string) $r->account_id,
                    'name' => $r->name,
                    'email_address' => $r->email_address,
                    'smtp_host' => $r->smtp_host,
                    'smtp_port' => $r->smtp_port,
                    'is_default' => $r->is_default,
                ),
                'labels' => $this->labelMap(),
                'url' => '/modules/ksf_FA_CRM_Email/pages/email_account_form.php?action=edit&account_id=' . $r->account_id,
                'label' => $r->getDisplayLabel(),
            );
        }
        return $results;
    }
    public function insertAccount(array $data): int {
        return $this->repo->insertAccount($data);
    }
    public function updateState(int $accountId, string $isDefault, string $name = null): void {
        $this->repo->updateState($accountId, $isDefault, $name);
        email_account_state_changed((string) $accountId, '', 'updated', array('is_default' => $isDefault));
    }
    public function fieldMap(): array { return $this->labelMap(); }
    public function labelMap(): array {
        return array(
            'account_id' => _('Account ID'),
            'name' => _('Account Name'),
            'email_address' => _('Email Address'),
            'smtp_host' => _('SMTP Host'),
            'smtp_port' => _('SMTP Port'),
            'is_default' => _('Default'),
        );
    }
    public function getStateTransitions(string $currentState): array {
        return array();
    }
    public function isAllowedTransition(string $fromState, string $toState): bool {
        return false;
    }
}
