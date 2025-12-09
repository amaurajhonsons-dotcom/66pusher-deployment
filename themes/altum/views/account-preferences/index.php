<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <?= $this->views['account_header_menu'] ?>

    <div class="d-flex align-items-center mb-3">
        <h1 class="h4 m-0"><?= l('account_preferences.header') ?></h1>

        <div class="ml-2">
            <span data-toggle="tooltip" title="<?= l('account_preferences.subheader') ?>">
                <i class="fas fa-fw fa-info-circle text-muted"></i>
            </span>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form id="account_preferences" action="" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <?php if(settings()->main->white_labeling_is_enabled): ?>
                    <button class="btn btn-block btn-gray-200 font-size-little-small font-weight-450 mb-4" type="button" data-toggle="collapse" data-target="#white_labeling_container" aria-expanded="false" aria-controls="white_labeling_container">
                        <i class="fas fa-fw fa-cube fa-sm mr-1"></i> <?= l('account_preferences.white_labeling') ?>
                    </button>

                    <div class="collapse" data-parent="#account_preferences" id="white_labeling_container">
                        <div <?= $this->user->plan_settings->white_labeling_is_enabled ? null : get_plan_feature_disabled_info() ?>>
                            <div class="<?= $this->user->plan_settings->white_labeling_is_enabled ? null : 'container-disabled' ?>">
                                <div class="form-group">
                                    <label for="white_label_title"><i class="fas fa-fw fa-sm fa-heading text-muted mr-1"></i> <?= l('account_preferences.white_label_title') ?></label>
                                    <input type="text" id="white_label_title" name="white_label_title" class="form-control <?= \Altum\Alerts::has_field_errors('white_label_title') ? 'is-invalid' : null ?>" value="<?= $this->user->preferences->white_label_title ?>" maxlength="32" />
                                    <?= \Altum\Alerts::output_field_error('white_label_title') ?>
                                </div>

                                <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= get_max_upload() ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), get_max_upload()) ?>">
                                    <label for="white_label_logo_light"><i class="fas fa-fw fa-sm fa-sun text-muted mr-1"></i> <?= l('account_preferences.white_label_logo_light') ?></label>
                                    <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'users', 'file_key' => 'white_label_logo_light', 'already_existing_image' => $this->user->preferences->white_label_logo_light]) ?>
                                    <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('users')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), get_max_upload()) ?></small>
                                </div>

                                <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= get_max_upload() ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), get_max_upload()) ?>">
                                    <label for="white_label_logo_dark"><i class="fas fa-fw fa-sm fa-moon text-muted mr-1"></i> <?= l('account_preferences.white_label_logo_dark') ?></label>
                                    <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'users', 'file_key' => 'white_label_logo_dark', 'already_existing_image' => $this->user->preferences->white_label_logo_dark]) ?>
                                    <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('users')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), get_max_upload()) ?></small>
                                </div>

                                <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= get_max_upload() ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), get_max_upload()) ?>">
                                    <label for="white_label_favicon"><i class="fas fa-fw fa-sm fa-icons text-muted mr-1"></i> <?= l('account_preferences.white_label_favicon') ?></label>
                                    <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'users', 'file_key' => 'white_label_favicon', 'already_existing_image' => $this->user->preferences->white_label_favicon]) ?>
                                    <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('users')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), get_max_upload()) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <button class="btn btn-block btn-gray-200 font-size-little-small font-weight-450 mb-4" type="button" data-toggle="collapse" data-target="#default_settings_container" aria-expanded="false" aria-controls="default_settings_container">
                    <i class="fas fa-fw fa-wrench fa-sm mr-1"></i> <?= l('account_preferences.default_settings') ?>
                </button>

                <div class="collapse" data-parent="#account_preferences" id="default_settings_container">
                    <div class="form-group">
                        <label for="default_results_per_page"><i class="fas fa-fw fa-sm fa-list-ol text-muted mr-1"></i> <?= l('account_preferences.default_results_per_page') ?></label>
                        <select id="default_results_per_page" name="default_results_per_page" class="custom-select <?= \Altum\Alerts::has_field_errors('default_results_per_page') ? 'is-invalid' : null ?>">
                            <?php foreach([10, 25, 50, 100, 250, 500, 1000] as $key): ?>
                                <option value="<?= $key ?>" <?= ($this->user->preferences->default_results_per_page ?? settings()->main->default_results_per_page) == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                            <?php endforeach ?>
                        </select>
                        <?= \Altum\Alerts::output_field_error('default_results_per_page') ?>
                    </div>

                    <div class="form-group">
                        <label for="default_order_type"><i class="fas fa-fw fa-sm fa-sort text-muted mr-1"></i> <?= l('account_preferences.default_order_type') ?></label>
                        <select id="default_order_type" name="default_order_type" class="custom-select <?= \Altum\Alerts::has_field_errors('default_order_type') ? 'is-invalid' : null ?>">
                            <option value="ASC" <?= ($this->user->preferences->default_order_type ?? settings()->main->default_order_type) == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                            <option value="DESC" <?= ($this->user->preferences->default_order_type ?? settings()->main->default_order_type) == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('default_order_type') ?>
                    </div>

                    <div class="form-group">
                        <label for="websites_default_order_by"><i class="fas fa-fw fa-sm fa-pager text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('websites.title')) ?></label>
                        <select id="websites_default_order_by" name="websites_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('websites_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="website_id" <?= $this->user->preferences->websites_default_order_by == 'website_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->websites_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->websites_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->websites_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="host" <?= $this->user->preferences->websites_default_order_by == 'host' ? 'selected="selected"' : null ?>><?= l('websites.host') ?></option>
                            <option value="path" <?= $this->user->preferences->websites_default_order_by == 'path' ? 'selected="selected"' : null ?>><?= l('websites.path') ?></option>
                            <option value="total_sent_campaigns" <?= $this->user->preferences->websites_default_order_by == 'total_sent_campaigns' ? 'selected="selected"' : null ?>><?= l('website.total_sent_campaigns') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->websites_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                            <option value="total_displayed_push_notifications" <?= $this->user->preferences->websites_default_order_by == 'total_displayed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_displayed_push_notifications') ?></option>
                            <option value="total_clicked_push_notifications" <?= $this->user->preferences->websites_default_order_by == 'total_clicked_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_clicked_push_notifications') ?></option>
                            <option value="total_closed_push_notifications" <?= $this->user->preferences->websites_default_order_by == 'total_closed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_closed_push_notifications') ?></option>
                            <option value="total_subscribers" <?= $this->user->preferences->websites_default_order_by == 'total_subscribers' ? 'selected="selected"' : null ?>><?= l('websites.total_subscribers') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('websites_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="subscribers_default_order_by"><i class="fas fa-fw fa-sm fa-user-check text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('subscribers.title')) ?></label>
                        <select id="subscribers_default_order_by" name="subscribers_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('subscribers_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="subscriber_id" <?= $this->user->preferences->subscribers_default_order_by == 'subscriber_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->subscribers_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->subscribers_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="last_sent_datetime" <?= $this->user->preferences->subscribers_default_order_by == 'last_sent_datetime' ? 'selected="selected"' : null ?>><?= l('campaigns.last_sent_datetime') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->subscribers_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('subscribers_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="subscribers_logs_default_order_by"><i class="fas fa-fw fa-sm fa-stream text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('subscribers_logs.title')) ?></label>
                        <select id="subscribers_logs_default_order_by" name="subscribers_logs_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('subscribers_logs_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="subscriber_log_id" <?= $this->user->preferences->subscribers_logs_default_order_by == 'subscriber_log_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->subscribers_logs_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('subscribers_logs_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="campaigns_default_order_by"><i class="fas fa-fw fa-sm fa-rocket text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('campaigns.title')) ?></label>
                        <select id="campaigns_default_order_by" name="campaigns_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('campaigns_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="campaign_id" <?= $this->user->preferences->campaigns_default_order_by == 'campaign_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->campaigns_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->campaigns_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="scheduled_datetime" <?= $this->user->preferences->campaigns_default_order_by == 'scheduled_datetime' ? 'selected="selected"' : null ?>><?= l('campaigns.scheduled_datetime') ?></option>
                            <option value="last_sent_datetime" <?= $this->user->preferences->campaigns_default_order_by == 'last_sent_datetime' ? 'selected="selected"' : null ?>><?= l('campaigns.last_sent_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->campaigns_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="title" <?= $this->user->preferences->campaigns_default_order_by == 'title' ? 'selected="selected"' : null ?>><?= l('global.title') ?></option>
                            <option value="total_push_notifications" <?= $this->user->preferences->campaigns_default_order_by == 'total_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_push_notifications') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->campaigns_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                            <option value="total_displayed_push_notifications" <?= $this->user->preferences->campaigns_default_order_by == 'total_displayed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_displayed_push_notifications') ?></option>
                            <option value="total_clicked_push_notifications" <?= $this->user->preferences->campaigns_default_order_by == 'total_clicked_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_clicked_push_notifications') ?></option>
                            <option value="total_closed_push_notifications" <?= $this->user->preferences->campaigns_default_order_by == 'total_closed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_closed_push_notifications') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('campaigns_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="personal_notifications_default_order_by"><i class="fas fa-fw fa-sm fa-code-branch text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('personal_notifications.title')) ?></label>
                        <select id="personal_notifications_default_order_by" name="personal_notifications_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('personal_notifications_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="personal_notification_id" <?= $this->user->preferences->personal_notifications_default_order_by == 'personal_notification_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->personal_notifications_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->personal_notifications_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="sent_datetime" <?= $this->user->preferences->personal_notifications_default_order_by == 'sent_datetime' ? 'selected="selected"' : null ?>><?= l('personal_notifications.sent_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->personal_notifications_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="title" <?= $this->user->preferences->personal_notifications_default_order_by == 'title' ? 'selected="selected"' : null ?>><?= l('global.title') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('personal_notifications_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="flows_default_order_by"><i class="fas fa-fw fa-sm fa-tasks text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('flows.title')) ?></label>
                        <select id="flows_default_order_by" name="flows_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('flows_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="flow_id" <?= $this->user->preferences->flows_default_order_by == 'flow_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->flows_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->flows_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="last_sent_datetime" <?= $this->user->preferences->flows_default_order_by == 'last_sent_datetime' ? 'selected="selected"' : null ?>><?= l('campaigns.last_sent_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->flows_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="title" <?= $this->user->preferences->flows_default_order_by == 'title' ? 'selected="selected"' : null ?>><?= l('global.title') ?></option>
                            <option value="total_push_notifications" <?= $this->user->preferences->flows_default_order_by == 'total_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_push_notifications') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->flows_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                            <option value="total_displayed_push_notifications" <?= $this->user->preferences->flows_default_order_by == 'total_displayed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_displayed_push_notifications') ?></option>
                            <option value="total_clicked_push_notifications" <?= $this->user->preferences->flows_default_order_by == 'total_clicked_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_clicked_push_notifications') ?></option>
                            <option value="total_closed_push_notifications" <?= $this->user->preferences->flows_default_order_by == 'total_closed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_closed_push_notifications') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('flows_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="rss_automations_default_order_by"><i class="fas fa-fw fa-sm fa-rss text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('rss_automations.title')) ?></label>
                        <select id="rss_automations_default_order_by" name="rss_automations_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('rss_automations_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="rss_automation_id" <?= $this->user->preferences->rss_automations_default_order_by == 'rss_automation_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->rss_automations_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->rss_automations_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="last_check_datetime" <?= $this->user->preferences->rss_automations_default_order_by == 'last_check_datetime' ? 'selected="selected"' : null ?>><?= l('rss_automations.last_check_datetime') ?></option>
                            <option value="next_check_datetime" <?= $this->user->preferences->rss_automations_default_order_by == 'next_check_datetime' ? 'selected="selected"' : null ?>><?= l('rss_automations.next_check_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->rss_automations_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="title" <?= $this->user->preferences->rss_automations_default_order_by == 'title' ? 'selected="selected"' : null ?>><?= l('global.title') ?></option>
                            <option value="total_campaigns" <?= $this->user->preferences->rss_automations_default_order_by == 'total_campaigns' ? 'selected="selected"' : null ?>><?= l('rss_automations.total_campaigns') ?></option>
                            <option value="total_push_notifications" <?= $this->user->preferences->rss_automations_default_order_by == 'total_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_push_notifications') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->rss_automations_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                            <option value="total_displayed_push_notifications" <?= $this->user->preferences->rss_automations_default_order_by == 'total_displayed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_displayed_push_notifications') ?></option>
                            <option value="total_clicked_push_notifications" <?= $this->user->preferences->rss_automations_default_order_by == 'total_clicked_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_clicked_push_notifications') ?></option>
                            <option value="total_closed_push_notifications" <?= $this->user->preferences->rss_automations_default_order_by == 'total_closed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_closed_push_notifications') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('rss_automations_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="recurring_campaigns_default_order_by"><i class="fas fa-fw fa-sm fa-retweet text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('recurring_campaigns.title')) ?></label>
                        <select id="recurring_campaigns_default_order_by" name="recurring_campaigns_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('recurring_campaigns_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="recurring_campaign_id" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'recurring_campaign_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="last_run_datetime" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'last_run_datetime' ? 'selected="selected"' : null ?>><?= l('recurring_campaigns.last_run_datetime') ?></option>
                            <option value="next_run_datetime" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'next_run_datetime' ? 'selected="selected"' : null ?>><?= l('recurring_campaigns.next_run_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="title" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'title' ? 'selected="selected"' : null ?>><?= l('global.title') ?></option>
                            <option value="total_campaigns" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_campaigns' ? 'selected="selected"' : null ?>><?= l('recurring_campaigns.total_campaigns') ?></option>
                            <option value="total_push_notifications" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_push_notifications') ?></option>
                            <option value="total_sent_push_notifications" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_sent_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_sent_push_notifications') ?></option>
                            <option value="total_displayed_push_notifications" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_displayed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_displayed_push_notifications') ?></option>
                            <option value="total_clicked_push_notifications" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_clicked_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_clicked_push_notifications') ?></option>
                            <option value="total_closed_push_notifications" <?= $this->user->preferences->recurring_campaigns_default_order_by == 'total_closed_push_notifications' ? 'selected="selected"' : null ?>><?= l('campaigns.total_closed_push_notifications') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('recurring_campaigns_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="segments_default_order_by"><i class="fas fa-fw fa-sm fa-layer-group text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('segments.title')) ?></label>
                        <select id="segments_default_order_by" name="segments_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('segments_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="segment_id" <?= $this->user->preferences->segments_default_order_by == 'segment_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->segments_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->segments_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->segments_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            <option value="total_subscribers" <?= $this->user->preferences->segments_default_order_by == 'total_subscribers' ? 'selected="selected"' : null ?>><?= l('websites.total_subscribers') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('segments_default_order_by') ?>
                    </div>

                    <div class="form-group">
                        <label for="notification_handlers_default_order_by"><i class="fas fa-fw fa-sm fa-bell text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('notification_handlers.title')) ?></label>
                        <select id="notification_handlers_default_order_by" name="notification_handlers_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('notification_handlers_default_order_by') ? 'is-invalid' : null ?>">
                            <option value="notification_handler_id" <?= $this->user->preferences->notification_handlers_default_order_by == 'notification_handler_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                            <option value="datetime" <?= $this->user->preferences->notification_handlers_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                            <option value="last_datetime" <?= $this->user->preferences->notification_handlers_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                            <option value="name" <?= $this->user->preferences->notification_handlers_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                        </select>
                        <?= \Altum\Alerts::output_field_error('notification_handlers_default_order_by') ?>
                    </div>

                    <?php if(\Altum\Plugin::is_active('pwa') && settings()->websites->pwas_is_enabled): ?>
                        <div class="form-group">
                            <label for="pwas_default_order_by"><i class="fas fa-fw fa-sm fa-mobile text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('pwas.title')) ?></label>
                            <select id="pwas_default_order_by" name="pwas_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('pwas_default_order_by') ? 'is-invalid' : null ?>">
                                <option value="pwa_id" <?= $this->user->preferences->pwas_default_order_by == 'pwa_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                                <option value="datetime" <?= $this->user->preferences->pwas_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                <option value="last_datetime" <?= $this->user->preferences->pwas_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                                <option value="name" <?= $this->user->preferences->pwas_default_order_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                            </select>
                            <?= \Altum\Alerts::output_field_error('pwas_default_order_by') ?>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->websites->domains_is_enabled): ?>
                        <div class="form-group">
                            <label for="domains_default_order_by"><i class="fas fa-fw fa-sm fa-globe text-muted mr-1"></i> <?= sprintf(l('account_preferences.default_order_by_x'), l('domains.title')) ?></label>
                            <select id="domains_default_order_by" name="domains_default_order_by" class="custom-select <?= \Altum\Alerts::has_field_errors('domains_default_order_by') ? 'is-invalid' : null ?>">
                                <option value="domain_id" <?= $this->user->preferences->domains_default_order_by == 'domain_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                                <option value="datetime" <?= $this->user->preferences->domains_default_order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                <option value="last_datetime" <?= $this->user->preferences->domains_default_order_by == 'last_datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_last_datetime') ?></option>
                                <option value="host" <?= $this->user->preferences->domains_default_order_by == 'host' ? 'selected="selected"' : null ?>><?= l('domains.table.host') ?></option>
                            </select>
                            <?= \Altum\Alerts::output_field_error('domains_default_order_by') ?>
                        </div>
                    <?php endif ?>
                </div>

                <button class="btn btn-block btn-gray-200 font-size-little-small font-weight-450 mb-4" type="button" data-toggle="collapse" data-target="#dashboard_settings_container" aria-expanded="false" aria-controls="dashboard_settings_container">
                    <i class="fas fa-fw fa-table-cells fa-sm mr-1"></i> <?= l('account_preferences.dashboard_features') ?>
                </button>

                <div class="collapse" data-parent="#account_preferences" id="dashboard_settings_container">
                    <div class="form-group">
                        <label><i class="fas fa-fw fa-sm fa-table-cells text-muted mr-1"></i> <?= l('account_preferences.dashboard_features') ?></label>
                    </div>

                    <div id="dashboard_features">
                        <?php $dashboard_features = ((array) $this->user->preferences->dashboard) + array_fill_keys(['websites', 'subscribers', 'campaigns', 'personal_notifications', 'rss_automations', 'recurring_campaigns', 'flows', 'segments'], true) ?>
                        <?php $index = 0; ?>
                        <?php foreach($dashboard_features as $feature => $is_enabled): ?>
                            <div class="d-flex">
                            <span class="mr-2">
                                <i class="fas fa-fw fa-sm fa-bars text-muted cursor-grab drag"></i>
                            </span>

                                <div class="form-group custom-control custom-checkbox" data-dashboard-feature>
                                    <input id="<?= 'dashboard_' . $feature ?>" name="dashboard[<?= $index++ ?>]" value="<?= $feature ?>" type="checkbox" class="custom-control-input" <?= $is_enabled ? 'checked="checked"' : null ?>>
                                    <label class="custom-control-label" for="<?= 'dashboard_' . $feature ?>"><?= l('dashboard.' . $feature . '.header') ?></label>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.update') ?></button>
            </form>
        </div>
    </div>
</div>


<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/sortable.js?v=' . PRODUCT_CODE ?>"></script>
<script>
    'use strict';
    
    let sortable = Sortable.create(document.getElementById('dashboard_features'), {
        animation: 150,
        handle: '.drag',
        onUpdate: event => {

            document.querySelectorAll('#dashboard_features > div').forEach((elm, i) => {
                let input = elm.querySelector('input[type="checkbox"]');
                if(input) {
                    input.setAttribute('name', `dashboard[${i}]`);
                }
            });

        }
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
