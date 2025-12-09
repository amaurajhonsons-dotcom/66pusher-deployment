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

defined('ALTUMCODE') || die();

class Router {
    public static $params = [];
    public static $original_request = '';
    public static $original_request_query = '';
    public static $language_code = '';
    public static $path = '';
    public static $controller_key = 'index';
    public static $controller = 'Index';
    public static $controller_settings = [
        'wrapper' => 'wrapper',
        'no_authentication_check' => false,

        /* Enable / disable browser language detection & redirection */
        'no_browser_language_detection' => false,

        /* Enable / disable browser language detection & redirection */
        'allow_indexing' => true,

        /* Should we see a view for the controller? */
        'has_view' => true,

        /* Footer currency display */
        'currency_switcher' => false,

        /* If set on yes, ads won't show on these pages at all */
        'ads' => false,

        /* Authentication guard check (potential values: null, 'guest', 'user', 'admin') */
        'authentication' => null,

        /* Teams */
        'allow_team_access' => null,

		/* Sessions */
		'allow_sessions' => true,
    ];
    public static $method = 'index';
    public static $data = [];

    public static $routes = [
        '' => [
            'dashboard' => [
                'controller' => 'Dashboard',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'personal-notifications' => [
                'controller' => 'PersonalNotifications',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'personal-notification-create' => [
                'controller' => 'PersonalNotificationCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'personal-notification-update' => [
                'controller' => 'PersonalNotificationUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'rss-automation' => [
                'controller' => 'RssAutomation',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'rss-automations' => [
                'controller' => 'RssAutomations',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'rss-automation-create' => [
                'controller' => 'RssAutomationCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'rss-automation-update' => [
                'controller' => 'RssAutomationUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'recurring-campaign' => [
                'controller' => 'RecurringCampaign',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'recurring-campaigns' => [
                'controller' => 'RecurringCampaigns',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'recurring-campaign-create' => [
                'controller' => 'RecurringCampaignCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'recurring-campaign-update' => [
                'controller' => 'RecurringCampaignUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'campaigns' => [
                'controller' => 'Campaigns',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'campaign' => [
                'controller' => 'Campaign',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'campaign-create' => [
                'controller' => 'CampaignCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'campaign-update' => [
                'controller' => 'CampaignUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'segments' => [
                'controller' => 'Segments',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'segment-create' => [
                'controller' => 'SegmentCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'segment-update' => [
                'controller' => 'SegmentUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'flow' => [
                'controller' => 'Flow',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'flows' => [
                'controller' => 'Flows',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'flow-create' => [
                'controller' => 'FlowCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'flow-update' => [
                'controller' => 'FlowUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscribers' => [
                'controller' => 'Subscribers',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscribers-import' => [
                'controller' => 'SubscribersImport',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscribers-statistics' => [
                'controller' => 'SubscribersStatistics',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscriber' => [
                'controller' => 'Subscriber',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscriber-update' => [
                'controller' => 'SubscriberUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'subscribers-logs' => [
                'controller' => 'SubscribersLogs',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pwas' => [
                'controller' => 'Pwas',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pwa-create' => [
                'controller' => 'PwaCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pwa-update' => [
                'controller' => 'PwaUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'pwa-download' => [
                'controller' => 'PwaDownload',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'has_view' => false,
                ]
            ],

            'websites' => [
                'controller' => 'Websites',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website' => [
                'controller' => 'Website',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website-create' => [
                'controller' => 'WebsiteCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website-update' => [
                'controller' => 'WebsiteUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website-subscribe-widget' => [
                'controller' => 'WebsiteSubscribeWidget',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website-subscribe-button' => [
                'controller' => 'WebsiteSubscribeButton',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'website-sw-code' => [
                'controller' => 'WebsiteSwCode',
                'settings' => [
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                ]
            ],

            'pixel' => [
                'controller' => 'Pixel',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                ]
            ],

            'pixel_service_worker.js' => [
                'controller' => 'PixelServiceWorker',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                ]
            ],

            'pixel-track' => [
                'controller' => 'PixelTrack',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                ]
            ],

            'domains' => [
                'controller' => 'Domains',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-create' => [
                'controller' => 'DomainCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'domain-update' => [
                'controller' => 'DomainUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'notification-handlers' => [
                'controller' => 'NotificationHandlers',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'notification-handler-create' => [
                'controller' => 'NotificationHandlerCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'notification-handler-update' => [
                'controller' => 'NotificationHandlerUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                ]
            ],

            'twiml' => [
                'controller' => 'Twiml',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_sessions' => false,
                ]
            ],

            'help' => [
                'controller' => 'Help'
            ],

            /* Common routes */
            'index' => [
               'controller' => 'Index',
                'settings' => [
                    'currency_switcher' => true,
                ]
            ],

            'login' => [
                'controller' => 'Login',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'register' => [
                'controller' => 'Register',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                    'no_browser_language_detection' => true,
                ]
            ],

            'affiliate' => [
                'controller' => 'Affiliate'
            ],

            'pages' => [
                'controller' => 'Pages'
            ],

            'page' => [
                'controller' => 'Page'
            ],

            'blog' => [
                'controller' => 'Blog'
            ],

            'api-documentation' => [
                'controller' => 'ApiDocumentation',
            ],

            'contact' => [
                'controller' => 'Contact',
                'settings' => [
                    'allow_team_access' => false,
                ]
            ],

            'activate-user' => [
                'controller' => 'ActivateUser'
            ],

            'lost-password' => [
                'controller' => 'LostPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'reset-password' => [
                'controller' => 'ResetPassword',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'resend-activation' => [
                'controller' => 'ResendActivation',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'logout' => [
                'controller' => 'Logout'
            ],

            'not-found' => [
                'controller' => 'NotFound',
            ],

            'maintenance' => [
                'controller' => 'Maintenance',
                'settings' => [
                    'wrapper' => 'basic_wrapper',
                ]
            ],

            'account' => [
                'controller' => 'Account',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-preferences' => [
                'controller' => 'AccountPreferences',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-plan' => [
                'controller' => 'AccountPlan',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-redeem-code' => [
                'controller' => 'AccountRedeemCode',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-payments' => [
                'controller' => 'AccountPayments',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-logs' => [
                'controller' => 'AccountLogs',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-api' => [
                'controller' => 'AccountApi',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'account-delete' => [
                'controller' => 'AccountDelete',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'referrals' => [
                'controller' => 'Referrals',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                ]
            ],

            'invoice' => [
                'controller' => 'Invoice',
                'settings' => [
                    'wrapper' => 'invoice/invoice_wrapper',
                ]
            ],

            'plan' => [
               'controller' => 'Plan',
                'settings' => [
                    'currency_switcher' => true,
                ],
            ],

            'pay' => [
                'controller' => 'Pay',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                    'currency_switcher' => true,
                ]
            ],

            'pay-billing' => [
                'controller' => 'PayBilling',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                    'currency_switcher' => true,
                ]
            ],

            'pay-thank-you' => [
                'controller' => 'PayThankYou',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'allow_team_access' => false,
                    'currency_switcher' => true,
                ]
            ],

            'teams-system' => [
                'controller' => 'TeamsSystem',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams' => [
                'controller' => 'Teams',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-create' => [
                'controller' => 'TeamCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-update' => [
                'controller' => 'TeamUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team' => [
                'controller' => 'Team',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams-members' => [
                'controller' => 'TeamsMembers',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-member-create' => [
                'controller' => 'TeamMemberCreate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'team-member-update' => [
                'controller' => 'TeamMemberUpdate',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'teams-member' => [
                'controller' => 'TeamsMember',
                'settings' => [
                    'wrapper' => 'app_wrapper',
                    'ads' => true,
                    'allow_team_access' => false,
                ]
            ],

            'internal-notifications' => [
                'controller' => 'InternalNotifications',
                'settings' => [
                    'ads' => true,
                    'allow_team_access' => false,
                    'wrapper' => 'app_wrapper',
                ]
            ],

            'spotlight' => [
                'controller' => 'Spotlight',
                'settings' => [
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => true,
                ]
            ],

            'push-subscribers' => [
                'controller' => 'PushSubscribers',
                'settings' => [
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => true,
                ]
            ],

            'sso' => [
                'controller' => 'SSO',
                'settings' => [
                    'allow_team_access' => false,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_sessions' => true,
                ]
            ],

            /* Webhooks */
            'webhook-paypal' => [
                'controller' => 'WebhookPaypal',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-stripe' => [
                'controller' => 'WebhookStripe',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-coinbase' => [
                'controller' => 'WebhookCoinbase',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-payu' => [
                'controller' => 'WebhookPayu',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-iyzico' => [
                'controller' => 'WebhookIyzico',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-paystack' => [
                'controller' => 'WebhookPaystack',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-razorpay' => [
                'controller' => 'WebhookRazorpay',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-mollie' => [
                'controller' => 'WebhookMollie',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-yookassa' => [
                'controller' => 'WebhookYookassa',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-crypto-com' => [
                'controller' => 'WebhookCryptoCom',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-paddle' => [
                'controller' => 'WebhookPaddle',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
					'allow_sessions' => false,
                ]
            ],

            'webhook-paddle-billing' => [
                'controller' => 'WebhookPaddleBilling',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-mercadopago' => [
                'controller' => 'WebhookMercadopago',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-midtrans' => [
                'controller' => 'WebhookMidtrans',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-flutterwave' => [
                'controller' => 'WebhookFlutterwave',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-lemonsqueezy' => [
                'controller' => 'WebhookLemonsqueezy',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-myfatoorah' => [
                'controller' => 'WebhookMyfatoorah',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-klarna' => [
                'controller' => 'WebhookKlarna',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-plisio' => [
                'controller' => 'WebhookPlisio',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-plisio-whitelabel' => [
                'controller' => 'WebhookPlisioWhitelabel',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'webhook-revolut' => [
                'controller' => 'WebhookRevolut',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            /* Others */
            'cookie-consent' => [
                'controller' => 'CookieConsent',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                    'allow_sessions' => false,
                ]
            ],

            'sitemap' => [
                'controller' => 'Sitemap',
                'settings' => [
                    'no_authentication_check' => true,
                    'no_browser_language_detection' => true,
                    'has_view' => false,
                    'allow_sessions' => false,
                ]
            ],

            'cron' => [
                'controller' => 'Cron',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'broadcast' => [
                'controller' => 'Broadcast',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'no_browser_language_detection' => true,
                    'allow_sessions' => false,
                ]
            ],
        ],

        'api' => [
            'websites' => [
                'controller' => 'ApiWebsites',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'subscribers' => [
                'controller' => 'ApiSubscribers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'subscribers-statistics' => [
                'controller' => 'ApiSubscribersStatistics',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'subscribers-logs' => [
                'controller' => 'ApiSubscribersLogs',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'flows' => [
                'controller' => 'ApiFlows',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'campaigns' => [
                'controller' => 'ApiCampaigns',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'personal-notifications' => [
                'controller' => 'ApiPersonalNotifications',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'rss-automations' => [
                'controller' => 'ApiRssAutomations',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'recurring-campaigns' => [
                'controller' => 'ApiRecurringCampaigns',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'segments' => [
                'controller' => 'ApiSegments',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'domains' => [
                'controller' => 'ApiDomains',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'notification-handlers' => [
                'controller' => 'ApiNotificationHandlers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            /* Common routes */
            'teams' => [
                'controller' => 'ApiTeams',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
            'teams-member' => [
                'controller' => 'ApiTeamsMember',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
            'team-members' => [
                'controller' => 'ApiTeamMembers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
            'user' => [
                'controller' => 'ApiUser',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
            'payments' => [
                'controller' => 'ApiPayments',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
            'logs' => [
                'controller' => 'ApiLogs',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
        ],

        /* Admin Panel */
        /* Authentication is set by default to 'admin' */
        'admin' => [

            'pwas' => [
                'controller' => 'AdminPwas',
            ],

            'websites' => [
                'controller' => 'AdminWebsites',
            ],

            'subscribers' => [
                'controller' => 'AdminSubscribers',
            ],

            'personal-notifications' => [
                'controller' => 'AdminPersonalNotifications',
            ],

            'rss-automations' => [
                'controller' => 'AdminRssAutomations',
            ],

            'recurring-campaigns' => [
                'controller' => 'AdminRecurringCampaigns',
            ],

            'campaigns' => [
                'controller' => 'AdminCampaigns',
            ],

            'flows' => [
                'controller' => 'AdminFlows',
            ],

            'segments' => [
                'controller' => 'AdminSegments',
            ],

            'subscribers-logs' => [
                'controller' => 'AdminSubscribersLogs',
            ],

            'domains' => [
                'controller' => 'AdminDomains',
            ],

            'domain-create' => [
                'controller' => 'AdminDomainCreate',
            ],

            'domain-update' => [
                'controller' => 'AdminDomainUpdate',
            ],

            'notification-handlers' => [
                'controller' => 'AdminNotificationHandlers',
            ],

            /* Common routes */
            'index' => [
                'controller' => 'AdminIndex',
            ],

            'users' => [
                'controller' => 'AdminUsers',
            ],

            'user-create' => [
                'controller' => 'AdminUserCreate',
            ],

            'user-view' => [
                'controller' => 'AdminUserView',
            ],

            'user-update' => [
                'controller' => 'AdminUserUpdate',
            ],

            'users-logs' => [
                'controller' => 'AdminUsersLogs',
            ],

            'redeemed-codes' => [
                'controller' => 'AdminRedeemedCodes',
            ],

            'blog-posts' => [
                'controller' => 'AdminBlogPosts'
            ],

            'blog-post-create' => [
                'controller' => 'AdminBlogPostCreate'
            ],

            'blog-post-update' => [
                'controller' => 'AdminBlogPostUpdate'
            ],

            'blog-posts-categories' => [
                'controller' => 'AdminBlogPostsCategories'
            ],

            'blog-posts-category-create' => [
                'controller' => 'AdminBlogPostsCategoryCreate'
            ],

            'blog-posts-category-update' => [
                'controller' => 'AdminBlogPostsCategoryUpdate'
            ],

            'pages' => [
                'controller' => 'AdminPages'
            ],

            'page-create' => [
                'controller' => 'AdminPageCreate'
            ],

            'page-update' => [
                'controller' => 'AdminPageUpdate'
            ],

            'pages-categories' => [
                'controller' => 'AdminPagesCategories'
            ],

            'pages-category-create' => [
                'controller' => 'AdminPagesCategoryCreate'
            ],

            'pages-category-update' => [
                'controller' => 'AdminPagesCategoryUpdate'
            ],

            'plans' => [
                'controller' => 'AdminPlans',
            ],

            'plan-create' => [
                'controller' => 'AdminPlanCreate',
            ],

            'plan-update' => [
                'controller' => 'AdminPlanUpdate',
            ],

            'codes' => [
                'controller' => 'AdminCodes',
            ],

            'code-create' => [
                'controller' => 'AdminCodeCreate',
            ],

            'code-update' => [
                'controller' => 'AdminCodeUpdate',
            ],

            'taxes' => [
                'controller' => 'AdminTaxes'
            ],

            'taxes-import' => [
                'controller' => 'AdminTaxesImport'
            ],

            'tax-create' => [
                'controller' => 'AdminTaxCreate'
            ],

            'tax-update' => [
                'controller' => 'AdminTaxUpdate',
            ],

            'affiliates-withdrawals' => [
                'controller' => 'AdminAffiliatesWithdrawals',
            ],

            'payments' => [
                'controller' => 'AdminPayments'
            ],

            'payment-create' => [
                'controller' => 'AdminPaymentCreate',
            ],

            'statistics' => [
                'controller' => 'AdminStatistics',
            ],

            'plugins' => [
                'controller' => 'AdminPlugins',
            ],

            'languages' => [
                'controller' => 'AdminLanguages'
            ],

            'language-create' => [
                'controller' => 'AdminLanguageCreate'
            ],

            'language-update' => [
                'controller' => 'AdminLanguageUpdate'
            ],

            'settings' => [
                'controller' => 'AdminSettings',
            ],

            'api-documentation' => [
                'controller' => 'AdminApiDocumentation',
            ],

            'teams' => [
                'controller' => 'AdminTeams',
            ],

            'team-members' => [
                'controller' => 'AdminTeamMembers',
            ],

            'logs' => [
                'controller' => 'AdminLogs',
            ],

            'log' => [
                'controller' => 'AdminLog',
            ],

            'log-download' => [
                'controller' => 'AdminLogDownload',
                'settings' => [
                    'has_view' => false,
                ]
            ],

            'broadcasts' => [
                'controller' => 'AdminBroadcasts',
            ],

            'broadcast-view' => [
                'controller' => 'AdminBroadcastView',
            ],

            'broadcast-create' => [
                'controller' => 'AdminBroadcastCreate',
            ],

            'broadcast-update' => [
                'controller' => 'AdminBroadcastUpdate',
            ],

            'internal-notifications' => [
                'controller' => 'AdminInternalNotifications',
            ],

            'internal-notification-create' => [
                'controller' => 'AdminInternalNotificationCreate',
            ],

            'push-subscribers' => [
                'controller' => 'AdminPushSubscribers',
            ],

            'push-notifications' => [
                'controller' => 'AdminPushNotifications',
            ],

            'push-notification-create' => [
                'controller' => 'AdminPushNotificationCreate',
            ],

            'push-notification-update' => [
                'controller' => 'AdminPushNotificationUpdate',
            ],

            'invoice' => [
                'controller' => 'AdminInvoice',
            ],

            'dynamic-og-images' => [
                'controller' => 'AdminDynamicOgImages',
            ],

            'image-optimizer' => [
                'controller' => 'AdminImageOptimizer',
            ],
        ],

        'admin-api' => [
            'users' => [
                'controller' => 'AdminApiUsers',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'payments' => [
                'controller' => 'AdminApiPayments',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'plans' => [
                'controller' => 'AdminApiPlans',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'sso' => [
                'controller' => 'AdminApiSSO',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'dynamic-og-images' => [
                'controller' => 'AdminApiDynamicOgImages',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],

            'domains' => [
                'controller' => 'AdminApiDomains',
                'settings' => [
                    'no_authentication_check' => true,
                    'has_view' => false,
                    'allow_indexing' => false,
                    'allow_sessions' => false,
                ]
            ],
        ],
    ];


    public static function parse_url() {

        $params = self::$params;

        if(isset($_GET['altum'])) {
            $params = explode('/', input_clean(rtrim($_GET['altum'], '/')));
        }

        if(php_sapi_name() == 'cli' && isset($_SERVER['argv'])) {
            $params = explode('/', input_clean(rtrim($_SERVER['argv'][1] ?? '', '/')));
            parse_str(implode('&', array_slice($_SERVER['argv'], 2)), $_GET);
        }

        self::$params = $params;

        return $params;

    }

    public static function get_params() {

        return self::$params = array_values(self::$params);
    }

    public static function parse_language() {

        /* Check for potential language set in the first parameter */
        if(!empty(self::$params[0]) && in_array(self::$params[0], Language::$active_languages)) {

            /* Set the language */
            $language_code = input_clean(self::$params[0]);
            Language::set_by_code($language_code);
            self::$language_code = $language_code;

            /* Unset the parameter so that it wont be used further */
            unset(self::$params[0]);
            self::$params = array_values(self::$params);

        }

    }

    public static function parse_controller() {

        self::$original_request = input_clean(implode('/', self::$params));
        self::$original_request_query = http_build_query(array_diff_key($_GET, array_flip(['altum'])));

        /* Check if the current link accessed is actually the original url or not (multi domain use) */
        $original_url_host = parse_url(url(), PHP_URL_HOST);
        $request_url_host = php_sapi_name() == 'cli' ? null : input_clean($_SERVER['HTTP_HOST']);

        if(!empty($request_url_host) && $original_url_host != $request_url_host) {
            if(function_exists('idn_to_utf8')) {
                $request_url_host = idn_to_utf8($request_url_host);
            }

            /* Make sure the custom domain is attached */
            $domain = (new \Altum\Models\Domain())->get_domain_by_host($request_url_host);

            if($domain && $domain->is_enabled) {
                /* Set some route data */
                self::$data['domain'] = $domain;
            }
        }

        /* Check for potential other paths than the default one (admin panel) */
        if(!empty(self::$params[0])) {

            if(in_array(self::$params[0], ['admin', 'admin-api', 'api'])) {
                self::$path = self::$params[0];

                unset(self::$params[0]);

                self::$params = array_values(self::$params);
            }

        }

        if(!empty(self::$params[0])) {

            if(array_key_exists(self::$params[0], self::$routes[self::$path]) && file_exists(APP_PATH . 'controllers/' . (self::$path != '' ? self::$path . '/' : null) . self::$routes[self::$path][self::$params[0]]['controller'] . '.php')) {

                self::$controller_key = self::$params[0];

                unset(self::$params[0]);

            } else {

                /* Not found controller */
                self::$path = '';
                self::$controller_key = 'not-found';

            }

        }

        /* Save the current controller */
        if(!isset(self::$routes[self::$path][self::$controller_key])) {
            /* Not found controller */
            self::$path = '';
            self::$controller_key = 'not-found';
        }
        self::$controller = self::$routes[self::$path][self::$controller_key]['controller'];

        /* Admin path */
        if(self::$path == 'admin' && !isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$routes[self::$path][self::$controller_key]['settings'] = [
                'authentication' => 'admin',
                'allow_team_access' => false,
            ];
        }

        /* Make sure we also save the controller specific settings */
        if(isset(self::$routes[self::$path][self::$controller_key]['settings'])) {
            self::$controller_settings = array_merge(self::$controller_settings, self::$routes[self::$path][self::$controller_key]['settings']);
        }

        return self::$controller;

    }

    public static function get_controller($controller_ame, $path = '') {

        require_once APP_PATH . 'controllers/' . ($path != '' ? $path . '/' : null) . $controller_ame . '.php';

        /* Create a new instance of the controller */
        $class = 'Altum\\Controllers\\' . $controller_ame;

        /* Instantiate the controller class */
        $controller = new $class;

        return $controller;
    }

    public static function parse_method($controller) {

        $method = self::$method;

        /* Start the checks for existing potential methods */
        if(isset(self::get_params()[0])) {

            $original_first_param = self::$params[0];

            /* Try to check the methods with prettier URLs */
            self::$params[0] = str_replace('-', '_', self::$params[0]);

            /* Make sure to check the class method if set in the url */
            if(method_exists($controller, self::get_params()[0])) {

                /* Make sure the method is not private */
                $reflection = new \ReflectionMethod($controller, self::get_params()[0]);
                if($reflection->isPublic()) {
                    $method = self::get_params()[0];
                    unset(self::$params[0]);
                }

            }

            /* Restore pretty URL if not used */
            else {
                self::$params[0] = $original_first_param;
            }
        }

        return self::$method = $method;

    }

}
