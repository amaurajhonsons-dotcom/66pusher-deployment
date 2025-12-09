<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="mb-3 d-flex justify-content-between">
        <div>
            <h1 class="h4 mb-0 text-truncate"><i class="fas fa-fw fa-xs fa-table-cells mr-1"></i> <?= l('dashboard.header') ?></h1>
        </div>
    </div>

    <div class="my-4">
        <div class="row m-n2">
            <!-- Total Websites -->
            <div class="col-12 col-sm-6 col-xl-3 p-2 position-relative text-truncate">
                <div id="total_websites_wrapper" class="card d-flex flex-row h-100 overflow-hidden" style="background: var(--body-bg)" data-toggle="tooltip" data-html="true">
                    <div class="pl-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('websites') ?>" class="stretched-link">
                            <div class="p-2 rounded-2x index-widget-icon d-flex align-items-center justify-content-center bg-website">
                                <i class="fas fa-fw fa-sm fa-pager text-website"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-body text-truncate">
                        <div id="total_websites" class="text-truncate">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        </div>
                        <div id="total_websites_progress" class="progress" style="height: .25rem;">
                            <div class="progress-bar <?= $this->user->plan_settings->websites_limit == -1 ? 'bg-success' : null ?>" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Subscribers -->
            <div class="col-12 col-sm-6 col-xl-3 p-2 position-relative text-truncate">
                <div id="total_subscribers_wrapper" class="card d-flex flex-row h-100 overflow-hidden" style="background: var(--body-bg)" data-toggle="tooltip" data-html="true">
                    <div class="pl-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('subscribers') ?>" class="stretched-link">
                            <div class="p-2 rounded-2x index-widget-icon d-flex align-items-center justify-content-center bg-subscriber">
                                <i class="fas fa-fw fa-sm fa-user-check text-subscriber"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-body text-truncate">
                        <div id="total_subscribers" class="text-truncate">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        </div>
                        <div id="total_subscribers_progress" class="progress" style="height: .25rem;">
                            <div class="progress-bar <?= $this->user->plan_settings->subscribers_limit == -1 ? 'bg-success' : null ?>" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Campaigns This Month -->
            <div class="col-12 col-sm-6 col-xl-3 p-2 position-relative text-truncate">
                <div id="total_campaigns_this_month_wrapper" class="card d-flex flex-row h-100 overflow-hidden" style="background: var(--body-bg)" data-toggle="tooltip" data-html="true">
                    <div class="pl-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('campaigns') ?>" class="stretched-link">
                            <div class="p-2 rounded-2x index-widget-icon d-flex align-items-center justify-content-center bg-campaign">
                                <i class="fas fa-fw fa-sm fa-rocket text-campaign"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-body text-truncate">
                        <div id="total_campaigns_this_month" class="text-truncate">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        </div>
                        <div id="total_campaigns_this_month_progress" class="progress" style="height: .25rem;">
                            <div class="progress-bar <?= $this->user->plan_settings->campaigns_per_month_limit == -1 ? 'bg-success' : null ?>" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sent Push Notifications This Month -->
            <div class="col-12 col-sm-6 col-xl-3 p-2 position-relative text-truncate">
                <div id="total_sent_push_notifications_wrapper" class="card d-flex flex-row h-100 overflow-hidden" style="background: var(--body-bg)" data-toggle="tooltip" data-html="true">
                    <div class="pl-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('campaigns') ?>" class="stretched-link">
                            <div class="p-2 rounded-2x index-widget-icon d-flex align-items-center justify-content-center bg-notification">
                                <i class="fas fa-fw fa-sm fa-fire text-notification"></i>
                            </div>
                        </a>
                    </div>
                    <div class="card-body text-truncate">
                        <div id="total_sent_push_notifications" class="text-truncate">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                        </div>
                        <div id="total_sent_push_notifications_progress" class="progress" style="height: .25rem;">
                            <div class="progress-bar <?= $this->user->plan_settings->sent_push_notifications_per_month_limit == -1 ? 'bg-success' : null ?>" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5">
            <div class="card-body">
                <div class="chart-container d-none" id="subscribers_logs_chart_container">
                    <canvas id="subscribers_logs_chart"></canvas>
                </div>

                <div id="subscribers_logs_chart_no_data" class="d-none">
                    <?= include_view(THEME_PATH . 'views/partials/no_chart_data.php', ['has_wrapper' => false]); ?>
                </div>

                <div id="subscribers_logs_chart_loading" class="chart-container d-flex align-items-center justify-content-center">
                    <span class="spinner-border spinner-border-lg" role="status"></span>
                </div>

                <?php if(settings()->main->chart_cache): ?>
                    <small class="text-muted d-none" id="subscribers_logs_chart_help">
                        <span data-toggle="tooltip" title="<?= sprintf(l('global.chart_help'), settings()->main->chart_cache ?? 12, settings()->main->chart_days ?? 30) ?>"><i class="fas fa-fw fa-sm fa-info-circle mr-1"></i></span>
                        <span class="d-lg-none"><?= sprintf(l('global.chart_help'), settings()->main->chart_cache ?? 12, settings()->main->chart_days ?? 30) ?></span>
                    </small>
                <?php endif ?>
            </div>
        </div>

    <?php require THEME_PATH . 'views/partials/js_chart_defaults.php' ?>


    <?php ob_start() ?>
    <script>
    'use strict';
    
        (async function fetch_statistics() {
            /* Send request to server */
            let response = await fetch(`${url}dashboard/get_stats_ajax`, {
                method: 'get',
            });

            let data = null;
            try {
                data = await response.json();
            } catch (error) {
                /* :)  */
            }

            if(!response.ok) {
                /* :)  */
            }

            if(data.status == 'error') {
                /* :)  */
            } else if(data.status == 'success') {

                /* update total_websites */
                const total_websites_element = document.querySelector('#total_websites');
                if (total_websites_element) {
                    let total_websites_translation = <?= json_encode(l('dashboard.total_websites')) ?>;
                    let total_websites = data.details.total_websites ? data.details.total_websites : 0;
                    let total_websites_html = total_websites_translation.replace('%s', `<span class='h6' id='total_websites'>${nr(total_websites)}</span>`);

                    let websites_plan_limit = <?= (int) $this->user->plan_settings->websites_limit ?>;

                    /* calculate progress */
                    let progress = 0;
                    if (websites_plan_limit > 0) {
                        progress = Math.min((total_websites / websites_plan_limit) * 100, 100);
                    }

                    document.querySelector('#total_websites_progress .progress-bar').style.width = `${progress}%`;

                    document.querySelector('#total_websites_wrapper').setAttribute('title', get_plan_feature_limit_info(total_websites, websites_plan_limit, true, <?= json_encode(l('global.info_message.plan_feature_limit_info')) ?>));
                    total_websites_element.innerHTML = total_websites_html;
                }

                /* update total_subscribers */
                const total_subscribers_element = document.querySelector('#total_subscribers');
                if (total_subscribers_element) {
                    let total_subscribers_translation = <?= json_encode(l('dashboard.total_subscribers')) ?>;
                    let total_subscribers = data.details.total_subscribers ? data.details.total_subscribers : 0;
                    let total_subscribers_html = total_subscribers_translation.replace('%s', `<span class='h6' id='total_subscribers'>${nr(total_subscribers)}</span>`);

                    let subscribers_plan_limit = <?= (int) $this->user->plan_settings->subscribers_limit ?>;

                    /* calculate progress */
                    let progress = 0;
                    if (subscribers_plan_limit > 0) {
                        progress = Math.min((total_subscribers / subscribers_plan_limit) * 100, 100);
                    }

                    document.querySelector('#total_subscribers_progress .progress-bar').style.width = `${progress}%`;

                    document.querySelector('#total_subscribers_wrapper').setAttribute('title', get_plan_feature_limit_info(total_subscribers, subscribers_plan_limit, true, <?= json_encode(l('global.info_message.plan_feature_limit_info')) ?>));
                    total_subscribers_element.innerHTML = total_subscribers_html;
                }

                /* update total_campaigns_this_month */
                const total_campaigns_this_month_element = document.querySelector('#total_campaigns_this_month');
                if (total_campaigns_this_month_element) {
                    let total_campaigns_this_month_translation = <?= json_encode(l('dashboard.total_campaigns')) ?>;
                    let total_campaigns_this_month = data.details.total_campaigns ? data.details.total_campaigns : 0;
                    let total_campaigns_this_month_html = total_campaigns_this_month_translation.replace('%s', `<span class='h6' id='total_campaigns_this_month'>${nr(total_campaigns_this_month)}</span>`);

                    let campaigns_per_month_limit = <?= (int) $this->user->plan_settings->campaigns_per_month_limit ?>;

                    /* calculate progress */
                    let progress = 0;
                    if (campaigns_per_month_limit > 0) {
                        progress = Math.min((total_campaigns_this_month / campaigns_per_month_limit) * 100, 100);
                    }

                    document.querySelector('#total_campaigns_this_month_progress .progress-bar').style.width = `${progress}%`;

                    document.querySelector('#total_campaigns_this_month_wrapper').setAttribute('title', get_plan_feature_limit_info(total_campaigns_this_month, campaigns_per_month_limit, true, <?= json_encode(l('global.info_message.plan_feature_limit_month_info')) ?>));
                    total_campaigns_this_month_element.innerHTML = total_campaigns_this_month_html;
                }

                /* update total_sent_push_notifications */
                const total_sent_push_notifications_element = document.querySelector('#total_sent_push_notifications');
                if (total_sent_push_notifications_element) {
                    let total_sent_push_notifications_translation = <?= json_encode(l('dashboard.total_sent_push_notifications')) ?>;
                    let total_sent_push_notifications = data.details.total_sent_push_notifications ? data.details.total_sent_push_notifications : 0;
                    let total_sent_push_notifications_this_month = data.details.usage.pusher_sent_push_notifications_current_month ? data.details.usage.pusher_sent_push_notifications_current_month : 0;
                    let total_sent_push_notifications_html = total_sent_push_notifications_translation.replace('%s', `<span class='h6' id='total_sent_push_notifications'>${nr(total_sent_push_notifications)}</span>`);

                    let sent_push_notifications_per_month_limit = <?= (int) $this->user->plan_settings->sent_push_notifications_per_month_limit ?>;

                    /* calculate progress */
                    let progress = 0;
                    if (sent_push_notifications_per_month_limit > 0) {
                        progress = Math.min((total_sent_push_notifications / sent_push_notifications_per_month_limit) * 100, 100);
                    }

                    document.querySelector('#total_sent_push_notifications_progress .progress-bar').style.width = `${progress}%`;

                    document.querySelector('#total_sent_push_notifications_wrapper').setAttribute('title', get_plan_feature_limit_info(total_sent_push_notifications_this_month, sent_push_notifications_per_month_limit, true, <?= json_encode(l('global.info_message.plan_feature_limit_month_info')) ?>));
                    total_sent_push_notifications_element.innerHTML = total_sent_push_notifications_html;
                }

                tooltips_initiate();

                /* Remove loading */
                document.querySelector('#subscribers_logs_chart_loading').classList.add('d-none');
                document.querySelector('#subscribers_logs_chart_loading').classList.remove('d-flex');

                /* Chart */
                if(data.details.subscribers_logs_chart.is_empty) {
                    document.querySelector('#subscribers_logs_chart_no_data').classList.remove('d-none');
                } else {
                    /* Display chart data */
                    document.querySelector('#subscribers_logs_chart_container').classList.remove('d-none');
                    let help_element = document.querySelector('#subscribers_logs_chart_help');
                    if(help_element) {
                        help_element.classList.remove('d-none');
                    }

                    let css = window.getComputedStyle(document.body);
                    let subscribed_color = '#635cf1';
                    let unsubscribed_color = css.getPropertyValue('--gray-600');
                    let push_notification_sent_color = '#ea3999';
                    let subscribed_color_gradient = null;
                    let unsubscribed_color_gradient = null;
                    let push_notification_sent_gradient = null;

                    /* Chart */
                    let subscribers_logs_chart_context = document.getElementById('subscribers_logs_chart').getContext('2d');

                    /* Colors */
                    subscribed_color_gradient = subscribers_logs_chart_context.createLinearGradient(0, 0, 0, 250);
                    subscribed_color_gradient.addColorStop(0, set_hex_opacity(subscribed_color, 0.9));
                    subscribed_color_gradient.addColorStop(1, set_hex_opacity(subscribed_color, 0.6));

                    unsubscribed_color_gradient = subscribers_logs_chart_context.createLinearGradient(0, 0, 0, 250);
                    unsubscribed_color_gradient.addColorStop(0, set_hex_opacity(unsubscribed_color, 0.9));
                    unsubscribed_color_gradient.addColorStop(1, set_hex_opacity(unsubscribed_color, 0.6));

                    push_notification_sent_gradient = subscribers_logs_chart_context.createLinearGradient(0, 0, 0, 250);
                    push_notification_sent_gradient.addColorStop(0, set_hex_opacity(push_notification_sent_color, 0.9));
                    push_notification_sent_gradient.addColorStop(1, set_hex_opacity(push_notification_sent_color, 0.6));

                    new Chart(subscribers_logs_chart_context, {
                        type: 'bar',
                        data: {
                            labels: JSON.parse(data.details.subscribers_logs_chart.labels ?? '[]'),
                            datasets: [
                                {
                                    label: <?= json_encode(l('websites.subscribed')) ?>,
                                    data: JSON.parse(data.details.subscribers_logs_chart.subscribed ?? '[]'),
                                    backgroundColor: subscribed_color_gradient,
                                    borderColor: subscribed_color,
                                    fill: true
                                },
                                {
                                    label: <?= json_encode(l('websites.unsubscribed')) ?>,
                                    data: JSON.parse(data.details.subscribers_logs_chart.unsubscribed ?? '[]'),
                                    backgroundColor: unsubscribed_color_gradient,
                                    borderColor: unsubscribed_color,
                                    fill: true
                                },
                                {
                                    label: <?= json_encode(l('campaigns.total_sent_push_notifications')) ?>,
                                    data: JSON.parse(data.details.subscribers_logs_chart.push_notification_sent ?? '[]'),
                                    backgroundColor: push_notification_sent_gradient,
                                    borderColor: push_notification_sent_color,
                                    fill: true
                                }
                            ]
                        },
                        options: chart_options
                    });
                }
            }
        })();
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>





    <?php $dashboard_features = ((array) $this->user->preferences->dashboard) + array_fill_keys(['websites', 'subscribers', 'campaigns'], true) + array_fill_keys(['personal_notifications', 'rss_automations', 'recurring_campaigns', 'flows', 'segments'], false) ?>

    <?php foreach($dashboard_features as $feature => $is_enabled): ?>

        <?php if($is_enabled && $feature == 'websites'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-pager mr-1 text-website"></i> <?= l('dashboard.websites.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('website-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('websites.create') ?></a>
                        <a href="<?= url('websites') ?>" class="btn btn-sm bg-website text-website" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-pager fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->websites)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th><?= l('global.name') ?></th>
                                <th><?= l('websites.subscribers') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 1; ?>
                            <?php foreach($data->websites as $row): ?>
                                <?php if($i > 5) break; $i++ ?>

                                <tr>
                                    <td class="text-nowrap">
                                        <div>
                                            <a href="<?= url('website/' . $row->website_id) ?>"><?= $row->name ?></a>
                                        </div>

                                        <div class="small">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($row->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <span class="text-muted"><?= $row->host . $row->path ?></span>

                                            <a href="<?= 'https://' . $row->host . $row->path ?>" target="_blank" rel="noreferrer"><i class="fas fa-fw fa-xs fa-external-link-alt text-muted ml-1"></i></a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="<?= url('subscribers?website_id=' . $row->website_id) ?>" class="badge text-subscriber bg-subscriber">
                                            <i class="fas fa-fw fa-sm fa-user-check mr-1"></i> <?= nr($row->total_subscribers) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                        <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                                    </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                        <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                                    </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                        <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                                    </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <a href="<?= url('campaigns?website_id=' . $row->website_id) ?>" class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <div>
                                            <?php if($row->is_enabled == 1): ?>
                                                <span class="badge badge-success"><i class="fas fa-fw fa-sm fa-check mr-1"></i> <?= l('global.active') ?></span>
                                            <?php elseif($row->is_enabled == 0): ?>
                                                <span class="badge badge-warning"><i class="fas fa-fw fa-sm fa-eye-slash mr-1"></i> <?= l('global.disabled') ?></span>
                                            <?php endif ?>
                                        </div>
                                    </td>

                                    <td class="text-nowrap text-muted">
                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                    <i class="fas fa-fw fa-calendar text-muted"></i>
                                </span>

                                        <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                    <i class="fas fa-fw fa-history text-muted"></i>
                                </span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/websites/website_dropdown_button.php', ['id' => $row->website_id, 'resource_name' => $row->name, 'host' => $row->host, 'path' => $row->path, 'pixel_key' => $row->pixel_key, 'domain_id' => $row->domain_id, 'domains' => $data->domains]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'websites',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>
            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'subscribers'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-user-check mr-1 text-subscriber"></i> <?= l('dashboard.subscribers.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('subscribers') ?>" class="btn btn-sm bg-subscriber text-subscriber" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-user-check fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->subscribers)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th><?= l('websites.subscriber') ?></th>
                                <th><?= l('global.device') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th><?= l('global.details') ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->subscribers as $row): ?>

                                <tr>
                                    <td class="text-nowrap">
                                        <div>
                                            <a href="<?= url('subscriber/' . $row->subscriber_id) ?>">
                                                <?= $row->ip ?>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                 <span class="badge badge-light">
                                    <?= $row->device_type ? '<i class="fas fa-fw fa-sm fa-' . $row->device_type . ' mr-1"></i>' . l('global.device.' . $row->device_type) : l('global.unknown') ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <span class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                    <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                            <?php if(($row->custom_parameters = json_decode($row->custom_parameters ?? '', true)) && count($row->custom_parameters)): ?>
                                                <?php ob_start() ?>
                                                <div class='d-flex flex-column text-left'>
                                                    <div class='d-flex flex-column my-1'>
                                                        <strong><?= sprintf(l('subscribers.custom_parameters'), count($row->custom_parameters)) ?></strong>
                                                    </div>

                                                    <?php foreach($row->custom_parameters as $key => $value): ?>
                                                        <div class='d-flex flex-column my-1'>
                                                            <div><?= e($key) ?></div>
                                                            <strong><?= e($value) ?></strong>
                                                        </div>
                                                    <?php endforeach ?>
                                                </div>

                                                <?php $tooltip = ob_get_clean() ?>

                                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <i class="fas fa-fw fa-fingerprint text-primary"></i>
                                        </span>
                                            <?php else: ?>
                                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('subscribers.custom_parameters'), 0) ?>">
                                            <i class="fas fa-fw fa-fingerprint text-muted"></i>
                                        </span>
                                            <?php endif ?>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('campaigns.last_sent_datetime') . ($row->last_sent_datetime ? '<br />' . \Altum\Date::get($row->last_sent_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_sent_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_sent_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-rocket text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('subscribers.subscribed_on_url') . '<br />' . $row->subscribed_on_url ?>">
                                        <i class="fas fa-fw fa-link text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" title="<?= get_continent_from_continent_code($row->continent_code ?? l('global.unknown')) ?>">
                                        <i class="fas fa-fw fa-globe-europe text-muted"></i>
                                    </span>

                                            <?php if($row->country_code): ?>
                                                <img src="<?= ASSETS_FULL_URL . 'images/countries/' . mb_strtolower($row->country_code) . '.svg' ?>" class="icon-favicon mr-2" data-toggle="tooltip" title="<?= get_country_from_country_code($row->country_code) ?>" />
                                            <?php else: ?>
                                                <span class="mr-2" data-toggle="tooltip" title="<?= l('global.unknown') ?>">
                                            <i class="fas fa-fw fa-flag text-muted"></i>
                                        </span>
                                            <?php endif ?>

                                            <span class="mr-2" data-toggle="tooltip" title="<?= $row->city_name ?? l('global.unknown') ?>">
                                        <i class="fas fa-fw fa-city text-muted"></i>
                                    </span>

                                            <img src="<?= ASSETS_FULL_URL . 'images/os/' . os_name_to_os_key($row->os_name) . '.svg' ?>" class="img-fluid icon-favicon mr-2" data-toggle="tooltip" title="<?= $row->os_name ?: l('global.unknown') ?>" />

                                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/' . browser_name_to_browser_key($row->browser_name) . '.svg' ?>" class="img-fluid icon-favicon mr-2" data-toggle="tooltip" title="<?= $row->browser_name ?: l('global.unknown') ?>" />
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/subscribers/subscriber_dropdown_button.php', ['id' => $row->subscriber_id, 'resource_name' => $row->ip, 'website_id' => $row->website_id]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'subscribers',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'campaigns'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-rocket mr-1 text-campaign"></i> <?= l('dashboard.campaigns.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('campaign-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('campaigns.create') ?></a>
                        <a href="<?= url('campaigns') ?>" class="btn btn-sm bg-campaign text-campaign" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-rocket fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->campaigns)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th><?= l('campaigns.campaign') ?></th>
                                <th><?= l('campaigns.segment') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th><?= l('global.status') ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->campaigns as $row): ?>

                                <tr>
                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.title') ?></div>
                                                <span>
                                                <?= $row->title ?>
                                            </span>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.description') ?></div>
                                                <span>
                                                <?= $row->description ?>
                                            </span>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.url') ?></div>
                                                <span>
                                                <?= $row->url ? remove_url_protocol_from_url($row->url) : l('global.none') ?>
                                            </span>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <?php if(in_array($row->status, ['draft', 'scheduled'])): ?>
                                            <a href="<?= url('campaign-update/' . $row->campaign_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                                <?= $row->name ?>
                                            </a>
                                        <?php elseif(in_array($row->status, ['processing', 'sent'])): ?>
                                            <a href="<?= url('campaign/' . $row->campaign_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                                <?= $row->name ?>
                                            </a>
                                        <?php endif ?>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if(is_numeric($row->segment)): ?>
                                            <a href="<?= url('segment-update/' . $row->segment) ?>" class="badge badge-light">
                                                <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.saved') ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-light">
                                        <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.' . $row->segment) ?>
                                    </span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <span class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                    <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) . '/' . nr($row->total_push_notifications) ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if($row->status == 'draft'): ?>
                                            <span class="badge badge-light"><i class="fas fa-fw fa-sm fa-save mr-1"></i> <?= l('campaigns.status.draft') ?></span>
                                        <?php elseif($row->status == 'scheduled'): ?>
                                            <span class="badge badge-gray-300" data-toggle="tooltip" title="<?= \Altum\Date::get_time_until($row->scheduled_datetime) ?>"><i class="fas fa-fw fa-sm fa-calendar-day mr-1"></i> <?= l('campaigns.status.scheduled') ?></span>
                                        <?php elseif($row->status == 'processing'): ?>
                                            <span class="badge badge-warning"><i class="fas fa-fw fa-sm fa-spinner fa-spin mr-1"></i> <?= l('campaigns.status.processing') ?></span>
                                        <?php elseif($row->status == 'sent'): ?>
                                            <span class="badge badge-success"><i class="fas fa-fw fa-sm fa-check mr-1"></i> <?= l('campaigns.status.sent') ?></span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('campaigns.scheduled_datetime') . ($row->scheduled_datetime && $row->settings->is_scheduled ? '<br />' . \Altum\Date::get($row->scheduled_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->scheduled_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->scheduled_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-day text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('campaigns.last_sent_datetime') . ($row->last_sent_datetime ? '<br />' . \Altum\Date::get($row->last_sent_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_sent_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_sent_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-rocket text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/campaigns/campaign_dropdown_button.php', ['id' => $row->campaign_id, 'resource_name' => $row->name,]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'campaigns',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'personal_notifications'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-code-branch mr-1 text-campaign"></i> <?= l('dashboard.personal_notifications.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('personal-notification-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('personal_notifications.create') ?></a>
                        <a href="<?= url('personal-notifications') ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-code-branch fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->personal_notifications)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th data-bulk-table class="d-none">
                                    <div class="custom-control custom-checkbox">
                                        <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                        <label class="custom-control-label" for="bulk_select_all"></label>
                                    </div>
                                </th>
                                <th><?= l('personal_notifications.personal_notification') ?></th>
                                <th><?= l('websites.subscriber') ?></th>
                                <th><?= l('global.status') ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->personal_notifications as $row): ?>

                                <tr>
                                    <td data-bulk-table class="d-none">
                                        <div class="custom-control custom-checkbox">
                                            <input id="selected_personal_notification_id_<?= $row->personal_notification_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->personal_notification_id ?>" />
                                            <label class="custom-control-label" for="selected_personal_notification_id_<?= $row->personal_notification_id ?>"></label>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.title') ?></div>
                                                <span>
                                                <?= $row->title ?>
                                            </span>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.description') ?></div>
                                                <span>
                                                <?= $row->description ?>
                                            </span>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div class='font-weight-bold'><?= l('global.url') ?></div>
                                                <span>
                                                <?= $row->url ? remove_url_protocol_from_url($row->url) : l('global.none') ?>
                                            </span>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <a href="<?= url('personal-notification-update/' . $row->personal_notification_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <?= $row->name ?>
                                        </a>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="<?= url('subscriber/' . $row->subscriber_id) ?>">
                                            <?= $row->ip ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if($row->status == 'draft'): ?>
                                            <span class="badge badge-light"><i class="fas fa-fw fa-sm fa-save mr-1"></i> <?= l('campaigns.status.draft') ?></span>
                                        <?php elseif($row->status == 'scheduled'): ?>
                                            <span class="badge badge-gray-300" data-toggle="tooltip" title="<?= \Altum\Date::get_time_until($row->scheduled_datetime) ?>"><i class="fas fa-fw fa-sm fa-calendar-day mr-1"></i> <?= l('campaigns.status.scheduled') ?></span>
                                        <?php elseif($row->status == 'processing'): ?>
                                            <span class="badge badge-warning"><i class="fas fa-fw fa-sm fa-spinner fa-spin mr-1"></i> <?= l('campaigns.status.processing') ?></span>
                                        <?php elseif($row->status == 'sent'): ?>
                                            <?php ob_start() ?>
                                            <div class='d-flex flex-column text-left'>
                                                <div class='d-flex flex-column my-1'>
                                                    <div><?= l('subscribers.displayed_notification') ?></div>
                                                    <strong>
                                                        <?= $row->is_displayed ? l('global.yes') : l('global.no') ?>
                                                    </strong>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div><?= l('subscribers.clicked_notification') ?></div>
                                                    <strong>
                                                        <?= $row->is_clicked ? l('global.yes') : l('global.no') ?>
                                                    </strong>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div><?= l('subscribers.closed_notification') ?></div>
                                                    <strong>
                                                        <?= $row->is_closed ? l('global.yes') : l('global.no') ?>
                                                    </strong>
                                                </div>
                                            </div>
                                            <?php $tooltip = ob_get_clean(); ?>

                                            <span class="badge badge-success" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>"><i class="fas fa-fw fa-sm fa-check mr-1"></i> <?= l('campaigns.status.sent') ?></span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('campaigns.scheduled_datetime') . ($row->scheduled_datetime && $row->settings->is_scheduled ? '<br />' . \Altum\Date::get($row->scheduled_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->scheduled_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->scheduled_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-day text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('personal_notifications.sent_datetime') . ($row->sent_datetime ? '<br />' . \Altum\Date::get($row->sent_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->sent_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->sent_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-rocket text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/personal-notifications/personal_notification_dropdown_button.php', ['id' => $row->personal_notification_id, 'resource_name' => $row->name]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'personal_notifications',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'rss_automations'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-feed mr-1 text-campaign"></i> <?= l('dashboard.rss_automations.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('rss-automation-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('rss_automations.create') ?></a>
                        <a href="<?= url('rss-automations') ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-feed fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->rss_automations)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th data-bulk-table class="d-none">
                                    <div class="custom-control custom-checkbox">
                                        <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                        <label class="custom-control-label" for="bulk_select_all"></label>
                                    </div>
                                </th>
                                <th><?= l('rss_automations.rss_automation') ?></th>
                                <th><?= l('campaigns.segment') ?></th>
                                <th><?= l('rss_automations.total_campaigns') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->rss_automations as $row): ?>

                                <tr>
                                    <td data-bulk-table class="d-none">
                                        <div class="custom-control custom-checkbox">
                                            <input id="selected_rss_automation_id_<?= $row->rss_automation_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->rss_automation_id ?>" />
                                            <label class="custom-control-label" for="selected_rss_automation_id_<?= $row->rss_automation_id ?>"></label>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <div>
                                            <?php ob_start() ?>
                                            <div class='d-flex flex-column text-left'>
                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.title') ?></div>
                                                    <span>
                                                <?= $row->title ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.description') ?></div>
                                                    <span>
                                                <?= $row->description ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.url') ?></div>
                                                    <span>
                                                <?= $row->url ? remove_url_protocol_from_url($row->url) : l('global.none') ?>
                                            </span>
                                                </div>
                                            </div>
                                            <?php $tooltip = ob_get_clean(); ?>

                                            <a href="<?= url('rss-automation/' . $row->rss_automation_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                                <?= $row->name ?>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if(is_numeric($row->segment)): ?>
                                            <a href="<?= url('segment-update/' . $row->segment) ?>" class="badge badge-light">
                                                <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.saved') ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-light">
                                        <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.' . $row->segment) ?>
                                    </span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="<?= url('campaigns?rss_automation_id=' . $row->rss_automation_id) ?>" class="badge bg-campaign text-campaign">
                                            <i class="fas fa-fw fa-sm fa-rocket mr-1"></i> <?= nr($row->total_campaigns) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <a href="<?= url('subscribers-logs?rss_automation_id=' . $row->rss_automation_id) ?>" class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if($row->is_enabled): ?>
                                            <span class="badge badge-success" data-toggle="tooltip" title="<?= l('global.active') ?>"><i class="fas fa-fw fa-check"></i></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning" data-toggle="tooltip" title="<?= l('global.disabled') ?>"><i class="fas fa-fw fa-pause"></i></span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('rss_automations.last_check_datetime') . ($row->last_check_datetime ? '<br />' . \Altum\Date::get($row->last_check_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_check_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_check_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-check text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('rss_automations.next_check_datetime') . ($row->next_check_datetime ? '<br />' . \Altum\Date::get($row->next_check_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->next_check_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_time_until($row->next_check_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-day text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/rss-automations/rss_automation_dropdown_button.php', ['id' => $row->rss_automation_id, 'resource_name' => $row->name]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'rss_automations',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'recurring_campaigns'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-retweet mr-1"></i> <?= l('dashboard.recurring_campaigns.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('recurring-campaign-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('recurring_campaigns.create') ?></a>
                        <a href="<?= url('recurring-campaigns') ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-retweet fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->recurring_campaigns)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th data-bulk-table class="d-none">
                                    <div class="custom-control custom-checkbox">
                                        <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                        <label class="custom-control-label" for="bulk_select_all"></label>
                                    </div>
                                </th>
                                <th><?= l('recurring_campaigns.recurring_campaign') ?></th>
                                <th><?= l('campaigns.segment') ?></th>
                                <th><?= l('recurring_campaigns.total_campaigns') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->recurring_campaigns as $row): ?>

                                <tr>
                                    <td data-bulk-table class="d-none">
                                        <div class="custom-control custom-checkbox">
                                            <input id="selected_recurring_campaign_id_<?= $row->recurring_campaign_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->recurring_campaign_id ?>" />
                                            <label class="custom-control-label" for="selected_recurring_campaign_id_<?= $row->recurring_campaign_id ?>"></label>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <div>
                                            <?php ob_start() ?>
                                            <div class='d-flex flex-column text-left'>
                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.title') ?></div>
                                                    <span>
                                                <?= $row->title ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.description') ?></div>
                                                    <span>
                                                <?= $row->description ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.url') ?></div>
                                                    <span>
                                                <?= $row->url ? remove_url_protocol_from_url($row->url) : l('global.none') ?>
                                            </span>
                                                </div>
                                            </div>
                                            <?php $tooltip = ob_get_clean(); ?>

                                            <a href="<?= url('recurring-campaign/' . $row->recurring_campaign_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                                <?= $row->name ?>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if(is_numeric($row->segment)): ?>
                                            <a href="<?= url('segment-update/' . $row->segment) ?>" class="badge badge-light">
                                                <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.saved') ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-light">
                                        <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.' . $row->segment) ?>
                                    </span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="<?= url('campaigns?recurring_campaign_id=' . $row->recurring_campaign_id) ?>" class="badge bg-campaign text-campaign">
                                            <i class="fas fa-fw fa-sm fa-rocket mr-1"></i> <?= nr($row->total_campaigns) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <a href="<?= url('subscribers-logs?recurring_campaign_id=' . $row->recurring_campaign_id) ?>" class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if($row->is_enabled): ?>
                                            <span class="badge badge-success" data-toggle="tooltip" title="<?= l('global.active') ?>"><i class="fas fa-fw fa-check"></i></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning" data-toggle="tooltip" title="<?= l('global.disabled') ?>"><i class="fas fa-fw fa-pause"></i></span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('recurring_campaigns.last_run_datetime') . ($row->last_run_datetime ? '<br />' . \Altum\Date::get($row->last_run_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_run_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_run_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-check text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('recurring_campaigns.next_run_datetime') . ($row->next_run_datetime ? '<br />' . \Altum\Date::get($row->next_run_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->next_run_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_time_until($row->next_run_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-calendar-day text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/recurring-campaigns/recurring_campaign_dropdown_button.php', ['id' => $row->recurring_campaign_id, 'resource_name' => $row->name]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'recurring_campaigns',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'flows'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-tasks mr-1"></i> <?= l('dashboard.flows.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('flow-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('flows.create') ?></a>
                        <a href="<?= url('flows') ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-tasks fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->flows)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th data-bulk-table class="d-none">
                                    <div class="custom-control custom-checkbox">
                                        <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                        <label class="custom-control-label" for="bulk_select_all"></label>
                                    </div>
                                </th>
                                <th><?= l('flows.flow') ?></th>
                                <th><?= l('campaigns.segment') ?></th>
                                <th><?= l('flows.wait_time') ?></th>
                                <th><?= l('campaigns.notifications') ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->flows as $row): ?>

                                <tr>
                                    <td data-bulk-table class="d-none">
                                        <div class="custom-control custom-checkbox">
                                            <input id="selected_flow_id_<?= $row->flow_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->flow_id ?>" />
                                            <label class="custom-control-label" for="selected_flow_id_<?= $row->flow_id ?>"></label>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <div>
                                            <?php ob_start() ?>
                                            <div class='d-flex flex-column text-left'>
                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.title') ?></div>
                                                    <span>
                                                <?= $row->title ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.description') ?></div>
                                                    <span>
                                                <?= $row->description ?>
                                            </span>
                                                </div>

                                                <div class='d-flex flex-column my-1'>
                                                    <div class='font-weight-bold'><?= l('global.url') ?></div>
                                                    <span>
                                                <?= $row->url ? remove_url_protocol_from_url($row->url) : l('global.none') ?>
                                            </span>
                                                </div>
                                            </div>
                                            <?php $tooltip = ob_get_clean(); ?>

                                            <a href="<?= url('flow/' . $row->flow_id) ?>" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                                <?= $row->name ?>
                                            </a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if(is_numeric($row->segment)): ?>
                                            <a href="<?= url('segment-update/' . $row->segment) ?>" class="badge badge-light">
                                                <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.saved') ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-light">
                                        <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('campaigns.segment.' . $row->segment) ?>
                                    </span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                <span class="badge badge-light">
                                    <i class="fas fa-fw fa-sm fa-hourglass mr-1"></i> <?= $row->wait_time . ' ' . l('global.date.' . $row->wait_time_type) ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php ob_start() ?>
                                        <div class='d-flex flex-column text-left'>
                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_displayed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_displayed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_displayed_push_notifications, $row->total_sent_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_clicked_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_clicked_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_clicked_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>

                                            <div class='d-flex flex-column my-1'>
                                                <div><?= l('campaigns.total_closed_push_notifications') ?></div>
                                                <strong>
                                                    <?= nr($row->total_closed_push_notifications) . '/' . nr($row->total_sent_push_notifications) ?>

                                                    <span class='text-muted'>
                                                <?= ' (' . nr(get_percentage_between_two_numbers($row->total_closed_push_notifications, $row->total_displayed_push_notifications)) . '%' . ')' ?>
                                            </span>
                                                </strong>
                                            </div>
                                        </div>
                                        <?php $tooltip = ob_get_clean(); ?>

                                        <a href="<?= url('subscribers-logs?flow_id=' . $row->flow_id) ?>" class="badge text-notification bg-notification" data-toggle="tooltip" data-html="true" title="<?= $tooltip ?>">
                                            <i class="fas fa-fw fa-sm fa-fire mr-1"></i> <?= nr($row->total_sent_push_notifications) ?>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <?php if($row->is_enabled): ?>
                                            <span class="badge badge-success" data-toggle="tooltip" title="<?= l('global.active') ?>"><i class="fas fa-fw fa-check"></i></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning" data-toggle="tooltip" title="<?= l('global.disabled') ?>"><i class="fas fa-fw fa-pause"></i></span>
                                        <?php endif ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= l('campaigns.last_sent_datetime') . ($row->last_sent_datetime ? '<br />' . \Altum\Date::get($row->last_sent_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_sent_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_sent_datetime) . ')</small>' : '<br />' . l('global.na')) ?>">
                                        <i class="fas fa-fw fa-rocket text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/flows/flow_dropdown_button.php', ['id' => $row->flow_id, 'resource_name' => $row->name]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'flows',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>

        <?php if($is_enabled && $feature == 'segments'): ?>
            <div class="mt-4 mb-5">
                <div class="d-flex align-items-center mb-3">
                    <h2 class="small font-weight-bold text-uppercase text-muted mb-0 mr-3"><i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('dashboard.segments.header') ?></h2>

                    <div class="flex-fill">
                        <hr class="border-gray-100" />
                    </div>

                    <div class="ml-3">
                        <a href="<?= url('segment-create') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-fw fa-plus-circle fa-sm mr-1"></i> <?= l('segments.create') ?></a>
                        <a href="<?= url('segments') ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="<?= l('global.view_all') ?>"><i class="fas fa-fw fa-layer-group fa-sm"></i></a>
                    </div>
                </div>

                <?php if (!empty($data->segments)): ?>
                    <div class="table-responsive table-custom-container">
                        <table class="table table-custom">
                            <thead>
                            <tr>
                                <th data-bulk-table class="d-none">
                                    <div class="custom-control custom-checkbox">
                                        <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                        <label class="custom-control-label" for="bulk_select_all"></label>
                                    </div>
                                </th>
                                <th><?= l('segments.segment') ?></th>
                                <th><?= l('global.type') ?></th>
                                <th colspan="2"><?= l('websites.total_subscribers') ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach($data->segments as $row): ?>

                                <tr>
                                    <td data-bulk-table class="d-none">
                                        <div class="custom-control custom-checkbox">
                                            <input id="selected_segment_id_<?= $row->segment_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->segment_id ?>" />
                                            <label class="custom-control-label" for="selected_segment_id_<?= $row->segment_id ?>"></label>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                        <div>
                                            <a href="<?= url('segment-update/' . $row->segment_id) ?>"><?= $row->name ?></a>
                                        </div>

                                        <div class="d-flex align-items-center">
                                            <img referrerpolicy="no-referrer" src="<?= get_favicon_url_from_domain($data->websites[$row->website_id]->host) ?>" class="img-fluid icon-favicon-small mr-1" loading="lazy" />

                                            <a href="<?= url('website/' . $row->website_id) ?>" class="small text-muted" data-toggle="tooltip" title="<?= $data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path ?>">
                                                <?= string_truncate($data->websites[$row->website_id]->host . $data->websites[$row->website_id]->path, 32) ?>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="text-nowrap">
                                <span class="badge badge-light">
                                    <i class="fas fa-fw fa-sm fa-layer-group mr-1"></i> <?= l('segments.type.' . $row->type) ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap">
                                <span class="badge text-subscriber bg-subscriber">
                                    <i class="fas fa-fw fa-sm fa-user-check mr-1"></i> <?= nr($row->total_subscribers) ?>
                                </span>
                                    </td>

                                    <td class="text-nowrap text-muted">
                                        <a href="<?= url('campaigns?segment=' . $row->segment_id) ?>" class="mr-2" data-toggle="tooltip" title="<?= l('campaigns.title') ?>">
                                            <i class="fas fa-fw fa-rocket text-muted"></i>
                                        </a>

                                        <a href="<?= url('flows?segment=' . $row->segment_id) ?>" class="mr-2" data-toggle="tooltip" title="<?= l('flows.title') ?>">
                                            <i class="fas fa-fw fa-tasks text-muted"></i>
                                        </a>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="d-flex align-items-center">
                                    <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                        <i class="fas fa-fw fa-clock text-muted"></i>
                                    </span>

                                            <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.last_datetime_tooltip'), ($row->last_datetime ? '<br />' . \Altum\Date::get($row->last_datetime, 2) . '<br /><small>' . \Altum\Date::get($row->last_datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->last_datetime) . ')</small>' : '<br />' . l('global.na'))) ?>">
                                        <i class="fas fa-fw fa-history text-muted"></i>
                                    </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <?= include_view(THEME_PATH . 'views/segments/segment_dropdown_button.php', ['id' => $row->segment_id, 'resource_name' => $row->name,]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
                        'filters_get' => $data->filters->get ?? [],
                        'name' => 'segments',
                        'has_secondary_text' => true,
                    ]); ?>

                <?php endif ?>

            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>
