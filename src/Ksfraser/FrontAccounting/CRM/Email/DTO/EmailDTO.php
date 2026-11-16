<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Email\DTO;
final class EmailDTO {
    public $account_id;
    public $name;
    public $email_address;
    public $smtp_host;
    public $smtp_port;
    public $username;
    public $password_encrypted;
    public $from_name;
    public $is_default;
    public $created_at;
    public $updated_at;
    public function __construct(
        int $account_id,
        string $name = '',
        string $email_address = '',
        string $smtp_host = '',
        string $smtp_port = '587',
        string $username = '',
        string $password_encrypted = '',
        string $from_name = '',
        string $is_default = '0',
        string $created_at = '',
        string $updated_at = ''
    ) {
        $this->account_id = $account_id;
        $this->name = $name;
        $this->email_address = $email_address;
        $this->smtp_host = $smtp_host;
        $this->smtp_port = $smtp_port;
        $this->username = $username;
        $this->password_encrypted = $password_encrypted;
        $this->from_name = $from_name;
        $this->is_default = $is_default;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getDisplayLabel(): string {
        if ($this->name !== '' && $this->email_address !== '') {
            return sprintf(_('%s <%s>'), $this->name, $this->email_address);
        }
        return _('Email Account #') . (string) $this->account_id;
    }
    public function toArray(): array {
        return array(
            'account_id' => $this->account_id,
            'name' => $this->name,
            'email_address' => $this->email_address,
            'smtp_host' => $this->smtp_host,
            'smtp_port' => $this->smtp_port,
            'username' => $this->username,
            'password_encrypted' => $this->password_encrypted,
            'from_name' => $this->from_name,
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
    }
    public static function fromArray(array $data): self {
        return new self(
            (int) ($data['account_id'] ?? 0),
            (string) ($data['name'] ?? ''),
            (string) ($data['email_address'] ?? ''),
            (string) ($data['smtp_host'] ?? ''),
            (string) ($data['smtp_port'] ?? '587'),
            (string) ($data['username'] ?? ''),
            (string) ($data['password_encrypted'] ?? ''),
            (string) ($data['from_name'] ?? ''),
            (string) ($data['is_default'] ?? '0'),
            (string) ($data['created_at'] ?? ''),
            (string) ($data['updated_at'] ?? '')
        );
    }
}
