<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

defined('ALTUMCODE') || die();

return [
    /* Main */
    'logo_light' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'avif'],
        'path' => 'main/',
    ],
    'logo_dark' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'avif'],
        'path' => 'main/',
    ],
    'logo_email' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
        'path' => 'main/',
    ],
    'favicon' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'ico', 'svg', 'gif', 'webp'],
        'path' => 'main/',
    ],
    'opengraph' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'avif'],
        'path' => 'main/',
    ],
    'custom_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'avif'],
        'path' => 'main/',
    ],
    'taxes_csv' => [
        'whitelisted_file_extensions' => ['csv'],
        'path' => 'main/',
    ],
    'resources_csv' => [
        'whitelisted_file_extensions' => ['csv'],
        'path' => 'main/',
    ],

    /* Users misc */
    'users' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp'],
        'path' => 'users/',
    ],

    /* PWA plugin */
    'app_icon' => [
        'whitelisted_file_extensions' => ['png'],
        'path' => 'pwa/',
    ],
    'app_screenshots' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png'],
        'path' => 'pwa/',
    ],
    'pwa' => [
        'path' => 'pwa/',
    ],

    /* Dynamic OG images plugin */
    'dynamic_og_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
    ],

    'push_notifications_icon' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png'],
        'path' => 'main/',
    ],

    /* Blog featured images */
    'blog' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'gif', 'webp', 'avif'],
        'path' => 'blog/',
    ],

    /* Payment proofs for offline payments */
    'offline_payment_proofs' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'avif', 'pdf'],
        'path' => 'offline_payment_proofs/',
    ],

    /* Pusher */
    'websites_icons' => [
        'whitelisted_file_extensions' => ['png'],
        'path' => 'websites_icons/'
    ],

    'websites_campaigns_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'],
        'path' => 'websites_campaigns_images/'
    ],

    'websites_flows_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'],
        'path' => 'websites_flows_images/'
    ],

    'websites_personal_notifications_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'],
        'path' => 'websites_personal_notifications_images/'
    ],

    'websites_rss_automations_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'],
        'path' => 'websites_rss_automations_images/'
    ],

    'websites_recurring_campaigns_images' => [
        'whitelisted_file_extensions' => ['jpg', 'jpeg', 'png', 'svg', 'webp', 'gif'],
        'path' => 'websites_recurring_campaigns_images/'
    ],

    'websites_subscribers_csv' => [
        'whitelisted_file_extensions' => ['csv'],
        'path' => 'main/',
    ],
];
