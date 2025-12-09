<?php defined('ALTUMCODE') || die() ?>

<?php $features = ((array) (settings()->payment->plan_features ?? [])) + array_fill_keys(require APP_PATH . 'includes/available_plan_features.php', true); ?>

<div>
    <?php foreach($features as $feature => $is_enabled): ?>

    <?php if($is_enabled && $feature == 'websites_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.websites_limit'), '<strong>' . ($data->plan_settings->websites_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->websites_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->websites_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'subscribers_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.subscribers_limit'), '<strong>' . ($data->plan_settings->subscribers_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->subscribers_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->subscribers_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'campaigns_per_month_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.campaigns_per_month_limit'), '<strong>' . ($data->plan_settings->campaigns_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->campaigns_per_month_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->campaigns_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'sent_push_notifications_per_month_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.sent_push_notifications_per_month_limit'), '<strong>' . ($data->plan_settings->sent_push_notifications_per_month_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->sent_push_notifications_per_month_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->sent_push_notifications_per_month_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'personal_notifications_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.personal_notifications_limit'), '<strong>' . ($data->plan_settings->personal_notifications_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->personal_notifications_limit)) . '</strong>') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.personal_notifications_limit_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->personal_notifications_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'rss_automations_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.rss_automations_limit'), '<strong>' . ($data->plan_settings->rss_automations_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->rss_automations_limit)) . '</strong>') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.rss_automations_limit_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->rss_automations_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'recurring_campaigns_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.recurring_campaigns_limit'), '<strong>' . ($data->plan_settings->recurring_campaigns_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->recurring_campaigns_limit)) . '</strong>') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.recurring_campaigns_limit_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->recurring_campaigns_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'segments_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.segments_limit'), '<strong>' . ($data->plan_settings->segments_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->segments_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->segments_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'flows_limit'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.flows_limit'), '<strong>' . ($data->plan_settings->flows_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->flows_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->flows_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'notification_handlers_limit'): ?>
        <?php ob_start() ?>
        <?php $notification_handlers_icon = 'fa-times text-muted'; ?>
        <div class='d-flex flex-column'>
            <?php foreach(array_keys(require APP_PATH . 'includes/notification_handlers.php') as $notification_handler): ?>
                <span class='my-1'><?= sprintf(l('global.plan_settings.notification_handlers_' . $notification_handler . '_limit'), '<strong>' . ($data->plan_settings->{'notification_handlers_' . $notification_handler . '_limit'} == -1 ? l('global.unlimited') : nr($data->plan_settings->{'notification_handlers_' . $notification_handler . '_limit'})) . '</strong>') ?></span>
                <?php if($data->plan_settings->{'notification_handlers_' . $notification_handler . '_limit'} != 0) $notification_handlers_icon = 'fa-check text-success' ?>
            <?php endforeach ?>
        </div>
        <?php $html = ob_get_clean() ?>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= l('global.plan_settings.notification_handlers_limit') ?>
                <span class="ml-1" data-toggle="tooltip" data-html="true" title="<?= $html ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $notification_handlers_icon ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'pwas_limit' && \Altum\Plugin::is_active('pwa') && settings()->websites->pwas_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.pwas_limit'), '<strong>' . ($data->plan_settings->pwas_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->pwas_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->pwas_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'domains_limit' && settings()->websites->domains_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.domains_limit'), '<strong>' . ($data->plan_settings->domains_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->domains_limit)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->domains_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'teams_limit' && \Altum\Plugin::is_active('teams')): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.teams_limit'), '<strong>' . ($data->plan_settings->teams_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->teams_limit)) . '</strong>') ?>

                <span class="ml-1" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.plan_settings.team_members_limit'), '<strong>' . ($data->plan_settings->team_members_limit == -1 ? l('global.unlimited') : nr($data->plan_settings->team_members_limit)) . '</strong>') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->teams_limit ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'affiliate_commission_percentage' && \Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div>
                <?= sprintf(l('global.plan_settings.affiliate_commission_percentage'), '<strong>' . nr($data->plan_settings->affiliate_commission_percentage) . '%</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->affiliate_commission_percentage ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'subscribers_logs_retention'): ?>
        <div class="d-flex justify-content-between align-items-center my-3">
            <div data-toggle="tooltip" title="<?= ($data->plan_settings->subscribers_logs_retention == -1 ? '' : $data->plan_settings->subscribers_logs_retention . ' ' . l('global.date.days')) ?>">
                <?= sprintf(l('global.plan_settings.subscribers_logs_retention'), '<strong>' . ($data->plan_settings->subscribers_logs_retention == -1 ? l('global.unlimited') : \Altum\Date::days_format($data->plan_settings->subscribers_logs_retention)) . '</strong>') ?>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->subscribers_logs_retention ? 'fa-check text-success' : 'fa-times text-muted' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'analytics_is_enabled'): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->analytics_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.analytics_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.analytics_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->analytics_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'api_is_enabled' && settings()->main->api_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->api_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.api_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.api_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->api_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'white_labeling_is_enabled' && settings()->main->white_labeling_is_enabled): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->white_labeling_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.white_labeling_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.white_labeling_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->white_labeling_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == sprintf(l('global.plan_settings.export'), '')): ?>
        <?php $enabled_exports_count = count(array_filter((array) $data->plan_settings->export)); ?>

        <?php ob_start() ?>
        <div class='d-flex flex-column'>
            <?php foreach(['csv', 'json', 'pdf'] as $key): ?>
                <?php if($data->plan_settings->export->{$key}): ?>
                    <span class='my-1'><?= sprintf(l('global.export_to'), mb_strtoupper($key)) ?></span>
                <?php else: ?>
                    <s class='my-1'><?= sprintf(l('global.export_to'), mb_strtoupper($key)) ?></s>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        <?php $html = ob_get_clean() ?>

        <div class="d-flex justify-content-between align-items-center my-3 <?= $enabled_exports_count ? null : 'text-muted' ?>">
            <div>
                <?= sprintf(l('global.plan_settings.export'), $enabled_exports_count) ?>
                <span class="mr-1" data-html="true" data-toggle="tooltip" title="<?= $html ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $enabled_exports_count ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'no_ads'): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->no_ads ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.no_ads') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.no_ads_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->no_ads ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'removable_branding_is_enabled'): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->removable_branding_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.removable_branding_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.removable_branding_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->removable_branding_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php if($is_enabled && $feature == 'custom_branding_is_enabled'): ?>
        <div class="d-flex justify-content-between align-items-center my-3 <?= $data->plan_settings->custom_branding_is_enabled ? null : 'text-muted' ?>">
            <div>
                <?= l('global.plan_settings.custom_branding_is_enabled') ?>
                <span class="ml-1" data-toggle="tooltip" title="<?= l('global.plan_settings.custom_branding_is_enabled_help') ?>"><i class="fas fa-fw fa-xs fa-circle-question text-gray-500"></i></span>
            </div>

            <i class="fas fa-fw fa-sm <?= $data->plan_settings->custom_branding_is_enabled ? 'fa-check text-success' : 'fa-times' ?>"></i>
        </div>
    <?php endif ?>

    <?php endforeach ?>
</div>
