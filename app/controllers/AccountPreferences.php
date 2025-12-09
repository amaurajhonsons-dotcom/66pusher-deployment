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

namespace Altum\Controllers;

use Altum\Alerts;

defined('ALTUMCODE') || die();

class AccountPreferences extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        if(is_null($this->user->preferences)) {
            $this->user->preferences = new \StdClass();
        }

        if(!empty($_POST)) {

            /* White labeling */
            $_POST['white_label_title'] = isset($_POST['white_label_title']) ? input_clean($_POST['white_label_title'], 32) : '';

            /* Uploads processing */
            foreach(['logo_light', 'logo_dark', 'favicon'] as $image_key) {
                $this->user->preferences->{'white_label_' . $image_key} = \Altum\Uploads::process_upload($this->user->preferences->{'white_label_' . $image_key}, 'users', 'white_label_' . $image_key, 'white_label_' . $image_key . '_remove', null);
            }

            /* Clean some posted variables */
            $_POST['default_results_per_page'] = isset($_POST['default_results_per_page']) && in_array($_POST['default_results_per_page'], [10, 25, 50, 100, 250, 500, 1000]) ? (int) $_POST['default_results_per_page'] : settings()->main->default_results_per_page;
            $_POST['default_order_type'] = isset($_POST['default_order_type']) && in_array($_POST['default_order_type'], ['ASC', 'DESC']) ? $_POST['default_order_type'] : settings()->main->default_order_type;

            /* Custom */
            $_POST['websites_default_order_by'] = isset($_POST['websites_default_order_by']) && in_array($_POST['websites_default_order_by'], ['website_id', 'name', 'last_datetime','datetime', 'host', 'path', 'total_sent_campaigns', 'total_subscribers', 'total_sent_push_notifications', 'total_displayed_push_notifications', 'total_clicked_push_notifications', 'total_closed_push_notifications']) ? $_POST['websites_default_order_by'] : 'website_id';
            $_POST['subscribers_default_order_by'] = isset($_POST['subscribers_default_order_by']) && in_array($_POST['subscribers_default_order_by'], ['subscriber_id', 'last_sent_datetime', 'datetime', 'last_datetime', 'total_sent_push_notifications']) ? $_POST['subscribers_default_order_by'] : 'subscriber_id';
            $_POST['subscribers_logs_default_order_by'] = isset($_POST['subscribers_logs_default_order_by']) && in_array($_POST['subscribers_logs_default_order_by'], ['subscriber_log_id', 'datetime',]) ? $_POST['subscribers_logs_default_order_by'] : 'subscriber_log_id';
            $_POST['campaigns_default_order_by'] = isset($_POST['campaigns_default_order_by']) && in_array($_POST['campaigns_default_order_by'], ['campaign_id', 'name', 'title', 'datetime', 'scheduled_datetime', 'last_sent_datetime', 'last_datetime', 'total_push_notifications', 'total_sent_push_notifications', 'total_displayed_push_notifications', 'total_clicked_push_notifications', 'total_closed_push_notifications']) ? $_POST['campaigns_default_order_by'] : 'campaign_id';
            $_POST['personal_notifications_default_order_by'] = isset($_POST['personal_notifications_default_order_by']) && in_array($_POST['personal_notifications_default_order_by'], ['personal_notification_id', 'name', 'title', 'sent_datetime', 'datetime', 'last_datetime',]) ? $_POST['personal_notifications_default_order_by'] : 'personal_notification_id';
            $_POST['flows_default_order_by'] = isset($_POST['flows_default_order_by']) && in_array($_POST['flows_default_order_by'], ['flow_id', 'name', 'title', 'last_sent_datetime', 'datetime', 'last_datetime', 'total_push_notifications', 'total_sent_push_notifications', 'total_displayed_push_notifications', 'total_clicked_push_notifications', 'total_closed_push_notifications']) ? $_POST['flows_default_order_by'] : 'flow_id';
            $_POST['rss_automations_default_order_by'] = isset($_POST['rss_automations_default_order_by']) && in_array($_POST['rss_automations_default_order_by'], ['rss_automation_id', 'datetime', 'last_datetime', 'last_check_datetime', 'next_check_datetime', 'name', 'title', 'total_push_notifications', 'total_sent_push_notifications', 'total_displayed_push_notifications', 'total_clicked_push_notifications', 'total_closed_push_notifications', 'total_campaigns']) ? $_POST['rss_automations_default_order_by'] : 'rss_automation_id';
            $_POST['recurring_campaigns_default_order_by'] = isset($_POST['recurring_campaigns_default_order_by']) && in_array($_POST['recurring_campaigns_default_order_by'], ['recurring_campaign_id', 'datetime', 'last_datetime', 'last_run_datetime', 'next_run_datetime', 'name', 'title', 'total_push_notifications', 'total_sent_push_notifications', 'total_displayed_push_notifications', 'total_clicked_push_notifications', 'total_closed_push_notifications', 'total_campaigns']) ? $_POST['recurring_campaigns_default_order_by'] : 'recurring_campaign_id';
            $_POST['segments_default_order_by'] = isset($_POST['segments_default_order_by']) && in_array($_POST['segments_default_order_by'], ['segment_id', 'name', 'datetime', 'last_datetime', 'total_subscribers']) ? $_POST['segments_default_order_by'] : 'segment_id';
            $_POST['notification_handlers_default_order_by'] = isset($_POST['notification_handlers_default_order_by']) && in_array($_POST['notification_handlers_default_order_by'], ['notification_handler_id', 'datetime', 'last_datetime', 'name']) ? $_POST['notification_handlers_default_order_by'] : 'notification_handler_id';
            $_POST['domains_default_order_by'] = isset($_POST['domains_default_order_by']) && in_array($_POST['domains_default_order_by'], ['domain_id', 'last_datetime', 'host', 'datetime']) ? $_POST['domains_default_order_by'] : 'domain_id';
            $_POST['pwas_default_order_by'] = isset($_POST['pwas_default_order_by']) && in_array($_POST['pwas_default_order_by'], ['pwa_id', 'last_datetime', 'datetime', 'name']) ? $_POST['pwas_default_order_by'] : 'pwa_id';

            /* Allowed dashboard features */
            $allowed_dashboard_features = ['websites', 'subscribers', 'campaigns', 'personal_notifications', 'rss_automations', 'recurring_campaigns', 'flows', 'segments'];

            /* Sanitize input - keep only valid features */
            $_POST['dashboard'] = array_values(array_filter($_POST['dashboard'], fn($item) => in_array($item, $allowed_dashboard_features)));

            /* Preserve the order of $_POST['dashboard'] */
            $dashboard = array_fill_keys($_POST['dashboard'], true);

            /* Append missing features at the end with false */
            foreach ($allowed_dashboard_features as $feature) {
                if(!array_key_exists($feature, $dashboard)) {
                    $dashboard[$feature] = false;
                }
            }

            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Alerts::add_error('Please create an account on the demo to test out this function.');

            /* Check for any errors */
            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $preferences = json_encode([
                    'white_label_title' => $_POST['white_label_title'],
                    'white_label_logo_light' => $this->user->preferences->white_label_logo_light,
                    'white_label_logo_dark' => $this->user->preferences->white_label_logo_dark,
                    'white_label_favicon' => $this->user->preferences->white_label_favicon,
                    'default_results_per_page' => $_POST['default_results_per_page'],
                    'default_order_type' => $_POST['default_order_type'],

                    'websites_default_order_by' => $_POST['websites_default_order_by'],
                    'subscribers_default_order_by' => $_POST['subscribers_default_order_by'],
                    'subscribers_logs_default_order_by' => $_POST['subscribers_logs_default_order_by'],
                    'campaigns_default_order_by' => $_POST['campaigns_default_order_by'],
                    'personal_notifications_default_order_by' => $_POST['personal_notifications_default_order_by'],
                    'rss_automations_default_order_by' => $_POST['rss_automations_default_order_by'],
                    'recurring_campaigns_default_order_by' => $_POST['recurring_campaigns_default_order_by'],
                    'flows_default_order_by' => $_POST['flows_default_order_by'],
                    'segments_default_order_by' => $_POST['segments_default_order_by'],
                    'notification_handlers_default_order_by' => $_POST['notification_handlers_default_order_by'],
                    'domains_default_order_by' => $_POST['domains_default_order_by'],
                    'pwas_default_order_by' => $_POST['pwas_default_order_by'],

                    'dashboard' => $dashboard,
                ]);

                /* Database query */
                db()->where('user_id', $this->user->user_id)->update('users', [
                    'preferences' => $preferences,
                ]);

                /* Set a nice success message */
                Alerts::add_success(l('account_preferences.success_message'));

                /* Clear the cache */
                cache()->deleteItemsByTag('user_id=' . $this->user->user_id);

                /* Send webhook notification if needed */
                if(settings()->webhooks->user_update) {
                    fire_and_forget('post', settings()->webhooks->user_update, [
                        'user_id' => $this->user->user_id,
                        'email' => $this->user->email,
                        'name' => $this->user->name,
                        'source' => 'account_preferences',
                        'datetime' => get_date(),
                    ]);
                }

                redirect('account-preferences');
            }

        }

        /* Get the account header menu */
        $menu = new \Altum\View('partials/account_header_menu', (array) $this);
        $this->add_view_content('account_header_menu', $menu->run());

        /* Prepare the view */
        $data = [];

        $view = new \Altum\View('account-preferences/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
