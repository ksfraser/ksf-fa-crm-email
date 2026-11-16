<?php
declare(strict_types=1);

if (!function_exists('hook_invoke_all')) {
    return;
}

function email_account_state_changed($accountId, $fromState, $toState, $meta = array()) {
    hook_invoke_all('EMAIL_STATE_CHANGED', array(
        'account_id' => $accountId,
        'from_state' => $fromState,
        'to_state' => $toState,
        'meta' => $meta,
    ));
}
