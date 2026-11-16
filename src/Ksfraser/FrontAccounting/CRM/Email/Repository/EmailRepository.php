<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Email\Repository;
final class EmailRepository {
    private string $table = 'ksf_crm_email_accounts';
    public function findAll(): array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return array(); }
        $sql = "SELECT * FROM " . TB_PREF . $this->table . " ORDER BY is_default DESC, name ASC, account_id ASC";
        $result = db_query($sql, 'Could not load email accounts');
        if ($result === false) { return array(); }
        $rows = array();
        while (($row = db_fetch_assoc($result)) !== false && $row !== null) { $rows[] = $row; }
        return $rows;
    }
    public function findById(int $id): ?array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return null; }
        $sql = "SELECT * FROM " . TB_PREF . $this->table . " WHERE account_id = " . (int) $id;
        $result = db_query($sql, 'Could not load email account');
        if ($result === false) { return null; }
        $row = db_fetch_assoc($result);
        return $row === false ? null : $row;
    }
    public function insertAccount(array $data): int {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return 0; }
        $sql = "INSERT INTO " . TB_PREF . $this->table . " (
                name, email_address, smtp_host, smtp_port, username, password_encrypted, from_name, is_default, created_at, updated_at)
            VALUES ("
            . $this->escape($data['name'] ?? '') . ", "
            . $this->escape($data['email_address'] ?? '') . ", "
            . $this->escape($data['smtp_host'] ?? '') . ", "
            . $this->intVal($data['smtp_port'] ?? 587) . ", "
            . $this->escape($data['username'] ?? '') . ", "
            . $this->escape($data['password_encrypted'] ?? '') . ", "
            . $this->escape($data['from_name'] ?? '') . ", "
            . $this->intVal($data['is_default'] ?? 0) . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ")";
        $this->dbQuery($sql);
        return $this->dbInsertId();
    }
    public function updateState(int $accountId, string $isDefault, string $name = null): void {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return; }
        $sets = ["is_default = " . $this->intVal($isDefault)];
        $sets[] = "name = " . $this->escape($name ?? '');
        $sets[] = "updated_at = " . $this->escape(date('Y-m-d H:i:s'));
        $sql = "UPDATE " . TB_PREF . $this->table . " SET " . implode(', ', $sets)
            . " WHERE account_id = " . $this->intVal($accountId);
        $this->dbQuery($sql);
    }
    private function dbQuery($sql, $errorMsg = null) {
        return db_query($sql, $errorMsg);
    }
    private function dbInsertId() {
        return db_insert_id();
    }
    private function escape($value): string {
        if ($value === null) { return 'NULL'; }
        return function_exists('db_escape') ? db_escape($value) : addslashes((string) $value);
    }
    private function intVal($value): int {
        return $value !== null ? (int) $value : 0;
    }
}
