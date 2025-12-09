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

use Altum\Logger;
use Altum\Models\User;

defined('ALTUMCODE') || die();

class Cron extends Controller {
    public $processing_time = null;

    private function initiate() {
        /* Benchmark */
        $this->processing_time = microtime(true);

        /* Make sure no cache is being used on the endpoint */
        header('Cache-Control: no-cache');

        /* Initiation */
        set_time_limit(0);

        /* Make sure the key is correct */
        if(!isset($_GET['key']) || (isset($_GET['key']) && $_GET['key'] != settings()->cron->key)) {
            die();
        }

        /* Send webhook notification if needed */
        if(settings()->webhooks->cron_start) {
            $backtrace = debug_backtrace();
            fire_and_forget('post', settings()->webhooks->cron_start, [
                'type' => $backtrace[1]['function'] ?? null,
                'datetime' => get_date(),
            ]);
        }
    }

    private function close() {
        /* Send webhook notification if needed */
        if(settings()->webhooks->cron_end) {
            $backtrace = debug_backtrace();
            fire_and_forget('post', settings()->webhooks->cron_end, [
                'type' => $backtrace[1]['function'] ?? null,
                'datetime' => get_date(),
            ]);
        }
    }

    private function update_cron_execution_datetimes($key) {
        $date = get_date();
        $processing_time = (microtime(true) - $this->processing_time);

        /* Database query */
        database()->query("UPDATE `settings` SET `value` = JSON_SET(`value`, '$.{$key}', '{$date}', '$.{$key}_processing', {$processing_time}) WHERE `key` = 'cron'");
    }

    public function reset() {

        $this->initiate();

        $this->users_plan_expiry_checker();

        $this->users_deletion_reminder();

        $this->auto_delete_inactive_users();

        $this->auto_delete_unconfirmed_users();

        $this->users_plan_expiry_reminder();

        $this->users_campaigns_notice();

        $this->users_sent_push_notifications_notice();

        $this->statistics_cleanup();

        /* Make sure the reset date month is different than the current one to avoid double resetting */
        $reset_date = settings()->cron->reset_date ? (new \DateTime(settings()->cron->reset_date))->format('m') : null;
        $current_date = (new \DateTime())->format('m');

        if($reset_date != $current_date) {
            /* Benchmark */
            $this->processing_time = microtime(true);

            $this->logs_cleanup();

            $this->users_logs_cleanup();

            $this->internal_notifications_cleanup();

            $this->users_pusher_reset();

            /* Clear the cache */
            cache()->deleteItem('settings');

            $this->update_cron_execution_datetimes('reset_date');
        }

        $this->close();

        $this->update_cron_execution_datetimes('reset_datetime');
    }

    private function users_plan_expiry_checker() {
        if(!settings()->payment->user_plan_expiry_checker_is_enabled) {
            return;
        }

        $date = get_date();

        $result = database()->query("
            SELECT 
                `user_id`,
                `plan_id`,
                `name`,
                `email`,
                `language`,
                `anti_phishing_code`
            FROM 
                `users`
            WHERE 
                `plan_id` <> 'free'
				AND `plan_expiration_date` < '{$date}' 
            LIMIT 25
        ");

        $plans = [];
        if($result->num_rows) {
            $plans = (new \Altum\Models\Plan())->get_plans();
        }

        /* Go through each result */
        while($user = $result->fetch_object()) {

            /* Switch the user to the default plan */
            db()->where('user_id', $user->user_id)->update('users', [
                'plan_id' => 'free',
                'plan_settings' => json_encode(settings()->plan_free->settings),
                'payment_subscription_id' => ''
            ]);

            /* Prepare the email */
            $email_template = get_email_template(
                [],
                l('global.emails.user_plan_expired.subject', $user->language),
                [
                    '{{USER_PLAN_RENEW_LINK}}' => url('pay/' . $user->plan_id),
                    '{{NAME}}' => $user->name,
                    '{{PLAN_NAME}}' => $plans[$user->plan_id]->name,
                ],
                l('global.emails.user_plan_expired.body', $user->language)
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            /* Clear the cache */
            cache()->deleteItemsByTag('user_id=' .  $user->user_id);

            if(DEBUG) {
                echo sprintf('users_plan_expiry_checker() -> Plan expired for user_id %s - reverting account to free plan', $user->user_id);
            }
        }
    }

    private function users_deletion_reminder() {
        if(!settings()->users->auto_delete_inactive_users) {
            return;
        }

        /* Determine when to send the email reminder */
        $days_until_deletion = settings()->users->user_deletion_reminder;
        $days = settings()->users->auto_delete_inactive_users - $days_until_deletion;
        $past_date = (new \DateTime())->modify('-' . $days . ' days')->format('Y-m-d H:i:s');

        /* Get the users that need to be reminded */
        $result = database()->query("
            SELECT `user_id`, `name`, `email`, `language`, `anti_phishing_code` 
            FROM `users` 
            WHERE 
                `plan_id` = 'free' 
                AND `last_activity` < '{$past_date}' 
                AND `user_deletion_reminder` = 0 
                AND `type` = 0 
            LIMIT 25
        ");

        /* Go through each result */
        while($user = $result->fetch_object()) {

            /* Prepare the email */
            $email_template = get_email_template(
                [
                    '{{DAYS_UNTIL_DELETION}}' => $days_until_deletion,
                ],
                l('global.emails.user_deletion_reminder.subject', $user->language),
                [
                    '{{DAYS_UNTIL_DELETION}}' => $days_until_deletion,
                    '{{LOGIN_LINK}}' => url('login'),
                    '{{NAME}}' => $user->name,
                ],
                l('global.emails.user_deletion_reminder.body', $user->language)
            );

            if(settings()->users->user_deletion_reminder) {
                send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);
            }

            /* Update user */
            db()->where('user_id', $user->user_id)->update('users', ['user_deletion_reminder' => 1]);

            if(DEBUG) {
                if(settings()->users->user_deletion_reminder) echo sprintf('users_deletion_reminder() -> User deletion reminder email sent for user_id %s', $user->user_id);
            }
        }

    }

    private function auto_delete_inactive_users() {
        if(!settings()->users->auto_delete_inactive_users) {
            return;
        }

        /* Determine what users to delete */
        $days = settings()->users->auto_delete_inactive_users;
        $past_date = (new \DateTime())->modify('-' . $days . ' days')->format('Y-m-d H:i:s');

        /* Get the users that need to be reminded */
        $result = database()->query("
            SELECT `user_id`, `name`, `email`, `language`, `anti_phishing_code` FROM `users` WHERE `plan_id` = 'free' AND `last_activity` < '{$past_date}' AND `user_deletion_reminder` = 1 AND `type` = 0 LIMIT 25
        ");

        /* Go through each result */
        while($user = $result->fetch_object()) {

            /* Prepare the email */
            $email_template = get_email_template(
                [],
                l('global.emails.auto_delete_inactive_users.subject', $user->language),
                [
                    '{{INACTIVITY_DAYS}}' => settings()->users->auto_delete_inactive_users,
                    '{{REGISTER_LINK}}' => url('register'),
                    '{{NAME}}' => $user->name,
                ],
                l('global.emails.auto_delete_inactive_users.body', $user->language)
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            /* Delete user */
            (new User())->delete($user->user_id);

            if(DEBUG) {
                echo sprintf('User deletion for inactivity user_id %s', $user->user_id);
            }
        }

    }

    private function auto_delete_unconfirmed_users() {
        if(!settings()->users->auto_delete_unconfirmed_users) {
            return;
        }

        /* Determine what users to delete */
        $days = settings()->users->auto_delete_unconfirmed_users;
        $past_date = (new \DateTime())->modify('-' . $days . ' days')->format('Y-m-d H:i:s');

        /* Get the users that need to be reminded */
        $result = database()->query("SELECT `user_id` FROM `users` WHERE `status` = '0' AND `datetime` < '{$past_date}' LIMIT 100");

        /* Go through each result */
        while($user = $result->fetch_object()) {

            /* Delete user */
            (new User())->delete($user->user_id);

            if(DEBUG) {
                echo sprintf('User deleted for unconfirmed account user_id %s', $user->user_id);
            }
        }
    }

    private function logs_cleanup() {
        /* Clear files caches */
        clearstatcache();

        $current_month = (new \DateTime())->format('m');

        $deleted_count = 0;

        /* Get the data */
        foreach(glob(UPLOADS_PATH . 'logs/' . '*.log') as $file_path) {
            $file_last_modified = filemtime($file_path);

            if((new \DateTime())->setTimestamp($file_last_modified)->format('m') != $current_month) {
                unlink($file_path);
                $deleted_count++;
            }
        }

        if(DEBUG) {
            echo sprintf('logs_cleanup: Deleted %s file logs.', $deleted_count);
        }
    }

    private function users_logs_cleanup() {
        /* Delete old users logs */
        $ninety_days_ago_datetime = (new \DateTime())->modify('-90 days')->format('Y-m-d H:i:s');
        db()->where('datetime', $ninety_days_ago_datetime, '<')->delete('users_logs');
    }

    private function internal_notifications_cleanup() {
        /* Delete old users notifications */
        $days_ago_datetime = (new \DateTime())->modify('-30 days')->format('Y-m-d H:i:s');
        db()->where('datetime', $days_ago_datetime, '<')->delete('internal_notifications');
    }

    private function statistics_cleanup() {

        /* Only clean users that have not been cleaned recently */
        $now_datetime = get_date();

        /* Clean the track notifications table based on the users plan */
        $result = database()->query("SELECT `user_id`, `plan_settings` FROM `users` WHERE `status` = 1 AND `next_cleanup_datetime` < '{$now_datetime}'");

        /* Go through each result */
        while($user = $result->fetch_object()) {
            /* Update user cleanup date */
            db()->where('user_id', $user->user_id)->update('users', ['next_cleanup_datetime' => (new \DateTime())->modify('+1 days')->format('Y-m-d H:i:s')]);

            $user->settings = json_decode($user->settings ?? '');

            if($user->plan_settings->subscribers_logs_retention == -1) continue;

            /* Clear out old notification statistics logs */
            $x_days_ago_datetime = (new \DateTime())->modify('-' . ($user->plan_settings->subscribers_logs_retention ?? 90) . ' days')->format('Y-m-d H:i:s');
            database()->query("DELETE FROM `subscribers_logs` WHERE `user_id` = {$user->user_id} AND `datetime` < '{$x_days_ago_datetime}'");

            if(DEBUG) {
                echo sprintf('statistics cleanup done for user_id %s', $user->user_id);
            }
        }

    }

    private function users_pusher_reset() {
        db()->update('users', [
            'pusher_sent_push_notifications_current_month' => 0,
            'pusher_campaigns_current_month' => 0,
            'plan_campaigns_limit_notice' => 0,
            'plan_sent_push_notifications_limit_notice' => 0,
        ]);

        cache()->clear();
    }

    private function users_campaigns_notice() {
        /* Get the users that need to be reminded */
        $result = database()->query("
            SELECT
                `user_id`,
                `plan_id`,
                `name`,
                `email`,
                `language`,
                `anti_phishing_code`,
                `plan_settings`
            FROM
                users
            WHERE
                status = 1
                AND JSON_UNQUOTE(JSON_EXTRACT(plan_settings, '$.campaigns_per_month_limit')) != '-1'
                AND CAST(JSON_UNQUOTE(JSON_EXTRACT(plan_settings, '$.campaigns_per_month_limit')) AS UNSIGNED) < pusher_campaigns_current_month
                AND plan_campaigns_limit_notice = 0
            LIMIT 25        
        ");

        /* Go through each result */
        while($user = $result->fetch_object()) {
            if(!settings()->websites->email_notices_is_enabled) {
                return;
            }

            $user->plan_settings = json_decode($user->plan_settings ?? '');

            db()->where('user_id', $user->user_id)->update('users', [
                'plan_campaigns_limit_notice' => 1,
            ]);

            /* Clear the cache */
            cache()->deleteItemsByTag('user_id=' . $user->user_id);

            /* Prepare the email */
            $email_template = get_email_template(
                [],
                l('global.emails.user_campaigns_limit.subject', $user->language),
                [
                    '{{USER_PLAN_RENEW_LINK}}' => url('plan'),
                    '{{NAME}}' => $user->name,
                    '{{PLAN_NAME}}' => (new \Altum\Models\Plan())->get_plan_by_id($user->plan_id)->name,
                    '{{CAMPAIGNS_LIMIT}}' => $user->plan_settings->campaigns_per_month_limit,
                ],
                l('global.emails.user_campaigns_limit.body', $user->language)
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            if(DEBUG) {
                echo sprintf('User impression limit notice email sent for user_id %s', $user->user_id);
            }
        }
    }

    private function users_sent_push_notifications_notice() {
        if(!settings()->websites->email_notices_is_enabled) {
            return;
        }

        /* Get the users that need to be reminded */
        $result = database()->query("
            SELECT
                `user_id`,
                `plan_id`,
                `name`,
                `email`,
                `language`,
                `anti_phishing_code`,
                `plan_settings`
            FROM
                users
            WHERE
                status = 1
                AND JSON_UNQUOTE(JSON_EXTRACT(plan_settings, '$.sent_push_notifications_per_month_limit')) != '-1'
                AND CAST(JSON_UNQUOTE(JSON_EXTRACT(plan_settings, '$.sent_push_notifications_per_month_limit')) AS UNSIGNED) < pusher_sent_push_notifications_current_month
                AND plan_sent_push_notifications_limit_notice = 0
            LIMIT 25        
        ");

        /* Go through each result */
        while($user = $result->fetch_object()) {
            $user->plan_settings = json_decode($user->plan_settings ?? '');

            db()->where('user_id', $user->user_id)->update('users', [
                'plan_sent_push_notifications_limit_notice' => 1,
            ]);

            /* Clear the cache */
            cache()->deleteItemsByTag('user_id=' . $user->user_id);

            /* Prepare the email */
            $email_template = get_email_template(
                [],
                l('global.emails.user_sent_push_notifications_limit.subject', $user->language),
                [
                    '{{USER_PLAN_RENEW_LINK}}' => url('plan'),
                    '{{NAME}}' => $user->name,
                    '{{PLAN_NAME}}' => (new \Altum\Models\Plan())->get_plan_by_id($user->plan_id)->name,
                    '{{SENT_PUSH_NOTIFICATIONS_LIMIT}}' => $user->plan_settings->sent_push_notifications_per_month_limit,
                ],
                l('global.emails.user_sent_push_notifications_limit.body', $user->language)
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            if(DEBUG) {
                echo sprintf('User impression limit notice email sent for user_id %s', $user->user_id);
            }
        }
    }

    private function users_plan_expiry_reminder() {
        if(!settings()->payment->user_plan_expiry_reminder) {
            return;
        }

        /* Determine when to send the email reminder */
        $days = settings()->payment->user_plan_expiry_reminder;
        $future_date = (new \DateTime())->modify('+' . $days . ' days')->format('Y-m-d H:i:s');

        /* Get potential monitors from users that have almost all the conditions to get an email report right now */
        $result = database()->query("
            SELECT
                `user_id`,
                `name`,
                `email`,
                `plan_id`,
                `plan_expiration_date`,
                `language`,
                `anti_phishing_code`
            FROM 
                `users`
            WHERE 
                `status` = 1
                AND `plan_id` <> 'free'
                AND `plan_expiry_reminder` = '0'
                AND (`payment_subscription_id` IS NULL OR `payment_subscription_id` = '')
				AND `plan_expiration_date` < '{$future_date}'
            LIMIT 25
        ");

        $plans = [];
        if($result->num_rows) {
            $plans = (new \Altum\Models\Plan())->get_plans();
        }

        /* Go through each result */
        while($user = $result->fetch_object()) {

            /* Determine the exact days until expiration */
            $days_until_expiration = (new \DateTime($user->plan_expiration_date))->diff((new \DateTime()))->days;

            /* Prepare the email */
            $email_template = get_email_template(
                [
                    '{{DAYS_UNTIL_EXPIRATION}}' => $days_until_expiration,
                ],
                l('global.emails.user_plan_expiry_reminder.subject', $user->language),
                [
                    '{{DAYS_UNTIL_EXPIRATION}}' => $days_until_expiration,
                    '{{USER_PLAN_RENEW_LINK}}' => url('pay/' . $user->plan_id),
                    '{{NAME}}' => $user->name,
                    '{{PLAN_NAME}}' => $plans[$user->plan_id]->name,
                ],
                l('global.emails.user_plan_expiry_reminder.body', $user->language)
            );

            send_mail($user->email, $email_template->subject, $email_template->body, ['anti_phishing_code' => $user->anti_phishing_code, 'language' => $user->language]);

            /* Update user */
            db()->where('user_id', $user->user_id)->update('users', ['plan_expiry_reminder' => 1]);

            if(DEBUG) {
                echo sprintf('users_plan_expiry_reminder() -> Email sent for user_id %s', $user->user_id);
            }
        }

    }

    public function broadcasts() {

        $this->initiate();

        /* We'll send up to 40 emails per run */
        $max_batch_size = 40;

        /* Fetch a broadcast in "processing" status */
        $broadcast = db()->where('status', 'processing')->getOne('broadcasts');
        if(!$broadcast) {
            $this->close();
            return;
        }

        $broadcast->users_ids = json_decode($broadcast->users_ids ?? '[]', true);
        $broadcast->sent_users_ids = json_decode($broadcast->sent_users_ids ?? '[]', true);
        $broadcast->settings = json_decode($broadcast->settings ?? '[]');

        /* Find which users are left to process */
        $remaining_user_ids = array_values(array_diff($broadcast->users_ids, $broadcast->sent_users_ids));

        /* If no one is left, mark broadcast as "sent" and exit */
        if(empty($remaining_user_ids)) {

            $sent_emails_count = count($broadcast->sent_users_ids);

            db()->where('broadcast_id', $broadcast->broadcast_id)->update('broadcasts', [
                'sent_emails'              => $sent_emails_count,
                'sent_users_ids'           => json_encode($broadcast->sent_users_ids),
                'status'                   => 'sent',
                'last_sent_email_datetime' => get_date(),
            ]);

            $this->close();
            $this->update_cron_execution_datetimes('broadcasts_datetime');

            return;
        }

        /* Get all batch users at once in one go */
        $user_ids_for_this_run = array_slice($remaining_user_ids, 0, $max_batch_size);

        $users = db()
            ->where('user_id', $user_ids_for_this_run, 'IN')
            ->get('users', null, [
                'user_id',
                'name',
                'email',
                'language',
                'anti_phishing_code',
                'continent_code',
                'country',
                'city_name',
                'device_type',
                'os_name',
                'browser_name',
                'browser_language'
            ]);

        $users_ids = array_column($users, 'user_id');

        /* Non existing users in this batch */
        $missing_user_ids = array_diff($user_ids_for_this_run, $users_ids);

        /* Mark non existing users as processed (sent) */
        $broadcast->sent_users_ids = array_merge($broadcast->sent_users_ids, $missing_user_ids);

        /* Send emails only for existing users */
        if(!empty($users)) {

            /* Initialize PHPMailer once for this batch */
            $mail = new \PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->isHTML(true);

            /* SMTP connection settings */
            $mail->SMTPAuth = settings()->smtp->auth;
            $mail->Host = settings()->smtp->host;
            $mail->Port = settings()->smtp->port;
            $mail->Username = settings()->smtp->username;
            $mail->Password = settings()->smtp->password;

            if(settings()->smtp->encryption != '0') {
                $mail->SMTPSecure = settings()->smtp->encryption;
            }

            /* Keep the SMTP connection alive */
            $mail->SMTPKeepAlive = true;

            /* Set From / Reply-to */
            $mail->setFrom(settings()->smtp->from, settings()->smtp->from_name);
            if(!empty(settings()->smtp->reply_to) && !empty(settings()->smtp->reply_to_name)) {
                $mail->addReplyTo(settings()->smtp->reply_to, settings()->smtp->reply_to_name);
            } else {
                $mail->addReplyTo(settings()->smtp->from, settings()->smtp->from_name);
            }

            /* Optional CC/BCC */
            if(settings()->smtp->cc) {
                foreach (explode(',', settings()->smtp->cc) as $cc_email) {
                    $mail->addCC(trim($cc_email));
                }
            }
            if(settings()->smtp->bcc) {
                foreach (explode(',', settings()->smtp->bcc) as $bcc_email) {
                    $mail->addBCC(trim($bcc_email));
                }
            }

            /* Loop through users and send */
            foreach($users as $user) {

                /* Prepare placeholders and the final template */
                $vars = [
                    '{{USER:NAME}}'             => $user->name,
                    '{{USER:EMAIL}}'            => $user->email,
                    '{{USER:CONTINENT_NAME}}'   => get_continent_from_continent_code($user->continent_code),
                    '{{USER:COUNTRY_NAME}}'     => get_country_from_country_code($user->country),
                    '{{USER:CITY_NAME}}'        => $user->city_name,
                    '{{USER:DEVICE_TYPE}}'      => l('global.device.' . $user->device_type),
                    '{{USER:OS_NAME}}'          => $user->os_name,
                    '{{USER:BROWSER_NAME}}'     => $user->browser_name,
                    '{{USER:BROWSER_LANGUAGE}}' => get_language_from_locale($user->browser_language),
                ];

                $email_template = get_email_template(
                    $vars,
                    htmlspecialchars_decode($broadcast->subject),
                    $vars,
                    convert_editorjs_json_to_html($broadcast->content)
                );

                /* Optional: tracking pixel & link rewriting */
                if(settings()->main->broadcasts_statistics_is_enabled) {
                    $tracking_id = base64_encode('broadcast_id=' . $broadcast->broadcast_id . '&user_id=' . $user->user_id);
                    $email_template->body .= '<img src="' . SITE_URL . 'broadcast?id=' . $tracking_id . '" style="display: none;" />';
                    $email_template->body = preg_replace(
                        '/<a href=\"(.+)\"/',
                        '<a href="' . SITE_URL . 'broadcast?id=' . $tracking_id . '&url=$1"',
                        $email_template->body
                    );
                }

                /* Clear addresses from previous iteration */
                $mail->clearAddresses();
                $mail->clearCCs();
                $mail->clearBCCs();

                /* Add new email address */
                $mail->addAddress($user->email);

                /* Process the email title, template and body */
                extract(process_send_mail_template(
                    $email_template->subject,
                    $email_template->body,
                    [
                        'is_broadcast'       => true,
                        'is_system_email'    => $broadcast->settings->is_system_email,
                        'anti_phishing_code' => $user->anti_phishing_code,
                        'language'           => $user->language
                    ]
                ));

                /* Set subject/body, then send */
                $mail->Subject = $title;
                $mail->Body = $email_template;
                $mail->AltBody = strip_tags($mail->Body);

                /* SEND (count as sent even if it fails) */
                $mail->send();

                /* Track who we just processed (sent or attempted) */
                $broadcast->sent_users_ids[] = $user->user_id;

                Logger::users($user->user_id, 'broadcast.' . $broadcast->broadcast_id . '.sent');
            }

            /* Close this SMTP connection for the batch */
            $mail->smtpClose();
        }

        /* Total "sent" (processed) */
        $sent_emails_count = count($broadcast->sent_users_ids);

        /* Check if all users (existing or not) have been processed */
        $all_users_processed = empty(array_diff($broadcast->users_ids, $broadcast->sent_users_ids));

        /* Update broadcast once for the entire batch */
        db()->where('broadcast_id', $broadcast->broadcast_id)->update('broadcasts', [
            'sent_emails'              => $sent_emails_count,
            'sent_users_ids'           => json_encode($broadcast->sent_users_ids),
            'status'                   => $all_users_processed ? 'sent' : 'processing',
            'last_sent_email_datetime' => get_date(),
        ]);

        /* Debugging */
        if(DEBUG) {
            echo '<br />' . 'broadcasts() - broadcast_id - ' . $broadcast->broadcast_id;
        }

        $this->close();

        $this->update_cron_execution_datetimes('broadcasts_datetime');
    }

    public function push_notifications() {
        if(\Altum\Plugin::is_active('push-notifications')) {

            $this->initiate();

            require_once \Altum\Plugin::get('push-notifications')->path . 'controllers/Cron.php';

            $this->close();

            /* mark cron execution */
            $this->update_cron_execution_datetimes('push_notifications_datetime');
        }
    }

    public function campaigns() {
        $this->initiate();

        /* static config */
        $notifications_ttl  = require APP_PATH . 'includes/notifications_ttl.php';
        $max_per_run        = settings()->websites->campaigns_notifications_per_cron          ?? 500;
        $max_per_loop       = settings()->websites->campaigns_notifications_per_cron_loop     ?? 100;
        $max_per_flush      = settings()->websites->campaigns_notifications_per_cron_loop_sent ?? 25;

        $sent_counter_global = 0;

        /* keep looping campaigns until quota or queue exhausted */
        while (
            ($campaign = db()
                ->where('status', ['scheduled', 'processing'], 'IN')
                ->where('scheduled_datetime', get_date(), '<')
                ->orderBy('scheduled_datetime')
                ->getOne('campaigns'))
            && $sent_counter_global < $max_per_run
        ) {

            /* decode json fields once */
            $campaign->settings             = json_decode($campaign->settings             ?? '[]');
            $campaign->subscribers_ids      = json_decode($campaign->subscribers_ids      ?? '[]');
            $campaign->sent_subscribers_ids = json_decode($campaign->sent_subscribers_ids ?? '[]');

            /* figure out remaining targets */
            $pending_subscriber_ids = array_diff(
                $campaign->subscribers_ids,
                $campaign->sent_subscribers_ids
            );

            if(!count($pending_subscriber_ids)) {
                db()->where('campaign_id', $campaign->campaign_id)->update('campaigns', ['status' => 'sent']);
                continue;
            }

            /* clamp batch size to both run‑ and loop‑level limits */
            $batch_subscriber_ids = array_slice(
                $pending_subscriber_ids,
                0,
                min($max_per_loop, $max_per_run - $sent_counter_global)
            );

            /* bulk fetch subs */
            $subscribers_raw = db()->where('subscriber_id', $batch_subscriber_ids, 'IN')->get('subscribers');

            /* make sure subscribers result is actually existing and is not 0 */
            if(!count($subscribers_raw)) {
                db()->where('campaign_id', $campaign->campaign_id)->update('campaigns', ['status' => 'sent']);
                continue;
            }

            /* index by subscriber_id */
            $subscribers_map = [];
            foreach ($subscribers_raw as $row) {
                $row->custom_parameters = json_decode($row->custom_parameters ?? '', true);
                $subscribers_map[$row->subscriber_id] = $row;
            }
            unset($subscribers_raw);

            /* campaign setup */
            $website   = (new \Altum\Models\Website())->get_website_by_website_id($campaign->website_id);
            $web_push  = initiate_web_push($website->keys->public_key, $website->keys->private_key);
            $push_opts = [
                'TTL'     => $campaign->settings->ttl     ?? array_key_last($notifications_ttl),
                'urgency' => str_replace('_', '-', $campaign->settings->urgency ?? 'normal'),
            ];

            $base_content = [
                'title'        => html_entity_decode($campaign->title,        ENT_QUOTES, 'UTF-8'),
                'description'  => html_entity_decode($campaign->description,  ENT_QUOTES, 'UTF-8'),
                'url'          => process_utm_parameters($campaign->settings->utm, $campaign->url),
                'is_silent'    => $campaign->settings->is_silent,
                'is_auto_hide' => $campaign->settings->is_auto_hide,
            ];

            if($campaign->settings->button_title_1) {
                $base_content['button_title_1'] = $campaign->settings->button_title_1;
                $base_content['button_url_1']   = process_utm_parameters($campaign->settings->utm, $campaign->settings->button_url_1);
            }
            if($campaign->settings->button_title_2) {
                $base_content['button_title_2'] = $campaign->settings->button_title_2;
                $base_content['button_url_2']   = process_utm_parameters($campaign->settings->utm, $campaign->settings->button_url_2);
            }

            if($website->settings->icon) {
                $icon_url              = \Altum\Uploads::get_full_url('websites_icons') . $website->settings->icon;
                $base_content['icon']  = $icon_url;
                $base_content['badge'] = $icon_url;
            }

            if($campaign->image) {
                $base_content['image'] = \Altum\Uploads::get_full_url('websites_campaigns_images') . $campaign->image;
            }

            /* prepare queue */
            $queued_notifications    = [];   // endpoint => meta
            $subscribers_logs_batch  = [];   // accumulate logs for bulk insert
            $sent_this_campaign_loop = 0;

            foreach ($batch_subscriber_ids as $subscriber_id) {
                /* skip vanished record */
                if(!isset($subscribers_map[$subscriber_id])) {
                    continue;
                }

                $subscriber = $subscribers_map[$subscriber_id];

                /* mark to avoid future re‑processing */
                $campaign->sent_subscribers_ids[] = $subscriber_id;

                $content = $base_content;

                /* dynamic placeholders */
                $replacers = [
                    '{{CONTINENT_NAME}}'   => get_continent_from_continent_code($subscriber->continent_code),
                    '{{COUNTRY_NAME}}'     => get_country_from_country_code($subscriber->country_code),
                    '{{CITY_NAME}}'        => $subscriber->city_name,
                    '{{DEVICE_TYPE}}'      => l('global.device.' . $subscriber->device_type),
                    '{{OS_NAME}}'          => $subscriber->os_name,
                    '{{BROWSER_NAME}}'     => $subscriber->browser_name,
                    '{{BROWSER_LANGUAGE}}' => get_language_from_locale($subscriber->browser_language),
                ];
                foreach ($subscriber->custom_parameters as $k => $v) {
                    $replacers['{{CUSTOM_PARAMETERS:' . $k . '}}'] = $v;
                }

                foreach (['title', 'description', 'url', 'button_title_1', 'button_url_1', 'button_title_2', 'button_url_2'] as $field) {
                    if(!empty($content[$field])) {
                        $content[$field] = process_spintax(
                            str_replace(array_keys($replacers), array_values($replacers), $content[$field])
                        );
                    }
                }

                /* extra payload fields */
                $content['subscriber_id'] = $subscriber_id;
                $content['pixel_key']     = $website->pixel_key;
                $content['source_type']   = 'campaign_id';
                $content['campaign_id']   = $campaign->campaign_id;
                if($campaign->rss_automation_id)     $content['rss_automation_id']     = $campaign->rss_automation_id;
                if($campaign->recurring_campaign_id) $content['recurring_campaign_id'] = $campaign->recurring_campaign_id;

                $subscriber_push = [
                    'endpoint'       => $subscriber->endpoint,
                    'expirationTime' => null,
                    'keys'           => json_decode($subscriber->keys, true),
                ];

                /* queue */
                $web_push->queueNotification(
                    \Minishlink\WebPush\Subscription::create($subscriber_push),
                    json_encode($content),
                    $push_opts
                );

                $queued_notifications[$subscriber->endpoint] = [
                    'subscriber_id'         => $subscriber_id,
                    'campaign_id'           => $campaign->campaign_id,
                    'rss_automation_id'     => $campaign->rss_automation_id,
                    'recurring_campaign_id' => $campaign->recurring_campaign_id,
                    'subscriber_ip'         => $subscriber->ip,
                    'website_id'            => $subscriber->website_id,
                    'user_id'               => $website->user_id,
                ];

                $sent_this_campaign_loop++;
                $sent_counter_global++;

                if($sent_counter_global >= $max_per_run) {
                    break;
                }
            }

            /* send via flush_pooled() and process the results */
            $web_push->flushPooled(
                function (\Minishlink\WebPush\MessageSentReport $report) use (
                    &$queued_notifications,
                    &$subscribers_logs_batch
                ) {
                    $endpoint = $report->getRequest()->getUri()->__toString();
                    $meta     = $queued_notifications[$endpoint] ?? null;
                    if(!$meta) {
                        return;
                    }

                    $status     = $report->getResponse()?->getStatusCode();
                    $now        = get_date();
                    $log_record = [
                        'subscriber_id'          => $meta['subscriber_id'],
                        'campaign_id'            => $meta['campaign_id'],
                        'rss_automation_id'      => $meta['rss_automation_id'],
                        'recurring_campaign_id'  => $meta['recurring_campaign_id'],
                        'website_id'             => $meta['website_id'],
                        'user_id'                => $meta['user_id'],
                        'ip'                     => $meta['subscriber_ip'],
                        'datetime'               => $now,
                    ];

                    /* 200/201/202 = success */
                    if(in_array($status, [200, 201, 202], true)) {
                        db()->where('subscriber_id', $meta['subscriber_id'])->update('subscribers', [
                            'total_sent_push_notifications' => db()->inc(),
                            'last_sent_datetime'            => $now,
                        ]);

                        $log_record['type'] = 'push_notification_sent';
                    }

                    /* 410 – gone */
                    elseif($status === 410) {
                        db()->where('subscriber_id', $meta['subscriber_id'])->delete('subscribers');
                        if(db()->count) {
                            db()->where('website_id', $meta['website_id'])->update('websites', [
                                'total_subscribers' => db()->dec(),
                            ]);
                            cache()->deleteItem('subscribers_total?user_id=' . $meta['user_id']);
                            cache()->deleteItem('subscribers_dashboard?user_id=' . $meta['user_id']);
                        }

                        $log_record['subscriber_id'] = null;
                        $log_record['ip']            = preg_replace('/\d/', '*', $meta['subscriber_ip']);
                        $log_record['type']          = 'expired_deleted';
                    }

                    /* anything else incl. null */
                    else {
                        $log_record['type'] = 'push_notification_failed';
                    }

                    /* buffer for bulk insert after the pool is done */
                    $subscribers_logs_batch[] = $log_record;
                },
                $max_per_loop,
                $max_per_flush
            );

            /* bulk insert all the logs */
            if($subscribers_logs_batch) {
                db()->insertMulti('subscribers_logs', $subscribers_logs_batch);
            }

            /* update campaigns & stats */
            db()->where('campaign_id', $campaign->campaign_id)->update('campaigns', [
                'total_sent_push_notifications' => count($campaign->sent_subscribers_ids),
                'sent_subscribers_ids'          => json_encode($campaign->sent_subscribers_ids),
                'status'                        => count($pending_subscriber_ids) <= $sent_this_campaign_loop ? 'sent' : 'processing',
                'last_sent_datetime'            => get_date(),
            ]);

            if($campaign->rss_automation_id) {
                db()->where('rss_automation_id', $campaign->rss_automation_id)
                    ->update('rss_automations', ['total_sent_push_notifications' => db()->inc($sent_this_campaign_loop)]);
            }
            if($campaign->recurring_campaign_id) {
                db()->where('recurring_campaign_id', $campaign->recurring_campaign_id)
                    ->update('recurring_campaigns', ['total_sent_push_notifications' => db()->inc($sent_this_campaign_loop)]);
            }

            db()->where('website_id', $campaign->website_id)->update('websites', [
                'total_sent_push_notifications' => db()->inc($sent_this_campaign_loop),
            ]);
            db()->where('user_id', $campaign->user_id)->update('users', [
                'pusher_sent_push_notifications_current_month' => db()->inc($sent_this_campaign_loop),
                'pusher_total_sent_push_notifications' => db()->inc($sent_this_campaign_loop),
            ]);

            cache()->deleteItem('total_sent_push_notifications_total?user_id=' . $campaign->user_id);
            cache()->deleteItem('campaigns_dashboard?user_id=' . $campaign->user_id);
        }

        $this->close();

        /* mark cron execution */
        $this->update_cron_execution_datetimes('campaigns_datetime');
    }

    public function flows() {
        $this->initiate();

        $i = 1;
        while(
            ($flow_notification = db()->where('scheduled_datetime', get_date(), '<')->getOne('flow_notifications'))
            && $i <= (settings()->websites->flows_notifications_per_cron ?? 100)
        ) {
            /* Get the flow */
            $flow = (new \Altum\Models\Flow())->get_flow_by_flow_id($flow_notification->flow_id);

            /* Get the website */
            $website = (new \Altum\Models\Website())->get_website_by_website_id($flow_notification->website_id);

            /* Go through the subscriber that need to be processed */
            $subscriber = db()->where('subscriber_id', $flow_notification->subscriber_id)->getOne('subscribers');
            $subscriber->custom_parameters = json_decode($subscriber->custom_parameters);

            /* Process UTM parameters */
            $flow->url = process_utm_parameters($flow->settings->utm, $flow->url);
            $flow->settings->button_url_1 = process_utm_parameters($flow->settings->utm, $flow->settings->button_url_1);
            $flow->settings->button_url_2 = process_utm_parameters($flow->settings->utm, $flow->settings->button_url_2);

            /* Send web push */
            process_push_notification([
                'website' => $website,
                'subscriber' => $subscriber,

                'source_id' => 'flow_id',
                'source_value' => $flow->flow_id,

                'web_push_data' => [
                    'title' => $flow->title,
                    'description' => $flow->description,
                    'url' => $flow->url,
                    'is_silent' => $flow->settings->is_silent,
                    'is_auto_hide' => $flow->settings->is_auto_hide,
                    'button_title_1' => $flow->settings->button_title_1,
                    'button_url_1' => $flow->settings->button_url_1,
                    'button_title_2' => $flow->settings->button_title_2,
                    'button_url_2' => $flow->settings->button_url_2,
                    'image' => $flow->image ? \Altum\Uploads::get_full_url('websites_flows_images') . $flow->image : null,
                    'ttl' => $flow->settings->ttl,
                    'urgency' => $flow->settings->urgency,
                    'content' => [
                        'source_type' => 'flow_id',
                        'flow_id' => $flow->flow_id,
                    ]
                ]
            ], function() use ($flow, $flow_notification) {

                /* Update the push notifications flow */
                db()->where('flow_id', $flow->flow_id)->update('flows', [
                    'total_sent_push_notifications' => db()->inc(),
                    'last_sent_datetime' => get_date(),
                ]);

                /* Delete the flow notification */
                db()->where('flow_notification_id', $flow_notification->flow_notification_id)->delete('flow_notifications');

            });

            /* Make sure it does not hit the limits imposed */
            $i++;
            if($i >= (settings()->sms->flows_per_cron ?? 100)) {
                break;
            }
        }

        $this->close();

        /* mark cron execution */
        $this->update_cron_execution_datetimes('flows_datetime');
    }

    public function personal_notifications() {
        $this->initiate();

        $i = 1;
        while(
            ($personal_notification = db()->where('status', ['scheduled', 'processing'], 'IN')->where('scheduled_datetime', get_date(), '<')->getOne('personal_notifications'))
            && $i <= (settings()->websites->personal_notifications_per_cron ?? 100)
        ) {
            $personal_notification->settings = json_decode($personal_notification->settings);

            /* Get the website */
            $website = (new \Altum\Models\Website())->get_website_by_website_id($personal_notification->website_id);

            /* Go through the subscriber that need to be processed */
            $subscriber = db()->where('subscriber_id', $personal_notification->subscriber_id)->getOne('subscribers');

            /* Process UTM parameters */
            $personal_notification->url = process_utm_parameters($personal_notification->settings->utm, $personal_notification->url);
            $personal_notification->settings->button_url_1 = process_utm_parameters($personal_notification->settings->utm, $personal_notification->settings->button_url_1);
            $personal_notification->settings->button_url_2 = process_utm_parameters($personal_notification->settings->utm, $personal_notification->settings->button_url_2);

            /* Send web push */
            process_push_notification([
                'website' => $website,
                'subscriber' => $subscriber,

                'source_id' => 'personal_notification_id',
                'source_value' => $personal_notification->personal_notification_id,

                'web_push_data' => [
                    'title' => $personal_notification->title,
                    'description' => $personal_notification->description,
                    'url' => $personal_notification->url,
                    'is_silent' => $personal_notification->settings->is_silent,
                    'is_auto_hide' => $personal_notification->settings->is_auto_hide,
                    'button_title_1' => $personal_notification->settings->button_title_1,
                    'button_url_1' => $personal_notification->settings->button_url_1,
                    'button_title_2' => $personal_notification->settings->button_title_2,
                    'button_url_2' => $personal_notification->settings->button_url_2,
                    'image' => $personal_notification->image ? \Altum\Uploads::get_full_url('websites_personal_notifications_images') . $personal_notification->image : null,
                    'ttl' => $personal_notification->settings->ttl,
                    'urgency' => $personal_notification->settings->urgency,
                    'content' => [
                        'source_type' => 'personal_notification_id',
                        'personal_notification_id' => $personal_notification->personal_notification_id,
                    ]
                ]
            ], function() use ($personal_notification) {
                /* Update the personal notification */
                db()->where('personal_notification_id', $personal_notification->personal_notification_id)->update('personal_notifications', [
                    'is_sent' => 1,
                    'status' => 'sent',
                    'sent_datetime' => get_date(),
                ]);
            });

            /* Make sure it does not hit the limits imposed */
            $i++;
            if($i >= 100) {
                break;
            }
        }

        $this->close();

        /* mark cron execution */
        $this->update_cron_execution_datetimes('personal_notifications_datetime');
    }

    public function rss_automations() {
        $this->initiate();

        $i = 1;
        while(
            ($rss_automation = db()->where('is_enabled', 1)->where('next_check_datetime', get_date(), '<')->getOne('rss_automations'))
            && $i <= (settings()->websites->rss_automations_per_cron ?? 10)
        ) {
            $i++;

            $rss_automation->settings = json_decode($rss_automation->settings ?? '');
            $rss_automation->rss_last_entries = json_decode($rss_automation->rss_last_entries ?? '[]');

            /* Calculate expected next run */
            $next_check_datetime = (new \DateTime())->modify('+' . $rss_automation->settings->check_interval_seconds . ' seconds')->format('Y-m-d H:i:s');

            /* Process the RSS feed */
            $rss = rss_feed_parse_url($rss_automation->rss_url);

            if(!$rss) {
                /* Wait and try again */
                sleep(3);

                $rss = rss_feed_parse_url($rss_automation->rss_url);
            }

            /* Disable the RSS automation on feed fail 2x times */
            if(!$rss) {
                db()->where('rss_automation_id', $rss_automation->rss_automation_id)->update('rss_automations', [
                    'is_enabled' => 0,
                    'next_check_datetime' => null,
                    'last_check_datetime' => get_date(),
                ]);

                continue;
            }

            /* Only use the last needed items */
            $rss = array_slice($rss, 0, $rss_automation->settings->items_count);

            /* Filter out already processed entries */
            $new_rss = [];
            foreach($rss as $entry) {
                if(!in_array($entry[$rss_automation->settings->unique_item_identifier ?? 'url'], $rss_automation->rss_last_entries ?? [])) {
                    $new_rss[] = $entry;
                }
            }

            /* Skip if no entry that needs to be processed */
            if(!count($new_rss)) {
                db()->where('rss_automation_id', $rss_automation->rss_automation_id)->update('rss_automations', [
                    'next_check_datetime' => $next_check_datetime,
                    'last_check_datetime' => get_date(),
                ]);

                continue;
            }

            $rss = $new_rss;

            /* Segment */
            if(is_numeric($rss_automation->segment)) {
                $segment = (new \Altum\Models\Segment())->get_segment_by_segment_id($rss_automation->segment);
                if(!$segment) {
                    $rss_automation->segment = 'all';
                }
            }

            if($rss_automation->segment == 'all') {
                $subscribers = db()->where('website_id', $rss_automation->website_id)->get('subscribers', null, ['subscriber_id', 'user_id']);
            } else {
                switch($segment->type) {
                    case 'custom':
                        if(empty($segment->settings->subscribers_ids)) {
                            $subscribers = [];
                        } else {
                            $subscribers = db()->where('website_id', $rss_automation->website_id)->where('subscriber_id', $segment->settings->subscribers_ids, 'IN')->get('subscribers', null, ['subscriber_id']);
                        }
                        break;

                    case 'filter':
                        $query = db()->where('website_id', $rss_automation->website_id);
                        $has_filters = false;

                        if(isset($segment->settings->filters_subscribed_on_url)) $_POST['filters_subscribed_on_url'] = $segment->settings->filters_subscribed_on_url ?? '';
                        if(isset($segment->settings->filters_cities)) $_POST['filters_cities'] = $segment->settings->filters_cities ?? [];
                        if(isset($segment->settings->filters_countries)) $_POST['filters_countries'] = $segment->settings->filters_countries ?? [];
                        if(isset($segment->settings->filters_continents)) $_POST['filters_continents'] = $segment->settings->filters_continents ?? [];
                        if(isset($segment->settings->filters_device_type)) $_POST['filters_device_type'] = $segment->settings->filters_device_type ?? [];
                        if(isset($segment->settings->filters_languages)) $_POST['filters_languages'] = $segment->settings->filters_languages ?? [];
                        if(isset($segment->settings->filters_operating_systems)) $_POST['filters_operating_systems'] = $segment->settings->filters_operating_systems ?? [];
                        if(isset($segment->settings->filters_browsers)) $_POST['filters_browsers'] = $segment->settings->filters_browsers ?? [];
                        if(isset($segment->settings->filters_custom_parameters) && count($segment->settings->filters_custom_parameters)) {
                            foreach($segment->settings->filters_custom_parameters as $key => $custom_parameter) {
                                $_POST['filters_custom_parameter_key'][$key] = $custom_parameter->key;
                                $_POST['filters_custom_parameter_condition'][$key] = $custom_parameter->condition;
                                $_POST['filters_custom_parameter_value'][$key] = $custom_parameter->value;
                            }
                        }

                        /* Custom parameters initialization */
                        $_POST['filters_custom_parameter_key'] = $_POST['filters_custom_parameter_key'] ?? [];
                        $_POST['filters_custom_parameter_condition'] = $_POST['filters_custom_parameter_condition'] ?? [];
                        $_POST['filters_custom_parameter_value'] = $_POST['filters_custom_parameter_value'] ?? [];

                        $custom_parameters = [];
                        foreach($_POST['filters_custom_parameter_key'] as $key => $value) {
                            $custom_parameters[] = [
                                'key' => $value,
                                'condition' => $_POST['filters_custom_parameter_condition'][$key],
                                'value' => $_POST['filters_custom_parameter_value'][$key],
                            ];
                        }

                        if(count($custom_parameters)) {
                            $has_filters = true;

                            foreach($custom_parameters as $custom_parameter) {
                                $key = $custom_parameter['key'];
                                $condition = $custom_parameter['condition'];
                                $value = $custom_parameter['value'];

                                /* reference JSON value once; unquote JSON for string ops, cast for numeric ops */
                                $json_value_expression = 'JSON_UNQUOTE(JSON_EXTRACT(`custom_parameters`, \'$."'.$key.'"\'))';
                                $numeric_expression = 'CAST('.$json_value_expression.' AS DECIMAL(65,10))';

                                switch($condition) {
                                    case 'exact':
                                        $query->where($json_value_expression.' = \''.$value.'\'');
                                        break;

                                    case 'not_exact':
                                        $query->where($json_value_expression.' != \''.$value.'\'');
                                        break;

                                    case 'contains':
                                        $query->where($json_value_expression.' LIKE \'%'.$value.'%\'');
                                        break;

                                    case 'not_contains':
                                        $query->where($json_value_expression.' NOT LIKE \'%'.$value.'%\'');
                                        break;

                                    case 'starts_with':
                                        $query->where($json_value_expression.' LIKE \''.$value.'%\'');
                                        break;

                                    case 'not_starts_with':
                                        $query->where($json_value_expression.' NOT LIKE \''.$value.'%\'');
                                        break;

                                    case 'ends_with':
                                        $query->where($json_value_expression.' LIKE \'%'.$value.'\'');
                                        break;

                                    case 'not_ends_with':
                                        $query->where($json_value_expression.' NOT LIKE \'%'.$value.'\'');
                                        break;

                                    case 'bigger_than':
                                        $query->where($numeric_expression.' > '.(is_numeric($value) ? $value : '0'));
                                        break;

                                    case 'lower_than':
                                        $query->where($numeric_expression.' < '.(is_numeric($value) ? $value : '0'));
                                        break;
                                }
                            }
                        }

                        if(!empty($_POST['filters_subscribed_on_url'])) {
                            $has_filters = true;
                            $query->where('subscribed_on_url', $_POST['filters_subscribed_on_url']);
                        }

                        if(!empty($_POST['filters_cities'])) {
                            $has_filters = true;
                            $query->where('city_name', $_POST['filters_cities'], 'IN');
                        }

                        if(isset($_POST['filters_countries'])) {
                            $has_filters = true;
                            $query->where('country_code', $_POST['filters_countries'], 'IN');
                        }

                        if(isset($_POST['filters_continents'])) {
                            $has_filters = true;
                            $query->where('continent_code', $_POST['filters_continents'], 'IN');
                        }

                        if(isset($_POST['filters_device_type'])) {
                            $has_filters = true;
                            $query->where('device_type', $_POST['filters_device_type'], 'IN');
                        }

                        if(isset($_POST['filters_languages'])) {
                            $has_filters = true;
                            $query->where('browser_language', $_POST['filters_languages'], 'IN');
                        }

                        if(isset($_POST['filters_operating_systems'])) {
                            $has_filters = true;
                            $query->where('os_name', $_POST['filters_operating_systems'], 'IN');
                        }

                        if(isset($_POST['filters_browsers'])) {
                            $has_filters = true;
                            $query->where('browser_name', $_POST['filters_browsers'], 'IN');
                        }

                        $subscribers = $has_filters ? $query->get('subscribers', null, ['subscriber_id']) : [];

                        db()->reset();
                        break;
                }
            }

            $subscribers_ids = array_column($subscribers, 'subscriber_id');

            /* Free memory */
            unset($subscribers);

            $user = db()->where('user_id', $rss_automation->user_id)->getOne('users', ['user_id', 'plan_settings', 'pusher_campaigns_current_month', 'pusher_sent_push_notifications_current_month', 'timezone']);
            $user->plan_settings = json_decode($user->plan_settings ?? '');

            $available_campaigns = $user->plan_settings->campaigns_per_month_limit == -1 ? 9999999 : $user->plan_settings->campaigns_per_month_limit - $user->pusher_campaigns_current_month;
            $available_push_notifications = $user->plan_settings->sent_push_notifications_per_month_limit == -1 ? 9999999 : $user->plan_settings->sent_push_notifications_per_month_limit - $user->pusher_sent_push_notifications_current_month;

            $created_campaigns = 0;
            $processed_rss_entries = [];

            foreach($rss as $entry) {
                if($available_campaigns <= 0 || $available_push_notifications <= count($subscribers_ids)) break;

                $name = $rss_automation->name . ' - ' . string_truncate($entry['title'], 50);
                $status = 'scheduled';

                $title = $rss_automation->title;
                $description = $rss_automation->description;
                $url = $rss_automation->url;

                $replacers = [
                    '{{RSS_TITLE}}' => $entry['title'],
                    '{{RSS_DESCRIPTION}}' => $entry['description'],
                    '{{RSS_URL}}' => $entry['url'],
                ];

                /* Main */
                foreach(['title', 'description', 'url', 'button_title_1'] as $key) {
                    if(!empty($$key)) {
                        $$key = str_replace(
                            array_keys($replacers),
                            array_values($replacers),
                            $$key
                        );
                    }
                }

                /* Clean them up */
                $title = string_truncate(input_clean($title), 62);
                $description = string_truncate(input_clean($description), 126);
                $url = string_truncate(input_clean($url), 62);

                /* Buttons */
                foreach(['button_title_1', 'button_url_1', 'button_title_2', 'button_url_2'] as $key) {
                    if(!empty($rss_automation->settings->{$key})) {
                        $rss_automation->settings->{$key} = str_replace(
                            array_keys($replacers),
                            array_values($replacers),
                            $rss_automation->settings->{$key}
                        );
                    }
                }

                /* Clean them up */
                $rss_automation->settings->button_title_1 = string_truncate(input_clean($rss_automation->settings->button_title_1), 14);
                $rss_automation->settings->button_url_1 = get_url($rss_automation->settings->button_url_1, 512);
                $rss_automation->settings->button_title_2 = string_truncate(input_clean($rss_automation->settings->button_title_2), 14);
                $rss_automation->settings->button_url_2 = get_url($rss_automation->settings->button_url_2, 512);

                /* Image */
                $image = null;

                if($rss_automation->settings->use_rss_image && $entry['image']) {
                    $save_file_name = md5(uniqid('', true) . random_bytes(16));
                    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp', 'image/gif'];
                    $image = \Altum\Uploads::download_image_from_url($entry['image'], 'websites_campaigns_images', $save_file_name, $allowed_mime_types);
                }

                if(!$image) {
                    $image = \Altum\Uploads::copy_uploaded_file($rss_automation->image, \Altum\Uploads::get_path('websites_rss_automations_images'), \Altum\Uploads::get_path('websites_campaigns_images'));
                }

                $campaigns_delay = $created_campaigns == 0 ? 0 : $created_campaigns * $rss_automation->settings->campaigns_delay;
                $scheduled_datetime = (new \DateTime())->modify('+' . $campaigns_delay . ' minutes')->format('Y-m-d H:i:s');

                $settings = [
                    'is_scheduled' => 1,
                    'ttl' => $rss_automation->settings->ttl,
                    'urgency' => $rss_automation->settings->urgency,
                    'is_silent' => $rss_automation->settings->is_silent,
                    'is_auto_hide' => $rss_automation->settings->is_auto_hide,
                    'button_title_1' => $rss_automation->settings->button_title_1,
                    'button_url_1' => $rss_automation->settings->button_url_1,
                    'button_title_2' => $rss_automation->settings->button_title_2,
                    'button_url_2' => $rss_automation->settings->button_url_2,
                    'utm' => [
                        'source' => $rss_automation->settings->utm->source,
                        'medium' => $rss_automation->settings->utm->medium,
                        'campaign' => $rss_automation->settings->utm->campaign,
                    ]
                ];

                $campaign_id = db()->insert('campaigns', [
                    'website_id' => $rss_automation->website_id,
                    'user_id' => $user->user_id,
                    'rss_automation_id' => $rss_automation->rss_automation_id,
                    'name' => $name,
                    'title' => $title,
                    'description' => $description,
                    'url' => $url,
                    'image' => $image,
                    'segment' => $rss_automation->segment,
                    'settings' => json_encode($settings),
                    'subscribers_ids' => json_encode($subscribers_ids),
                    'sent_subscribers_ids' => '[]',
                    'total_push_notifications' => count($subscribers_ids),
                    'status' => $status,
                    'scheduled_datetime' => $scheduled_datetime,
                    'datetime' => get_date(),
                ]);

                $available_campaigns--;
                $created_campaigns++;
                $available_push_notifications -= count($subscribers_ids);

                $processed_rss_entries[] = $entry[$rss_automation->settings->unique_item_identifier ?? 'url'];
            }

            /* Merge new processed entries into the saved history and cap size */
            $merged_rss_last_entries = array_unique(array_merge($processed_rss_entries, $rss_automation->rss_last_entries ?? []));
            $merged_rss_last_entries = array_slice($merged_rss_last_entries, 0, 100);

            db()->where('rss_automation_id', $rss_automation->rss_automation_id)->update('rss_automations', [
                'total_campaigns' => db()->inc($created_campaigns),
                'rss_last_entries' => json_encode($merged_rss_last_entries),
                'next_check_datetime' => $next_check_datetime,
                'last_check_datetime' => get_date(),
            ]);

            db()->where('user_id', $user->user_id)->update('users', [
                'pusher_campaigns_current_month' => db()->inc($created_campaigns)
            ]);
        }

        $this->close();

        /* mark cron execution */
        $this->update_cron_execution_datetimes('rss_automations_datetime');
    }

    public function recurring_campaigns() {
        $this->initiate();

        $i = 1;
        while(
            ($recurring_campaign = db()->where('is_enabled', 1)->where('next_run_datetime', get_date(), '<')->getOne('recurring_campaigns'))
            && $i <= (settings()->websites->recurring_campaigns_per_cron ?? 10)
        ) {
            $i++;

            $recurring_campaign->settings = json_decode($recurring_campaign->settings ?? '');

            /* Segment */
            if(is_numeric($recurring_campaign->segment)) {
                /* Get settings from custom segments */
                $segment = (new \Altum\Models\Segment())->get_segment_by_segment_id($recurring_campaign->segment);

                if(!$segment) {
                    $recurring_campaign->segment = 'all';
                }
            }

            if($recurring_campaign->segment == 'all') {
                $subscribers = db()->where('website_id', $recurring_campaign->website_id)->get('subscribers', null, ['subscriber_id', 'user_id']);
            }

            else {
                switch($segment->type) {
                    case 'custom':

                        if(empty($segment->settings->subscribers_ids)) {
                            $subscribers = [];
                        } else {
                            $subscribers = db()->where('website_id', $recurring_campaign->website_id)->where('subscriber_id', $segment->settings->subscribers_ids, 'IN')->get('subscribers', null, ['subscriber_id']);
                        }

                        break;

                    case 'filter':

                        if(isset($segment->settings->filters_subscribed_on_url)) $_POST['filters_subscribed_on_url'] = $segment->settings->filters_subscribed_on_url ?? '';
                        if(isset($segment->settings->filters_cities)) $_POST['filters_cities'] = $segment->settings->filters_cities ?? [];
                        if(isset($segment->settings->filters_countries)) $_POST['filters_countries'] = $segment->settings->filters_countries ?? [];
                        if(isset($segment->settings->filters_continents)) $_POST['filters_continents'] = $segment->settings->filters_continents ?? [];
                        if(isset($segment->settings->filters_device_type)) $_POST['filters_device_type'] = $segment->settings->filters_device_type ?? [];
                        if(isset($segment->settings->filters_languages)) $_POST['filters_languages'] = $segment->settings->filters_languages ?? [];
                        if(isset($segment->settings->filters_operating_systems)) $_POST['filters_operating_systems'] = $segment->settings->filters_operating_systems ?? [];
                        if(isset($segment->settings->filters_browsers)) $_POST['filters_browsers'] = $segment->settings->filters_browsers ?? [];
                        if(isset($segment->settings->filters_custom_parameters) && count($segment->settings->filters_custom_parameters)) {
                            foreach($segment->settings->filters_custom_parameters as $key => $custom_parameter) {
                                $_POST['filters_custom_parameter_key'][$key] = $custom_parameter->key;
                                $_POST['filters_custom_parameter_condition'][$key] = $custom_parameter->condition;
                                $_POST['filters_custom_parameter_value'][$key] = $custom_parameter->value;
                            }
                        }

                        $query = db()->where('website_id', $recurring_campaign->website_id);

                        $has_filters = false;

                        /* Custom parameters */
                        if(!isset($_POST['filters_custom_parameter_key'])) {
                            $_POST['filters_custom_parameter_key'] = [];
                            $_POST['filters_custom_parameter_condition'] = [];
                            $_POST['filters_custom_parameter_value'] = [];
                        }

                        $custom_parameters = [];

                        foreach($_POST['filters_custom_parameter_key'] as $key => $value) {
                            $custom_parameters[] = [
                                'key' => $value,
                                'condition' => $_POST['filters_custom_parameter_condition'][$key],
                                'value' => $_POST['filters_custom_parameter_value'][$key]
                            ];
                        }

                        if(count($custom_parameters)) {
                            $has_filters = true;

                            foreach($custom_parameters as $custom_parameter) {
                                $key = $custom_parameter['key'];
                                $condition = $custom_parameter['condition'];
                                $value = $custom_parameter['value'];

                                /* reference JSON value once; unquote JSON for string ops, cast for numeric ops */
                                $json_value_expression = 'JSON_UNQUOTE(JSON_EXTRACT(`custom_parameters`, \'$."'.$key.'"\'))';
                                $numeric_expression = 'CAST('.$json_value_expression.' AS DECIMAL(65,10))';

                                switch($condition) {
                                    case 'exact':
                                        $query->where($json_value_expression.' = \''.$value.'\'');
                                        break;

                                    case 'not_exact':
                                        $query->where($json_value_expression.' != \''.$value.'\'');
                                        break;

                                    case 'contains':
                                        $query->where($json_value_expression.' LIKE \'%'.$value.'%\'');
                                        break;

                                    case 'not_contains':
                                        $query->where($json_value_expression.' NOT LIKE \'%'.$value.'%\'');
                                        break;

                                    case 'starts_with':
                                        $query->where($json_value_expression.' LIKE \''.$value.'%\'');
                                        break;

                                    case 'not_starts_with':
                                        $query->where($json_value_expression.' NOT LIKE \''.$value.'%\'');
                                        break;

                                    case 'ends_with':
                                        $query->where($json_value_expression.' LIKE \'%'.$value.'\'');
                                        break;

                                    case 'not_ends_with':
                                        $query->where($json_value_expression.' NOT LIKE \'%'.$value.'\'');
                                        break;

                                    case 'bigger_than':
                                        $query->where($numeric_expression.' > '.(is_numeric($value) ? $value : '0'));
                                        break;

                                    case 'lower_than':
                                        $query->where($numeric_expression.' < '.(is_numeric($value) ? $value : '0'));
                                        break;
                                }
                            }
                        }

                        /* Subscribed on URL */
                        if(!empty($_POST['filters_subscribed_on_url'])) {
                            $has_filters = true;
                            $query->where('subscribed_on_url', $_POST['filters_subscribed_on_url']);
                        }

                        /* Cities */
                        if(!empty($_POST['filters_cities'])) {
                            $has_filters = true;
                            $query->where('city_name', $_POST['filters_cities'], 'IN');
                        }

                        /* Countries */
                        if(isset($_POST['filters_countries'])) {
                            $has_filters = true;
                            $query->where('country_code', $_POST['filters_countries'], 'IN');
                        }

                        /* Continents */
                        if(isset($_POST['filters_continents'])) {
                            $has_filters = true;
                            $query->where('continent_code', $_POST['filters_continents'], 'IN');
                        }

                        /* Device type */
                        if(isset($_POST['filters_device_type'])) {
                            $has_filters = true;
                            $query->where('device_type', $_POST['filters_device_type'], 'IN');
                        }

                        /* Languages */
                        if(isset($_POST['filters_languages'])) {
                            $has_filters = true;
                            $query->where('browser_language', $_POST['filters_languages'], 'IN');
                        }

                        /* Filters operating systems */
                        if(isset($_POST['filters_operating_systems'])) {
                            $has_filters = true;
                            $query->where('os_name', $_POST['filters_operating_systems'], 'IN');
                        }

                        /* Filters browsers */
                        if(isset($_POST['filters_browsers'])) {
                            $has_filters = true;
                            $query->where('browser_name', $_POST['filters_browsers'], 'IN');
                        }

                        $subscribers = $has_filters ? $query->get('subscribers', null, ['subscriber_id']) : [];

                        db()->reset();

                        break;
                }
            }

            $subscribers_ids = array_column($subscribers, 'subscriber_id');

            /* Free memory */
            unset($subscribers);

            /* Get user limits */
            $user = db()->where('user_id', $recurring_campaign->user_id)->getOne('users', ['user_id', 'plan_settings', 'pusher_campaigns_current_month', 'pusher_sent_push_notifications_current_month', 'timezone']);
            $user->plan_settings = json_decode($user->plan_settings ?? '');

            /* Campaigns usage tracking */
            $available_campaigns = $user->plan_settings->campaigns_per_month_limit == -1 ? 9999999 : $user->plan_settings->campaigns_per_month_limit - $user->pusher_campaigns_current_month;

            /* Sent notifications tracking */
            $available_push_notifications = $user->plan_settings->sent_push_notifications_per_month_limit == -1 ? 9999999 : $user->plan_settings->sent_push_notifications_per_month_limit - $user->pusher_sent_push_notifications_current_month;

            /* Disable the recurring campaign */
            if($available_campaigns <= 0 || $available_push_notifications <= count($subscribers_ids)) {
                db()->where('recurring_campaign_id', $recurring_campaign->recurring_campaign_id)->update('recurring_campaigns', [
                    'is_enabled' => 0,
                    'next_run_datetime' => null,
                    'last_run_datetime' => get_date(),
                ]);
                continue;
            };

            /* Scheduled datetime */
            $scheduled_datetime = (new \DateTime($recurring_campaign->next_run_datetime))->modify('+15 minutes');

            /* Make sure it skips this run if too much time has passed */
            $current_datetime = new \DateTime();

            $interval = $current_datetime->diff($scheduled_datetime);

            /* Generate another run time */
            if($interval->days >= 1) {
                $next_run_datetime = get_next_run_datetime($recurring_campaign->settings->frequency, $recurring_campaign->settings->time, $recurring_campaign->settings->week_days, $recurring_campaign->settings->month_days, $user->timezone, '-15 minutes');

                db()->where('recurring_campaign_id', $recurring_campaign->recurring_campaign_id)->update('recurring_campaigns', [
                    'next_run_datetime' => $next_run_datetime,
                ]);

                continue;
            }

            $scheduled_datetime = get_next_run_datetime($recurring_campaign->settings->frequency, $recurring_campaign->settings->time, $recurring_campaign->settings->week_days, $recurring_campaign->settings->month_days, $user->timezone);

            /* Prepare the campaign */
            $name = $recurring_campaign->name . ' - #' . nr($recurring_campaign->total_campaigns + 1);
            $status = 'scheduled';

            /* Title, description, url */
            $title = $recurring_campaign->title;
            $description = $recurring_campaign->description;
            $url = $recurring_campaign->url;

            /* Duplicate the image to the campaign side */
            $image = \Altum\Uploads::copy_uploaded_file($recurring_campaign->image, \Altum\Uploads::get_path('websites_recurring_campaigns_images'), \Altum\Uploads::get_path('websites_campaigns_images'));

            /* Settings */
            $settings = [
                /* Scheduling */
                'is_scheduled' => 1,

                /* Advanced */
                'ttl' => $recurring_campaign->settings->ttl,
                'urgency' => $recurring_campaign->settings->urgency,
                'is_silent' => $recurring_campaign->settings->is_silent,
                'is_auto_hide' => $recurring_campaign->settings->is_auto_hide,

                /* Buttons */
                'button_title_1' => $recurring_campaign->settings->button_title_1,
                'button_url_1' => $recurring_campaign->settings->button_url_1,
                'button_title_2' => $recurring_campaign->settings->button_title_2,
                'button_url_2' => $recurring_campaign->settings->button_url_2,

                /* UTM */
                'utm' => [
                    'source' => $recurring_campaign->settings->utm->source,
                    'medium' => $recurring_campaign->settings->utm->medium,
                    'campaign' => $recurring_campaign->settings->utm->campaign,
                ]
            ];

            /* Database query */
            $campaign_id = db()->insert('campaigns', [
                'website_id' => $recurring_campaign->website_id,
                'user_id' => $user->user_id,
                'recurring_campaign_id' => $recurring_campaign->recurring_campaign_id,
                'name' => $name,
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'image' => $image,
                'segment' => $recurring_campaign->segment,
                'settings' => json_encode($settings),
                'subscribers_ids' => json_encode($subscribers_ids),
                'sent_subscribers_ids' => '[]',
                'total_push_notifications' => count($subscribers_ids),
                'status' => $status,
                'scheduled_datetime' => $scheduled_datetime,
                'datetime' => get_date(),
            ]);

            /* Calculate the next run */
            $next_run_datetime = get_next_run_datetime($recurring_campaign->settings->frequency, $recurring_campaign->settings->time, $recurring_campaign->settings->week_days, $recurring_campaign->settings->month_days, $user->timezone, '-15 minutes', '+16 minutes');

            db()->where('recurring_campaign_id', $recurring_campaign->recurring_campaign_id)->update('recurring_campaigns', [
                'total_campaigns' => db()->inc(),
                'next_run_datetime' => $next_run_datetime,
                'last_run_datetime' => get_date(),
            ]);

            /* Database query */
            db()->where('user_id', $user->user_id)->update('users', [
                'pusher_campaigns_current_month' => db()->inc()
            ]);

        }

        $this->close();

        /* mark cron execution */
        $this->update_cron_execution_datetimes('recurring_campaigns_datetime');
    }

}
