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


use Altum\Response;

defined('ALTUMCODE') || die();

class Dashboard extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        $dashboard_features = ((array) $this->user->preferences->dashboard) + array_fill_keys(['websites', 'subscribers', 'campaigns', 'personal_notifications', 'rss_automations', 'recurring_campaigns', 'flows', 'segments'], true);

        /* Get subscribers */
        if($dashboard_features['subscribers']) {
            $subscribers = \Altum\Cache::cache_function_result('subscribers_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $subscribers = [];
                $subscribers_result = database()->query("SELECT * FROM `subscribers` WHERE `user_id` = {$this->user->user_id} ORDER BY `subscriber_id` DESC LIMIT 5");
                while ($row = $subscribers_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $subscribers[] = $row;
                }

                return $subscribers;
            });
        }

        /* Get campaigns */
        if($dashboard_features['campaigns']) {
            $campaigns = \Altum\Cache::cache_function_result('campaigns_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $campaigns = [];
                $campaigns_result = database()->query("SELECT * FROM `campaigns` WHERE `user_id` = {$this->user->user_id} ORDER BY `campaign_id` DESC LIMIT 5");
                while ($row = $campaigns_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $campaigns[] = $row;
                }

                return $campaigns;
            });
        }

        /* Get personal notifications */
        if($dashboard_features['personal_notifications']) {
            $personal_notifications = \Altum\Cache::cache_function_result('personal_notifications_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $personal_notifications = [];
                $personal_notifications_result = database()->query("SELECT * FROM `personal_notifications` WHERE `user_id` = {$this->user->user_id} ORDER BY `personal_notification_id` DESC LIMIT 5");
                while ($row = $personal_notifications_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $personal_notifications[] = $row;
                }

                return $personal_notifications;
            });
        }

        /* Get RSS automations */
        if($dashboard_features['rss_automations']) {
            $rss_automations = \Altum\Cache::cache_function_result('rss_automations_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $rss_automations = [];
                $rss_automations_result = database()->query("SELECT * FROM `rss_automations` WHERE `user_id` = {$this->user->user_id} ORDER BY `rss_automation_id` DESC LIMIT 5");
                while ($row = $rss_automations_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $rss_automations[] = $row;
                }

                return $rss_automations;
            });
        }

        /* Get recurring campaigns */
        if($dashboard_features['recurring_campaigns']) {
            $recurring_campaigns = \Altum\Cache::cache_function_result('recurring_campaigns_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $recurring_campaigns = [];
                $recurring_campaigns_result = database()->query("SELECT * FROM `recurring_campaigns` WHERE `user_id` = {$this->user->user_id} ORDER BY `recurring_campaign_id` DESC LIMIT 5");
                while ($row = $recurring_campaigns_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $recurring_campaigns[] = $row;
                }

                return $recurring_campaigns;
            });
        }

        /* Get flows */
        if($dashboard_features['flows']) {
            $flows = \Altum\Cache::cache_function_result('flows_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $flows = [];
                $flows_result = database()->query("SELECT * FROM `flows` WHERE `user_id` = {$this->user->user_id} ORDER BY `flow_id` DESC LIMIT 5");
                while ($row = $flows_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $flows[] = $row;
                }

                return $flows;
            });
        }

        /* Get segments */
        if($dashboard_features['segments']) {
            $segments = \Altum\Cache::cache_function_result('segments_dashboard?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function () {
                $segments = [];
                $segments_result = database()->query("SELECT * FROM `segments` WHERE `user_id` = {$this->user->user_id} ORDER BY `segment_id` DESC LIMIT 5");
                while ($row = $segments_result->fetch_object()) {
                    $row->settings = json_decode($row->settings ?? '');
                    $segments[] = $row;
                }

                return $segments;
            });
        }

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user($this->user);

        /* Get available websites */
        $websites = (new \Altum\Models\Website())->get_websites_by_user_id($this->user->user_id);
        $websites = array_reverse($websites, true);

        /* Prepare the view */
        $data = [
            'subscribers_logs_chart' => $subscribers_logs_chart ?? null,
            'websites' => $websites,
            'subscribers' => $subscribers ?? null,
            'campaigns' => $campaigns ?? null,
            'personal_notifications' => $personal_notifications ?? null,
            'rss_automations' => $rss_automations ?? null,
            'recurring_campaigns' => $recurring_campaigns ?? null,
            'flows' => $flows ?? null,
            'segments' => $segments ?? null,
            'domains' => $domains,
        ];

        $view = new \Altum\View('dashboard/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

    public function get_stats_ajax() {

        session_write_close();

        \Altum\Authentication::guard();

        if(!empty($_POST)) {
            redirect();
        }

        $start_date_query = (new \DateTime())->modify('-' . (settings()->main->chart_days ?? 30) . ' day')->format('Y-m-d');
        $end_date_query = (new \DateTime())->modify('+1 day')->format('Y-m-d');

        $convert_tz_sql = get_convert_tz_sql('`datetime`', $this->user->timezone);

        $subscribers_logs_result_query = "
                SELECT
                    `type`,
                    COUNT(*) AS `total`,
                    DATE_FORMAT({$convert_tz_sql}, '%Y-%m-%d') AS `formatted_date`
                FROM
                    `subscribers_logs`
                WHERE   
                    `user_id` = {$this->user->user_id} 
                    AND ({$convert_tz_sql} BETWEEN '{$start_date_query}' AND '{$end_date_query}')
                GROUP BY
                    `formatted_date`,
                    `type`
                ORDER BY
                    `formatted_date`
            ";

        $subscribers_logs_chart = \Altum\Cache::cache_function_result('subscribers_logs?user_id=' . $this->user->user_id, 'user_id=' . $this->user->user_id, function() use ($subscribers_logs_result_query) {
            $subscribers_logs_chart= [];

            $subscribers_logs_result = database()->query($subscribers_logs_result_query);

            /* Generate the raw chart data and save logs for later usage */
            while($row = $subscribers_logs_result->fetch_object()) {
                $label = \Altum\Date::get($row->formatted_date, 5, \Altum\Date::$default_timezone);

                $subscribers_logs_chart[$label] = isset($subscribers_logs_chart[$label]) ?
                    array_merge($subscribers_logs_chart[$label], [
                        $row->type => $row->total,
                    ]) :
                    array_merge([
                        'subscribed' => 0,
                        'unsubscribed' => 0,
                        'push_notification_sent' => 0,
                    ], [
                        $row->type => $row->total,
                    ]);
            }

            return $subscribers_logs_chart;
        }, 60 * 60 * settings()->main->chart_cache ?? 12);

        $subscribers_logs_chart = get_chart_data($subscribers_logs_chart);

        /* Widgets stats */
        $total_websites = \Altum\Cache::cache_function_result('websites_total?user_id=' . $this->user->user_id, null, function() {
            return db()->where('user_id', $this->user->user_id)->getValue('websites', 'count(*)');
        });

        $total_subscribers = \Altum\Cache::cache_function_result('subscribers_total?user_id=' . $this->user->user_id, null, function() {
            return (int) db()->where('user_id', $this->user->user_id)->getValue('websites', 'sum(total_subscribers)');
        });

        $total_campaigns = \Altum\Cache::cache_function_result('campaigns_total?user_id=' . $this->user->user_id, null, function() {
            return db()->where('user_id', $this->user->user_id)->getValue('campaigns', 'count(*)');
        });

        $total_sent_push_notifications = \Altum\Cache::cache_function_result('total_sent_push_notifications_total?user_id=' . $this->user->user_id, null, function() {
            return (int) db()->where('user_id', $this->user->user_id)->getValue('users', 'pusher_total_sent_push_notifications');
        });

        /* Get current monthly usage */
        $usage = db()->where('user_id', $this->user->user_id)->getOne('users', ['pusher_sent_push_notifications_current_month', 'pusher_campaigns_current_month',]);

        /* Prepare the data */
        $data = [
            'subscribers_logs_chart' => $subscribers_logs_chart,

            'usage' => $usage,

            /* Widgets */
            'total_websites' => $total_websites,
            'total_subscribers' => $total_subscribers,
            'total_campaigns' => $total_campaigns,
            'total_sent_push_notifications' => $total_sent_push_notifications,
        ];

        /* Set a nice success message */
        Response::json('', 'success', $data);

    }

}
