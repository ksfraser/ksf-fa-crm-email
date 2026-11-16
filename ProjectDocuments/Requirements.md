# ksf_FA_CRM_Email — Requirements

## Purpose
Manage email integration: email accounts, templates and sent-message logging with SMTP/IMAP configuration.

## Business Rules (CRM-03)
- An email account has a name, address, SMTP host/port, credentials and a default flag.
- Email addresses are unique across accounts.
- Only one account may be the default at a time.

## Functional Requirements
- FR-EM-01: Create an email account.
- FR-EM-02: List all email accounts (summary table).
- FR-EM-03: Resolve a single account by id (related-record linking).
- FR-EM-04: Update account default flag and name.
- FR-EM-05: Expose email account fields via RELATED_TO_FIELDS.

## Non-Functional Requirements
- NF-EM-01: All database access uses native FA db_* calls.
- NF-EM-02: PHP 7.3 compatible runtime.
- NF-EM-03: Unit tests cover DTO round-trip and label resolution.
- NF-EM-04: Passwords are stored encrypted, never plaintext.
