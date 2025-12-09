<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 *  View all other existing AltumCode projects via https://altumcode.com/
 *  Get in touch for support or general queries via https://altumcode.com/contact
 *  Download the latest version via https://altumcode.com/downloads
 *
 *  X/Twitter: https://x.com/AltumCode
 *  Facebook: https://facebook.com/altumcode
 *  Instagram: https://instagram.com/altumcode
 */

defined('ALTUMCODE') || die();

$features = [];

/* Plan-related features */
$features = array_merge($features, [
    'websites_limit',
    'subscribers_limit',
    'campaigns_per_month_limit',
    'sent_push_notifications_per_month_limit',
    'personal_notifications_limit',
    'rss_automations_limit',
    'recurring_campaigns_limit',
    'segments_limit',
    'flows_limit',
]);

/* Notification handlers */
$features[] = 'notification_handlers_limit';

/* Plugin: PWA */
if(\Altum\Plugin::is_active('pwa') && settings()->websites->pwas_is_enabled) {
    $features[] = 'pwas_limit';
}

/* Notifications - Domains */
if(settings()->websites->domains_is_enabled) {
    $features[] = 'domains_limit';
}

/* Plugin: Teams */
if(\Altum\Plugin::is_active('teams')) {
    $features[] = 'teams_limit';
}

/* Plugin: Affiliate */
if(\Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled) {
    $features[] = 'affiliate_commission_percentage';
}

/* Tracking retention */
$features[] = 'subscribers_logs_retention';

/* Analytics */
$features[] = 'analytics_is_enabled';

/* Global settings */
if(settings()->main->api_is_enabled) {
    $features[] = 'api_is_enabled';
}

if(settings()->main->white_labeling_is_enabled) {
    $features[] = 'white_labeling_is_enabled';
}

/* Export features */
$features[] = sprintf(l('global.plan_settings.export'), '');

/* Additional simple user plan settings */
$features[] = 'no_ads';
$features[] = 'removable_branding_is_enabled';
$features[] = 'custom_branding_is_enabled';

return $features;
