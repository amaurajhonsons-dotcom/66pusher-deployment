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

$access = [
    'read' => [
        'read.all' => l('global.all')
    ],

    'create' => [
        'create.websites' => l('websites.title'),
        'create.personal_notifications' => l('personal_notifications.title'),
        'create.rss_automations' => l('rss_automations.title'),
        'create.recurring_campaigns' => l('recurring_campaigns.title'),
        'create.subscribers' => l('subscribers.title'),
        'create.campaigns' => l('campaigns.title'),
        'create.segments' => l('segments.title'),
        'create.flows' => l('flows.title'),
        'create.notification_handlers' => l('notification_handlers.title'),
    ],

    'update' => [
        'update.websites' => l('websites.title'),
        'update.personal_notifications' => l('personal_notifications.title'),
        'update.rss_automations' => l('rss_automations.title'),
        'update.recurring_campaigns' => l('recurring_campaigns.title'),
        'update.campaigns' => l('campaigns.title'),
        'update.segments' => l('segments.title'),
        'update.flows' => l('flows.title'),
        'update.notification_handlers' => l('notification_handlers.title'),
    ],

    'delete' => [
        'delete.websites' => l('websites.title'),
        'delete.personal_notifications' => l('personal_notifications.title'),
        'delete.rss_automations' => l('rss_automations.title'),
        'delete.recurring_campaigns' => l('recurring_campaigns.title'),
        'delete.subscribers' => l('subscribers.title'),
        'delete.subscribers_logs' => l('subscribers_logs.title'),
        'delete.campaigns' => l('campaigns.title'),
        'delete.segments' => l('segments.title'),
        'delete.flows' => l('flows.title'),
        'delete.notification_handlers' => l('notification_handlers.title'),
    ],
];

if(settings()->websites->domains_is_enabled) {
    $access['create']['create.domains'] = l('domains.title');
    $access['update']['update.domains'] = l('domains.title');
    $access['delete']['delete.domains'] = l('domains.title');
}

if(\Altum\Plugin::is_active('pwa') && settings()->websites->pwas_is_enabled) {
    $access['create']['create.pwas'] = l('pwas.title');
    $access['update']['update.pwas'] = l('pwas.title');
    $access['delete']['delete.pwas'] = l('pwas.title');
}


return $access;
