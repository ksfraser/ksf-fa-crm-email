<?php
declare(strict_types=1);
require_once __DIR__ . '/ComposerDependencies.php';
\Ksfraser\FrontAccounting\CRM\Email\Utils\ComposerDependencies::ensure(__DIR__);
$autoload_path = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($autoload_path)) { require_once $autoload_path; }
require_once __DIR__ . '/includes/common.inc';
require_once __DIR__ . '/includes/events.inc';
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
define('SS_ksf_FA_CRM_Email', 196 << 8);
if (!defined('SA_CRM_EMAIL_VIEW')) {
    define('SA_CRM_EMAIL_VIEW', SS_ksf_FA_CRM_Email | 1);
    define('SA_CRM_EMAIL_MANAGE', SS_ksf_FA_CRM_Email | 2);
    define('SA_CRM_EMAIL_ADMIN', SS_ksf_FA_CRM_Email | 3);
}
class hooks_ksf_FA_CRM_Email extends hooks {
    const RESPONDERS = array('RELATED_TO_FIELDS', 'EMAIL_RESOLVE', 'EMAIL_FIELDS', 'EMAIL_LIST');
    var $module_name = 'ksf_FA_CRM_Email';
    var $version = '1.0.0';
    function install_tabs($app) { }
    function install_options($app) { }
    function install_access() {
        $security_sections[SS_ksf_FA_CRM_Email] = _("Email");
        $security_areas['SA_CRM_EMAIL_VIEW'] = array(SA_CRM_EMAIL_VIEW, _("View email accounts"));
        $security_areas['SA_CRM_EMAIL_MANAGE'] = array(SA_CRM_EMAIL_MANAGE, _("Manage email accounts"));
        $security_areas['SA_CRM_EMAIL_ADMIN'] = array(SA_CRM_EMAIL_ADMIN, _("Administer email"));
        return array($security_areas, $security_sections);
    }
    function activate_extension($company, $check_only = true) {
        if ($check_only) { return true; }
        \Ksfraser\FrontAccounting\CRM\Email\Utils\ComposerDependencies::ensure(__DIR__);
        $this->update_databases($company, array(
            '0_ksf_crm_email_accounts.sql' => array('ksf_crm_email_accounts'),
        ), false);
        return true;
    }
    private function ensure_composer_dependencies() {
        \Ksfraser\FrontAccounting\CRM\Email\Utils\ComposerDependencies::ensure(__DIR__);
    }
    public function getModuleConstants(&$data, $opts = null) {
        $data['constants'] = array(
            'SS_ksf_FA_CRM_Email' => SS_ksf_FA_CRM_Email,
            'SA_CRM_EMAIL_VIEW' => SA_CRM_EMAIL_VIEW,
            'SA_CRM_EMAIL_MANAGE' => SA_CRM_EMAIL_MANAGE,
            'SA_CRM_EMAIL_ADMIN' => SA_CRM_EMAIL_ADMIN,
        );
        return true;
    }
    public function getModuleCapabilities(&$data, $opts = null) {
        $data['capabilities'] = self::RESPONDERS;
        return true;
    }
    public function hasCapability(&$data, $opts) {
        $capability = is_array($opts) && isset($opts['capability']) ? $opts['capability'] : null;
        if ($capability === null && isset($data['capability'])) { $capability = $data['capability']; }
        $data['has_capability'] = in_array($capability, self::RESPONDERS, true);
        return $data['has_capability'];
    }
    public function respondToCapabilityRequest(&$data, $opts = null) {
        $request = is_array($opts) && isset($opts['request']) ? $opts['request'] : (isset($data['request']) ? $data['request'] : 'capabilities');
        $data['request'] = $request;
        $data['module'] = $this->module_name;
        if (strpos($request, 'has:') === 0) { return $this->hasCapability($data, array('capability' => substr($request, 4))); }
        switch ($request) {
            case 'capabilities': return $this->getModuleCapabilities($data, $opts);
            case 'constants': return $this->getModuleConstants($data, $opts);
            default: $data['error'] = 'Unknown request type: ' . $request; return null;
        }
    }
    public function RELATED_TO_FIELDS(&$data, $opts = null) {
        if (!isset($data['module']) || !is_string($data['module'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[module]'; return null; }
        if (!isset($data['type']) || !is_string($data['type'])) { $data['error'] = 'RELATED_TO_FIELDS requires data[type]'; return null; }
        if ($data['type'] !== 'ksf_crm_email_account') { return null; }
        if (!isset($data['fields']) || !is_array($data['fields'])) { $data['fields'] = array(); }
        $data['fields'] = array_merge($data['fields'], array(
            'account_id' => _('Account ID'),
            'name' => _('Account Name'),
            'email_address' => _('Email Address'),
            'smtp_host' => _('SMTP Host'),
            'smtp_port' => _('SMTP Port'),
            'is_default' => _('Default'),
        ));
        return null;
    }
    public function EMAIL_RESOLVE(&$data, $opts = null) {
        if (!isset($data['account_id']) || !is_numeric($data['account_id'])) { $data['error'] = 'EMAIL_RESOLVE requires data[account_id]'; return null; }
        if (!isset($data['dto']) || !$data['dto'] instanceof RelatedRecordDto) { $data['error'] = 'EMAIL_RESOLVE requires data[dto] as RelatedRecordDto'; return null; }
        $service = new \Ksfraser\FrontAccounting\CRM\Email\Service\EmailService();
        $data['result'] = $service->resolveById((int) $data['account_id'], $data['dto']);
        return null;
    }
    public function EMAIL_FIELDS(&$data, $opts = null) {
        $data['fields'] = array(
            'account_id' => _('Account ID'),
            'name' => _('Account Name'),
            'email_address' => _('Email Address'),
            'smtp_host' => _('SMTP Host'),
            'smtp_port' => _('SMTP Port'),
            'is_default' => _('Default'),
        );
        return null;
    }
    public function EMAIL_LIST(&$data, $opts = null) {
        $service = new \Ksfraser\FrontAccounting\CRM\Email\Service\EmailService();
        $data['result'] = $service->listAll();
        return null;
    }
}
