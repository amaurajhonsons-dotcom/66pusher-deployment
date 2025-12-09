<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <?= $this->views['account_header_menu'] ?>

    <div class="row mb-3">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><?= l('account_api.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('account_api.subheader') ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-lg-auto d-flex flex-wrap gap-3 d-print-none">
            <a href="<?= url('api-documentation') ?>" class="btn btn-primary"><i class="fas fa-fw fa-book fa-sm mr-1"></i> <?= l('api_documentation.menu') ?></a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <div <?= $this->user->plan_settings->api_is_enabled ? null : get_plan_feature_disabled_info() ?>>
                    <div class="form-group <?= $this->user->plan_settings->api_is_enabled ? null : 'container-disabled' ?>">
                        <label for="api_key"><i class="fas fa-fw fa-sm fa-code text-muted mr-1"></i> <?= l('account_api.api_key') ?></label>
                        <div class="input-group">
                            <?php
                            //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) $this->user->api_key = 'hidden on demo';
                            ?>

                            <input type="text" id="api_key" name="api_key" value="<?= $this->user->api_key ?>" class="form-control" onclick="this.select();" readonly="readonly" />
                            <div class="input-group-append">
                                <button
                                        id="url_copy"
                                        type="button"
                                        class="btn btn-light border border-left-0"
                                        data-toggle="tooltip"
                                        title="<?= l('global.clipboard_copy') ?>"
                                        aria-label="<?= l('global.clipboard_copy') ?>"
                                        data-copy="<?= l('global.clipboard_copy') ?>"
                                        data-copied="<?= l('global.clipboard_copied') ?>"
                                        data-clipboard-text="<?= $this->user->api_key ?>"
                                >
                                    <i class="fas fa-fw fa-sm fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-outline-secondary" <?= $this->user->plan_settings->api_is_enabled ? null : get_plan_feature_disabled_info() ?>><?= l('account_api.button') ?></button>
            </form>

        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/user') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-user text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('api_documentation.user') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/websites') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-pager text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('websites.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/subscribers') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-user-check text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('subscribers.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/subscribers-statistics') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-chart-bar text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('subscribers_statistics.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/subscribers-logs') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-stream text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('subscribers_logs.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/campaigns') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-rocket text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('campaigns.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/personal-notifications') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-code-branch text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('personal_notifications.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/rss-automations') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-rss text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('rss_automations.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/recurring-campaigns') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-retweet text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('recurring_campaigns.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/flows') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-tasks text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('flows.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/segments') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-layer-group text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('segments.title') ?>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/notification-handlers') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-bell text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('api_documentation.notification_handlers') ?>
                </div>
            </div>
        </div>

        <?php if(settings()->websites->domains_is_enabled): ?>
            <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('api-documentation/domains') ?>" class="stretched-link">
                            <i class="fas fa-fw fa-globe text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body d-flex align-items-center">
                        <?= l('domains.title') ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if(\Altum\Plugin::is_active('teams')): ?>
            <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('api-documentation/teams') ?>" class="stretched-link">
                            <i class="fas fa-fw fa-user-cog text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <?= l('teams.title') ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('api-documentation/team-members') ?>" class="stretched-link">
                            <i class="fas fa-fw fa-users-cog text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <?= l('api_documentation.team_members') ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
                <div class="card d-flex flex-row h-100 overflow-hidden">
                    <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                        <a href="<?= url('api-documentation/teams-member') ?>" class="stretched-link">
                            <i class="fas fa-fw fa-user-tag text-primary-600"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <?= l('api_documentation.teams_member') ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <?php if(settings()->payment->is_enabled): ?>
        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/payments') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-credit-card text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('account_payments.title') ?>
                </div>
            </div>
        </div>
        <?php endif ?>

        <div class="col-12 col-sm-6 col-xl-4 p-3 position-relative">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="border-right border-gray-100 px-3 d-flex flex-column justify-content-center">
                    <a href="<?= url('api-documentation/users-logs') ?>" class="stretched-link">
                        <i class="fas fa-fw fa-scroll text-primary-600"></i>
                    </a>
                </div>

                <div class="card-body d-flex align-items-center">
                    <?= l('account_logs.title') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_view(THEME_PATH . 'views/partials/clipboard_js.php') ?>
