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

class AdminPlanUpdate extends Controller {

    public function index() {

        $plan_id = isset($this->params[0]) ? $this->params[0] : null;

        /* Make sure it is either the trial / free plan or normal plans */
        switch($plan_id) {

            case 'guest':
            case 'free':
            case 'custom':

                /* Get the current settings for the free plan */
                $plan = settings()->{'plan_' . $plan_id};

                break;

            default:

                $plan_id = (int) $plan_id;

                /* Check if plan exists */
                if(!$plan = db()->where('plan_id', $plan_id)->getOne('plans')) {
                    redirect('admin/plans');
                }

                /* Parse the settings of the plan */
                $plan->settings = json_decode($plan->settings ?? '');
                $plan->additional_settings = json_decode($plan->additional_settings ?? '');
                $plan->translations = json_decode($plan->translations ?? '');
                $plan->prices = json_decode($plan->prices);

                /* Parse codes & taxes */
                $plan->taxes_ids = json_decode($plan->taxes_ids);

                if(in_array(settings()->license->type, ['Extended License', 'extended'])) {
                    /* Get the available taxes from the system */
                    $taxes = db()->get('taxes');
                }

                break;

        }

        /* Get all available plans */
        $plans = (new \Altum\Models\Plan())->get_plans();

        if(in_array(settings()->license->type, ['Extended License', 'extended'])) {
            /* Get available codes */
            $codes = db()->where('type', 'discount')->get('codes');
        }

        if(!empty($_POST)) {

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            /* Initiate purifier */
            $purifier_config = \HTMLPurifier_Config::createDefault();
            $purifier_config->set('HTML.Allowed', 'span[style]');
            $purifier_config->set('CSS.AllowedProperties', 'color,font-weight,font-style,text-decoration,font-family,background-color,text-transform,margin,padding,text-align');
            $purifier = new \HTMLPurifier($purifier_config);

            /* Translations */
            foreach($_POST['translations'] as $language_name => $array) {
                foreach($array as $key => $value) {
                    if($key == 'description') {
                        $_POST['translations'][$language_name][$key] = $purifier->purify(mb_substr($value, 0, 512));
                    } else {
                        $_POST['translations'][$language_name][$key] = input_clean($value);
                    }
                }
                if(!array_key_exists($language_name, \Altum\Language::$active_languages)) {
                    unset($_POST['translations'][$language_name]);
                }
            }

            /* Filter variables */
            $_POST['color'] = !verify_hex_color($_POST['color']) ? null : $_POST['color'];
            $_POST['suggested_plan_id'] = !empty($_POST['suggested_plan_id']) && array_key_exists($_POST['suggested_plan_id'], $plans) ? (int) $_POST['suggested_plan_id'] : null;
            $_POST['suggested_plan_code_id'] = !empty($_POST['suggested_plan_code_id']) ? (int) $_POST['suggested_plan_code_id'] : null;

            $_POST['settings'] = [
                'websites_limit'                    => (int) $_POST['websites_limit'],
                'subscribers_limit'                 => (int) $_POST['subscribers_limit'],
                'segments_limit'                    => (int) $_POST['segments_limit'],
                'personal_notifications_limit'      => (int) $_POST['personal_notifications_limit'],
                'rss_automations_limit'             => (int) $_POST['rss_automations_limit'],
                'recurring_campaigns_limit'         => (int) $_POST['recurring_campaigns_limit'],
                'flows_limit'                       => (int) $_POST['flows_limit'],
                'campaigns_per_month_limit'         => (int) $_POST['campaigns_per_month_limit'],
                'sent_push_notifications_per_month_limit' => (int) $_POST['sent_push_notifications_per_month_limit'],
                'domains_limit'                     => (int) $_POST['domains_limit'],
                'pwas_limit'                        => (int) $_POST['pwas_limit'],
                'teams_limit'                       => (int) $_POST['teams_limit'],
                'team_members_limit'                => (int) $_POST['team_members_limit'],
                'subscribers_logs_retention'        => (int) $_POST['subscribers_logs_retention'],
                'analytics_is_enabled'              => isset($_POST['analytics_is_enabled']),
                'api_is_enabled'                    => isset($_POST['api_is_enabled']),
                'affiliate_commission_percentage'   => (int) $_POST['affiliate_commission_percentage'],
                'no_ads'                            => isset($_POST['no_ads']),
                'white_labeling_is_enabled' => isset($_POST['white_labeling_is_enabled']),
                'export' => [
                    'pdf'                           => isset($_POST['export']) && in_array('pdf', $_POST['export']),
                    'csv'                           => isset($_POST['export']) && in_array('csv', $_POST['export']),
                    'json'                          => isset($_POST['export']) && in_array('json', $_POST['export']),
                ],
                'removable_branding_is_enabled'                => isset($_POST['removable_branding_is_enabled']),
                'custom_branding_is_enabled'        => isset($_POST['custom_branding_is_enabled']),
                'active_notification_handlers_per_resource_limit' => (int) $_POST['active_notification_handlers_per_resource_limit'],
            ];

            foreach(array_keys(require APP_PATH . 'includes/notification_handlers.php') as $notification_handler) {
                $_POST['settings']['notification_handlers_' . $notification_handler . '_limit'] = (int) $_POST['notification_handlers_' . $notification_handler . '_limit'];
            }

            $_POST['settings']['tag'] = input_clean($_POST['tag'], 64);

            /* Prepare more settings */
            $_POST['tag_background_color'] = !verify_hex_color($_POST['tag_background_color']) ? null : $_POST['tag_background_color'];
            $_POST['tag_text_color'] = !verify_hex_color($_POST['tag_text_color']) ? null : $_POST['tag_text_color'];

            /* Additional settings */
            $additional_settings = [
                'tag_background_color' => $_POST['tag_background_color'],
                'tag_text_color' => $_POST['tag_text_color'],
                'suggested_plan_id' => $_POST['suggested_plan_id'],
                'suggested_plan_code_id' => $_POST['suggested_plan_code_id'],
            ];

            switch($plan_id) {

                case 'free':

                    $_POST['name'] = input_clean($_POST['name']);
                    $_POST['description'] = $purifier->purify(mb_substr($_POST['description'], 0, 512));
                    $_POST['price'] = input_clean($_POST['price']);
                    $_POST['status'] = (int) $_POST['status'];

                    /* Check for any errors */
                    $required_fields = ['name', 'price'];
                    foreach($required_fields as $field) {
                        if(!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                            Alerts::add_field_error($field, l('global.error_message.empty_field'));
                        }
                    }

                    /* Make sure to not let the admin disable ALL the plans */
                    if(!$_POST['status']) {

                        $enabled_plans = (int) settings()->payment->is_enabled ? database()->query("SELECT COUNT(*) AS `total` FROM `plans` WHERE `status` <> 0")->fetch_object()->total ?? 0 : 0;

                        if(!$enabled_plans) {
                            Alerts::add_error(l('admin_plan_update.error_message.disabled_plans'));
                        }
                    }

                    $setting_key = 'plan_free';
                    $setting_value = json_encode([
                        'plan_id' => 'free',
                        'name' => $_POST['name'],
                        'description' => $_POST['description'],
                        'translations' => $_POST['translations'],
                        'price' => $_POST['price'],
                        'color' => $_POST['color'],
                        'status' => $_POST['status'],
                        'settings' => $_POST['settings'],
                        'additional_settings' => $additional_settings,
                    ]);

                    break;

                case 'custom':

                    $_POST['name'] = input_clean($_POST['name']);
                    $_POST['description'] = $purifier->purify(mb_substr($_POST['description'], 0, 512));
                    $_POST['price'] = input_clean($_POST['price']);
                    $_POST['custom_button_url'] = input_clean($_POST['custom_button_url']);
                    $_POST['status'] = (int) $_POST['status'];

                    /* Check for any errors */
                    $required_fields = ['name', 'price', 'custom_button_url'];
                    foreach($required_fields as $field) {
                        if(!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                            Alerts::add_field_error($field, l('global.error_message.empty_field'));
                        }
                    }

                    $setting_key = 'plan_custom';
                    $setting_value = json_encode([
                        'plan_id' => 'custom',
                        'name' => $_POST['name'],
                        'description' => $_POST['description'],
                        'translations' => $_POST['translations'],
                        'price' => $_POST['price'],
                        'custom_button_url' => $_POST['custom_button_url'],
                        'color' => $_POST['color'],
                        'status' => $_POST['status'],
                        'settings' => $_POST['settings'],
                        'additional_settings' => $additional_settings,
                    ]);

                    break;

                default:

                    $_POST['name'] = input_clean($_POST['name']);
                    $_POST['description'] = $purifier->purify(mb_substr($_POST['description'], 0, 512));
                    $_POST['trial_days'] = (int) $_POST['trial_days'];
                    $_POST['status'] = (int) $_POST['status'];
                    $_POST['order'] = (int) $_POST['order'];
                    $_POST['taxes_ids'] = json_encode($_POST['taxes_ids'] ?? []);
                    $_POST['settings']['custom_redirect_url'] = get_url($_POST['custom_redirect_url']);

                    /* Prices */
            $prices = [
                'monthly' => [],
                'quarterly' => [],
                'biannual' => [],
                'annual' => [],
                'lifetime' => [],
            ];

            foreach((array) settings()->payment->currencies as $currency => $currency_data) {
                $prices['monthly'][$currency] = (float) $_POST['monthly_price'][$currency];
                $prices['quarterly'][$currency] = (float) $_POST['quarterly_price'][$currency];
                $prices['biannual'][$currency] = (float) $_POST['biannual_price'][$currency];
                $prices['annual'][$currency] = (float) $_POST['annual_price'][$currency];
                $prices['lifetime'][$currency] = (float) $_POST['lifetime_price'][$currency];
            }

                    $prices = json_encode($prices);

                    /* Check for any errors */
                    $required_fields = ['name'];
                    foreach($required_fields as $field) {
                        if(!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                            Alerts::add_field_error($field, l('global.error_message.empty_field'));
                        }
                    }

                    /* Make sure to not let the admin disable ALL the plans */
                    if(!$_POST['status']) {

                        $enabled_plans = (int) database()->query("SELECT COUNT(*) AS `total` FROM `plans` WHERE `status` <> 0")->fetch_object()->total ?? 0;

                        if(
                            (
                                !$enabled_plans ||
                                ($enabled_plans == 1 && $plan->status))
                            && !settings()->plan_free->status
                        ) {
                            Alerts::add_error(l('admin_plan_update.error_message.disabled_plans'));
                        }
                    }

                    break;

            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Update the plan in database */
                switch ($plan_id) {

                    case 'guest':
                    case 'free':
                    case 'custom':

                        db()->where('`key`', $setting_key)->update('settings', ['value' => $setting_value]);

                        /* Clear the cache */
                        cache()->deleteItem('settings');

                        break;

                    default:

                        $settings = json_encode($_POST['settings']);
                        $translations = json_encode($_POST['translations']);

                        db()->where('plan_id', $plan_id)->update('plans', [
                            'name' => $_POST['name'],
                            'description' => $_POST['description'],
                            'translations' => $translations,
                            'prices' => $prices,
                            'trial_days' => $_POST['trial_days'],
                            'settings' => $settings,
                            'taxes_ids' => $_POST['taxes_ids'],
                            'color' => $_POST['color'],
                            'status' => $_POST['status'],
                            'order' => $_POST['order'],
                            'additional_settings' => json_encode($additional_settings),
                        ]);

                        /* Clear the cache */
                        cache()->deleteItem('plans');

                        break;

                }

                /* Update all users plan settings with these ones */
                if(isset($_POST['submit_update_users_plan_settings'])) {

                    $plan_settings = json_encode($_POST['settings']);

                    db()->where('plan_id', $plan_id)->update('users', ['plan_settings' => $plan_settings]);

                    /* Clear the cache */
                    cache()->clear();
                }

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . $plan->name . '</strong>'));

                /* Refresh the page */
                redirect('admin/plan-update/' . $plan_id);

            }

        }

       /* Main View */
        $data = [
            'plan_id' => $plan_id,
            'plan' => $plan,
            'plans' => $plans,
            'codes' => $codes ?? null,
            'taxes' => $taxes ?? null,
        ];

        $view = new \Altum\View('admin/plan-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
