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

namespace Altum;

use Altum\Models\Campaign;
use Altum\Models\Flow;
use Altum\Models\PersonalNotification;
use Altum\Models\RecurringCampaign;
use Altum\Models\RssAutomation;

defined('ALTUMCODE') || die();

class CustomHooks {

    public static function user_initiate_registration($data = []) {

    }

    public static function user_finished_registration($data = []) {
        $plan_settings = json_decode($data['plan_settings']);

        if($plan_settings->notification_handlers_email_limit > 0) {
            db()->insert('notification_handlers', [
                'user_id' => $data['user_id'],
                'type' => 'email',
                'name' => $data['email'],
                'settings' => json_encode([
                    'email' => $data['email']
                ]),
                'datetime' => get_date(),
            ]);
        }
    }

    public static function user_delete($data = []) {

        /* Delete the potentially uploaded files on preference settings */
        if($data['user']->preferences->white_label_logo_light) {
            Uploads::delete_uploaded_file($data['user']->preferences->white_label_logo_light, 'users');
        }

        if($data['user']->preferences->white_label_logo_dark) {
            Uploads::delete_uploaded_file($data['user']->preferences->white_label_logo_dark, 'users');
        }

        if($data['user']->preferences->white_label_favicon) {
            Uploads::delete_uploaded_file($data['user']->preferences->white_label_favicon, 'users');
        }

        $user_id = $data['user']->user_id;

        /* Flows deletion */
        $result = database()->query("SELECT `flow_id` FROM `flows` WHERE `user_id` = {$user_id}");

        while($flow = $result->fetch_object()) {
            (new Flow())->delete($flow->flow_id);
        }

        /* Campaigns deletion */
        $result = database()->query("SELECT `campaign_id` FROM `campaigns` WHERE `user_id` = {$user_id}");

        while($campaign = $result->fetch_object()) {
            (new Campaign())->delete($campaign->campaign_id);
        }

        /* Personal notifications deletion */
        $result = database()->query("SELECT `personal_notification_id` FROM `personal_notifications` WHERE `user_id` = {$user_id}");

        while($personal_notification = $result->fetch_object()) {
            (new PersonalNotification())->delete($personal_notification->personal_notification_id);
        }

        /* RSS automations deletion */
        $result = database()->query("SELECT `rss_automation_id` FROM `rss_automations` WHERE `user_id` = {$user_id}");

        while($rss_automation = $result->fetch_object()) {
            (new RssAutomation())->delete($rss_automation->rss_automation_id);
        }

        /* Recurring campaigns deletion */
        $result = database()->query("SELECT `recurring_campaign_id` FROM `recurring_campaigns` WHERE `user_id` = {$user_id}");

        while($recurring_campaign = $result->fetch_object()) {
            (new RecurringCampaign())->delete($recurring_campaign->recurring_campaign_id);
        }
    }

    public static function user_payment_finished($data = []) {
        extract($data);

        db()->where('user_id', $user->user_id)->update('users', [
            'pusher_sent_push_notifications_current_month' => 0,
            'pusher_campaigns_current_month' => 0,
            'plan_campaigns_limit_notice' => 0,
            'plan_sent_push_notifications_limit_notice' => 0,
        ]);

    }

    public static function generate_language_prefixes_to_skip($data = []) {

        $prefixes = [];

        /* Base features */
        if(!empty(settings()->main->index_url)) {
            $prefixes = array_merge($prefixes, ['index.']);
        }

        if(!settings()->email_notifications->contact) {
            $prefixes = array_merge($prefixes, ['contact.']);
        }

        if(!settings()->main->api_is_enabled) {
            $prefixes = array_merge($prefixes, ['api.', 'api_documentation.', 'account_api.']);
        }

        if(!settings()->internal_notifications->admins_is_enabled) {
            $prefixes = array_merge($prefixes, ['global.notifications.']);
        }

        if(!settings()->cookie_consent->is_enabled) {
            $prefixes = array_merge($prefixes, ['global.cookie_consent.']);
        }

        if(!settings()->ads->ad_blocker_detector_is_enabled){
            $prefixes = array_merge($prefixes, ['ad_blocker_detector_modal.']);
        }

        if(!settings()->content->blog_is_enabled) {
            $prefixes = array_merge($prefixes, ['blog.']);
        }

        if(!settings()->content->pages_is_enabled) {
            $prefixes = array_merge($prefixes, ['page.', 'pages.']);
        }

        if(!settings()->users->register_is_enabled) {
            $prefixes = array_merge($prefixes, ['register.']);
        }

        /* Extended license */
        if(!settings()->payment->is_enabled) {
            $prefixes = array_merge($prefixes, ['plan.', 'pay.', 'pay_thank_you.', 'account_payments.']);
        }

        if(!settings()->payment->is_enabled || !settings()->payment->taxes_and_billing_is_enabled) {
            $prefixes = array_merge($prefixes, ['pay_billing.']);
        }

        if(!settings()->payment->is_enabled || !settings()->payment->codes_is_enabled) {
            $prefixes = array_merge($prefixes, ['account_redeem_code.']);
        }

        if(!settings()->payment->is_enabled || !settings()->payment->invoice_is_enabled) {
            $prefixes = array_merge($prefixes, ['invoice.']);
        }


        /* Plugins */
        if(!\Altum\Plugin::is_active('pwa') || !settings()->pwa->is_enabled) {
            $prefixes = array_merge($prefixes, ['pwa_install.']);
        }

        if(!\Altum\Plugin::is_active('push-notifications') || !settings()->push_notifications->is_enabled) {
            $prefixes = array_merge($prefixes, ['push_notifications_modal.']);
        }

        if(!\Altum\Plugin::is_active('teams')) {
            $prefixes = array_merge($prefixes, ['teams.', 'team.', 'team_create.', 'team_update.', 'team_members.', 'team_member_create.', 'team_member_update.', 'teams_member.', 'teams_member_delete_modal.', 'teams_member_join_modal.', 'teams_member_login_modal.']);
        }

        if(!\Altum\Plugin::is_active('affiliate') || (\Altum\Plugin::is_active('affiliate') && !settings()->affiliate->is_enabled)) {
            $prefixes = array_merge($prefixes, ['referrals.', 'affiliate.']);
        }

        /* Per product features */
        if(!settings()->websites->domains_is_enabled) {
            $prefixes = array_merge($prefixes, ['domains.', 'domain_create.', 'domain_update.', 'domain_delete_modal.']);
        }

        if(!\Altum\Plugin::is_active('pwa') || !settings()->websites->pwas_is_enabled) {
            $prefixes = array_merge($prefixes, ['pwas.', 'pwa_create.', 'pwa_update.']);
        }

        return $prefixes;

    }

}
