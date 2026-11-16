# ksf_FA_CRM_Email — Requirements Traceability Matrix

| Req ID | Requirement | Source | Implemented In | Verified By |
|--------|-------------|--------|----------------|-------------|
| CRM-03 | Email integration | HR-CRM_gaps.md C3 | EmailService | unit tests |
| FR-EM-01 | Create account | CRM-03 | EmailRepository::insertAccount | EmailDtoTest |
| FR-EM-02 | List accounts | CRM-03 | EmailService::listAll | (tab controller) |
| FR-EM-03 | Resolve account by id | CRM-03 | EmailService::resolveById | (capability hook) |
| FR-EM-04 | Update account | CRM-03 | EmailService::updateState | (service) |
| FR-EM-05 | RELATED_TO_FIELDS | CRM-03 | hooks.php RELATED_TO_FIELDS | (capability) |
| NF-EM-01 | Native db_* calls | AGENTS_ARCH | repository | code review |
| NF-EM-02 | PHP 7.3 compatible | AGENTS_ARCH | all src | code review |
| NF-EM-03 | Unit tests | AGENTS_ARCH | tests/Unit | phpunit |
| NF-EM-04 | Encrypted passwords | AGENTS_ARCH | service/repository | code review |
