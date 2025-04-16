<?php

return [
    'profile' => 'Profile',
    'profile_information' => [
        'title' => 'Profile Information',
        'description' => "Update your account's profile information and email address.",
        'select_a_new_photo' => 'Select A New Photo',
        'remove_photo' => 'Remove Photo',
        'name' => 'Name',
        'email' => 'Email',
        'email_verification' => [
            'unverified' => 'Your email address is unverified.',
            're_send' => 'Click here to re-send the verification email.',
            'link' => 'A new verification link has been sent to your email address.',
        ],
        'saved.' => 'Saved.',
        'save' => 'Save',
    ],
    'update_password' => [
        'title' => 'Update Password',
        'description' => 'Ensure your account is using a long, random password to stay secure.',
        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'confirm_password' => 'Confirm Password',
        'saved.' => 'Saved.',
        'save' => 'Save',
    ],
    'two_factor_authentication' => [
        'title' => 'Two Factor Authentication',
        'description' => 'Add additional security to your account using two factor authentication.',
        'enabled_message' => 'You have enabled two factor authentication.',
        'finish_enabling' => 'Finish enabling two factor authentication.',
        'not_enabled' => 'You have not enabled two factor authentication.',
        'operation' => "When two factor authentication is enabled, you will be prompted for a secure, random token
                        during authentication. You may retrieve this token from your phone's Google Authenticator
                        application.",
        'qr_code_enabling' => "To finish enabling two factor authentication, scan the following QR code using your
                               phone's authenticator application or enter the setup key and provide the generated OTP
                               code.",
        'qr_code_enabled' => "Two factor authentication is now enabled. Scan the following QR code using your phone's
                              authenticator application or enter the setup key.",
        'setup_key' => 'Setup Key:',
        'code' => 'Code',
        'store_code_message' => 'Store these recovery codes in a secure password manager. They can be used to recover
                                 access to your account if your two factor authentication device is lost.',
        'enable' => 'Enable',
        'confirm' => 'Confirm',
        'regenerate_recovery_codes' => 'Regenerate Recovery Codes',
        'show_recovery_codes' => 'Show Recovery Codes',
        'cancel' => 'Cancel',
        'disable' => 'Disable',
    ],
    'browser_sessions' => [
        'title' => 'Browser Sessions',
        'description' => 'Manage and log out your active sessions on other browsers and devices.',
        'information_text' => 'If necessary, you may log out of all of your other browser sessions across all of your
                               devices. Some of your recent sessions are listed below; however, this list may not be
                               exhaustive. If you feel your account has been compromised, you should also update your
                               password.',
        'unknown' => 'Unknown',
        'this_device' => 'This device',
        'last_active' => 'Last active',
        'log_out_other_browser_sessions' => 'Log Out Other Browser Sessions',
        'done' => 'Done.',
        'logout_all_devices_message' => 'Please enter your password to confirm you would like to log out of your other
                                         browser sessions across all of your devices.',
        'cancel' => 'Cancel',
    ],
    'delete_account' => [
        'title' => 'Delete Account',
        'description' => 'Permanently delete your account.',
        'information_text' => 'Once your account is deleted, all of its resources and data will be permanently deleted.
                               Before deleting your account, please download any data or information that you wish to
                               retain.',
        'delete_account' => 'Delete Account',
        'permanently_delete_account_message' => 'Are you sure you want to delete your account? Once your account is
                                                 deleted, all of its resources and data will be permanently deleted.
                                                 Please enter your password to confirm you would like to permanently
                                                 delete your account.',
        'cancel' => 'Cancel',
    ],
];
