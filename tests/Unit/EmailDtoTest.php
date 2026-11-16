<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\CRM\Email\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Ksfraser\FrontAccounting\CRM\Email\DTO\EmailDTO;
class EmailDtoTest extends TestCase
{
    public function testDtoRoundTripsThroughArray(): void {
        $dto = new EmailDTO(5, 'Sales', 'sales@example.com', 'smtp.example.com', '587', 'sales', 'encrypted', 'Sales Team', '1');
        $arr = $dto->toArray();
        $this->assertSame(5, $arr['account_id']);
        $this->assertSame('Sales', $arr['name']);
        $this->assertSame('sales@example.com', $arr['email_address']);
        $this->assertSame('smtp.example.com', $arr['smtp_host']);
        $this->assertSame('587', $arr['smtp_port']);
        $this->assertSame('1', $arr['is_default']);
        $dto2 = EmailDTO::fromArray($arr);
        $this->assertSame($dto->account_id, $dto2->account_id);
        $this->assertSame($dto->email_address, $dto2->email_address);
        $this->assertSame($dto->is_default, $dto2->is_default);
    }
    public function testDisplayLabelUsesNameAndEmailWhenSet(): void {
        $dto = new EmailDTO(1, 'Sales', 'sales@example.com');
        $this->assertStringContainsString('Sales', $dto->getDisplayLabel());
        $this->assertStringContainsString('sales@example.com', $dto->getDisplayLabel());
    }
    public function testDisplayLabelFallsBackToId(): void {
        $dto = new EmailDTO(9, '', '', '', '587', '', '', '', '0');
        $this->assertStringContainsString('Email Account #9', $dto->getDisplayLabel());
    }
}
