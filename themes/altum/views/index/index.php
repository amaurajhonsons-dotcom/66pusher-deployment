<?php defined('ALTUMCODE') || die() ?>

<div class="index-background py-7">
    <div class="container">
        <?= \Altum\Alerts::output_alerts() ?>

        <div class="row justify-content-center">
            <div class="col-11 col-md-10 col-lg-7">
                <div class="text-center mb-2">
                    <span class="badge badge-primary badge-pill"><i class="fas fa-fw fa-sm fa-check-circle mr-1"></i> <?= l('index.subheader2') ?></span>
                </div>

                <h1 class="index-header text-center mb-2"><?= l('index.header') ?></h1>
            </div>

            <div class="col-10 col-sm-8 col-lg-6">
                <p class="index-subheader text-center mb-5"><?= sprintf(l('index.subheader'), nr($data->total_sent_push_notifications)) ?></p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 col-sm-8 col-lg-6">
                <div class="d-flex flex-column flex-lg-row justify-content-center">
                    <?php if(settings()->users->register_is_enabled): ?>
                        <a href="<?= url('register') ?>" class="btn btn-primary index-button mb-3 mb-lg-0">
                            <?= l('index.register') ?> <i class="fas fa-fw fa-sm fa-arrow-right"></i>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center mt-7" data-aos="fade-up">
        <div class="col-12">
            <img src="<?= get_custom_image_if_any('index/hero.webp') ?>" class="img-fluid shadow-lg rounded-2x zoom-animation-subtle inverse-colors-animation" loading="lazy" alt="<?= l('index.hero_image_alt') ?>" />
        </div>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-4 p-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card bg-gray-50 mb-md-0 h-100 up-animation">
                <div class="card-body icon-zoom-animation">
                    <div class="index-icon-container mb-3">
                        <i class="fas fa-fw fa-tools"></i>
                    </div>

                    <h2 class="h6 m-0"><?= l('index.steps.one') ?></h2>

                    <small class="text-muted m-0"><?= l('index.steps.one_text') ?></small>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 p-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card bg-gray-50 mb-md-0 h-100 up-animation">
                <div class="card-body icon-zoom-animation">
                    <div class="index-icon-container mb-3">
                        <i class="fas fa-fw fa-shield-alt"></i>
                    </div>

                    <h2 class="h6 m-0"><?= l('index.steps.two') ?></h2>

                    <small class="text-muted m-0"><?= l('index.steps.two_text') ?></small>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 p-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card bg-gray-50 mb-md-0 h-100 up-animation">
                <div class="card-body icon-zoom-animation">
                    <div class="index-icon-container mb-3">
                        <i class="fas fa-fw fa-user-shield"></i>
                    </div>

                    <h2 class="h6 m-0"><?= l('index.steps.three') ?></h2>

                    <small class="text-muted m-0"><?= l('index.steps.three_text') ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="container">
    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/push_notifications.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.notification_example_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.push_notifications.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.push_notifications.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.push_notifications.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.push_notifications.image') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.push_notifications.url') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.push_notifications.buttons') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.push_notifications.dynamic') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.push_notifications.others') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/subscribers.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.subscribers_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.subscribers.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.subscribers.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.subscribers.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.subscribers.location') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.subscribers.platforms') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.subscribers.referrer') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.subscribers.statistics') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.subscribers.logs') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/campaigns.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.campaigns_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.campaigns.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.campaigns.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.campaigns.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.campaigns.spintax') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.campaigns.custom_parameters') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.campaigns.segments') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.campaigns.statistics') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/flows.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.flows_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.flows.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.flows.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.flows.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.flows.one') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.flows.two') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.flows.three') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.flows.four') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/segments.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.segments_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.segments.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.segments.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.segments.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.custom') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.region') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.device') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.os') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.browsers') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.segments.languages') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/rss_automations.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.rss_automations_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.rss_automations.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.rss_automations.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.rss_automations.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.rss_automations.one') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.rss_automations.two') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.rss_automations.three') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.rss_automations.four') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/recurring_campaigns.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.recurring_campaigns_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.recurring_campaigns.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.recurring_campaigns.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.recurring_campaigns.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.recurring_campaigns.one') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.recurring_campaigns.two') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.recurring_campaigns.three') ?></div>
            </div>
        </div>
    </div>

    <div class="my-6">&nbsp;</div>

    <div class="row justify-content-between" data-aos="fade-up">
        <div class="col-12 col-md-5 text-center mb-5 mb-md-0" >
            <img src="<?= get_custom_image_if_any('index/pwas.webp') ?>" class="img-fluid rounded-2x" loading="lazy" alt="<?= l('index.recurring_campaigns_image_alt') ?>" />
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-center">
            <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.pwas.name') ?></div>

            <div>
                <h2 class="mb-4"><?= l('index.pwas.header') ?></h2>

                <p class="text-muted mb-4"><?= l('index.pwas.subheader') ?></p>

                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.pwas.one') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.pwas.two') ?></div>
                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('index.pwas.three') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="p-4">
    <div class="py-6 rounded-2x bg-gray-100">
        <div class="container">
            <div class="text-center">
                <h2 class="h4"><?= l('index.browsers.header') ?> <i class="fas fa-fw fa-xs fa-circle-check text-success ml-1"></i> </h2>
                <p class="text-muted mb-0"><?= l('index.browsers.subheader') ?></p>
            </div>

            <div class="mt-5 d-flex justify-content-center align-items-center flex-wrap">
                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/apple.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="MacOs, iOS & iPadOS" alt="MacOs, iOS & iPadOS" />
                </div>

                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/android.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="Android" alt="Android" />
                </div>

                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/windows.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="Windows" alt="Windows" />
                </div>

                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/ubuntu.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="Ubuntu" alt="Ubuntu" />
                </div>

                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/chromeos.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="ChromeOS" alt="ChromeOS" />
                </div>

                <div class="p-3">
                    <img src="<?= ASSETS_FULL_URL . 'images/os/linux.svg' ?>" class="index-os-icon" loading="lazy" data-toggle="tooltip" title="Linux" alt="Linux" />
                </div>
            </div>

            <div class="mt-3 row justify-content-around">
                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/chrome.svg' ?>" class="index-browser-icon" loading="lazy" alt="Chrome" />

                            <div class="h6 mt-3 mb-0 text-center">Chrome</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/safari.svg' ?>" class="index-browser-icon" loading="lazy" alt="Safari" />

                            <div class="h6 mt-3 mb-0 text-center">Safari</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/edge.svg' ?>" class="index-browser-icon" loading="lazy" alt="Edge" />

                            <div class="h6 mt-3 mb-0 text-center">Edge</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/firefox.svg' ?>" class="index-browser-icon" loading="lazy" alt="Firefox" />

                            <div class="h6 mt-3 mb-0 text-center">Firefox</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/samsung.svg' ?>" class="index-browser-icon" loading="lazy" alt="Samsung Internet" />

                            <div class="h6 mt-3 mb-0 text-center">Samsung Internet</div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4 p-3">
                    <div class="card h-100 zoom-animation-subtle border-0">
                        <div class="card-body d-flex flex-column align-items-center">
                            <img src="<?= ASSETS_FULL_URL . 'images/browsers/opera.svg' ?>" class="index-browser-icon" loading="lazy" alt="Opera" />

                            <div class="h6 mt-3 mb-0 text-center">Opera</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="<?= url('help/platforms-browsers-support') ?>" class="small text-muted text-decoration-none">
                    <?= l('global.view_all') ?> <i class="fas fa-fw fa-xs fa-chevron-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="container">
    <div class="row m-n4">
        <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
            <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="100">
                <img src="<?= get_custom_image_if_any('index/widget.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.widget_image_alt') ?>" />

                <div>
                    <div class="mb-2">
                        <span class="h5"><?= l('index.widget.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.widget.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
            <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="200">
                <img src="<?= get_custom_image_if_any('index/button.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.button_image_alt') ?>" />

                <div>
                    <div class="mb-2">
                        <span class="h5"><?= l('index.button.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.button.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
            <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="300">
                <img src="<?= get_custom_image_if_any('index/customizability.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.advanced_image_alt') ?>" />

                <div>
                    <div class="mb-2">
                        <span class="h5"><?= l('index.customizability.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.customizability.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
            <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="400">
                <img src="<?= get_custom_image_if_any('index/export.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.export_image_alt') ?>" />

                <div>
                    <div class="mb-2">
                        <span class="h5"><?= l('index.export.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.export.subheader') ?></span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
            <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="500">
                <img src="<?= get_custom_image_if_any('index/custom_parameters.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.custom_parameters_image_alt') ?>" />

                <div>
                    <div class="mb-2">
                        <span class="h5"><?= l('index.custom_parameters.header') ?></span>
                    </div>
                    <span class="text-muted"><?= l('index.custom_parameters.subheader') ?></span>
                </div>
            </div>
        </div>

        <?php if(settings()->websites->domains_is_enabled): ?>
            <div class="col-12 col-md-6 col-lg-4 p-4 up-animation">
                <div class="d-flex flex-column justify-content-between h-100" data-aos="fade-up" data-aos-delay="600">
                    <img src="<?= get_custom_image_if_any('index/domains.webp') ?>" class="img-fluid rounded-2x mb-4" loading="lazy" alt="<?= l('index.domains_image_alt') ?>" />

                    <div>
                        <div class="mb-2">
                            <span class="h5"><?= l('index.domains.header') ?></span>
                        </div>
                        <span class="text-muted"><?= l('index.domains.subheader') ?></span>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="p-4">
    <div class="card rounded-2x index-stats-card">
        <div class="card-body py-5 py-lg-6 text-center">
            <span class="h3"><?= sprintf(l('index.stats'), nr($data->total_websites, 0, true, true), nr($data->total_subscribers, 0, true, true)) ?></span>
        </div>
    </div>
</div>

<div class="my-6">&nbsp;</div>

<div class="container">
    <div class="text-center mb-4">
        <h2><?= l('index.notifications_handlers.header') ?> <i class="fas fa-fw fa-xs fa-bell ml-1"></i> </h2>
        <p class="text-muted"><?= l('index.notifications_handlers.subheader') ?></p>
    </div>

    <div class="row mx-n4">
        <?php $notification_handlers = require APP_PATH . 'includes/notification_handlers.php' ?>
        <?php $i = 0; ?>
        <?php foreach($notification_handlers as $key => $notification_handler): ?>
            <div class="col-6 col-lg-4 p-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="position-relative w-100 h-100 icon-zoom-animation">
                    <div class="position-absolute rounded-2x w-100 h-100" style="background: <?= $notification_handler['color'] ?>;opacity: 0.05;"></div>

                    <div class="rounded-2x w-100 p-4 text-truncate text-center">
                        <div><i class="<?= $notification_handler['icon'] ?> fa-fw fa-xl mx-1" style="color: <?= $notification_handler['color'] ?>"></i></div>

                        <div class="mt-3 mb-0 h6 text-truncate"><?= l('notification_handlers.type_' . $key) ?></div>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
</div>

<?php if(settings()->main->api_is_enabled): ?>
    <div class="py-6"></div>

    <div class="container">
        <div class="row align-items-center justify-content-between" data-aos="fade-up">
            <div class="col-12 col-lg-5 mb-5 mb-lg-0 d-flex flex-column justify-content-center">
                <div class="text-uppercase font-weight-bold text-primary mb-3"><?= l('index.api.name') ?></div>

                <div>
                    <h2 class="mb-2"><?= l('index.api.header') ?></h2>
                    <p class="text-muted mb-4"><?= l('index.api.subheader') ?></p>

                    <div class="position-relative">
                        <div class="index-fade"></div>
                        <div class="row">
                            <div class="col">
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('websites.title') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('subscribers.title') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('api_documentation.subscribers_statistics') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('campaigns.title') ?></div>
                            </div>

                            <div class="col">
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('personal_notifications.title') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('flows.title') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('segments.title') ?></div>
                                <div class="small mb-2"><i class="fas fa-fw fa-check-circle text-success mr-1"></i> <?= l('notification_handlers.title') ?></div>
                            </div>
                        </div>
                    </div>

                    <a href="<?= url('api-documentation') ?>" class="btn btn-block btn-outline-primary mt-5">
                        <?= l('api_documentation.menu') ?> <i class="fas fa-fw fa-xs fa-code ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card rounded-2x bg-dark text-white">
                    <div class="card-body p-4 text-monospace reveal-effect font-size-small" style="line-height: 1.75">
                        curl --request POST \<br />
                        --url '<?= SITE_URL ?>api/personal-notifications' \<br />
                        --header 'Authorization: Bearer <span class="text-primary" <?= is_logged_in() ? 'data-toggle="tooltip" title="' . l('api_documentation.api_key') . '"' : null ?>><?= is_logged_in() ? $this->user->api_key : '{api_key}' ?></span>' \<br />
                        --header 'Content-Type: multipart/form-data' \<br />
                        --form 'name=<span class="text-primary">Example name</span>' \<br />
                        --form 'website_id=<span class="text-primary">1</span>' \<br />
                        --form 'subscriber_id=<span class="text-primary">1</span>' \<br />
                        --form 'title=<span class="text-primary">Example title</span>' \<br />
                        --form 'description=<span class="text-primary">Example description</span>' \<br />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* hide until words are wrapped to avoid flash */
        .reveal-effect { visibility: hidden; }

        /* base state for each word */
        .reveal-effect-prepared .reveal-effect-word {
            opacity: 0;
            filter: blur(6px);
            transform: translate3d(0, 8px, 0);
            display: inline-block;
            transition: opacity .5s ease, filter .5s ease, transform .5s ease;
        }

        /* animate in when container gets .reveal-effect-in */
        .reveal-effect-prepared.reveal-effect-in .reveal-effect-word {
            opacity: 1;
            filter: blur(0);
            transform: none;
        }
    </style>

    <script defer>
        /* wrap words in a text node while preserving existing HTML */
        const wrap_words_in_text_node = (text_node) => {
            /* split into words + spaces, keep spacing intact */
            const tokens = text_node.textContent.split(/(\s+)/);
            const fragment = document.createDocumentFragment();

            tokens.forEach((token) => {
                if (token.trim().length === 0) {
                    fragment.appendChild(document.createTextNode(token));
                } else {
                    const span_node = document.createElement('span');
                    span_node.className = 'reveal-effect-word';
                    span_node.textContent = token;
                    fragment.appendChild(span_node);
                }
            });

            text_node.parentNode.replaceChild(fragment, text_node);
        };

        /* prepare a container: wrap only pure text nodes, not tags */
        const prepare_reveal_container = (container_node) => {
            /* collect first to avoid live-walking issues while replacing */
            const walker = document.createTreeWalker(
                container_node,
                NodeFilter.SHOW_TEXT,
                { acceptNode: (node) => node.textContent.trim().length ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT }
            );
            const text_nodes = [];
            while (walker.nextNode()) { text_nodes.push(walker.currentNode); }
            text_nodes.forEach(wrap_words_in_text_node);

            /* add stagger */
            const word_nodes = container_node.querySelectorAll('.reveal-effect-word');
            word_nodes.forEach((word_node, index) => {
                word_node.style.transitionDelay = (index * 40) + 'ms';
            });

            /* mark as prepared and reveal visibility */
            container_node.classList.add('reveal-effect-prepared');
            container_node.style.visibility = 'visible';
        };

        /* set up scroll trigger */
        document.addEventListener('DOMContentLoaded', () => {
            const container_node = document.querySelector('.reveal-effect');
            if (!container_node) { return; }

            /* prepare once (preserves HTML) */
            prepare_reveal_container(container_node);

            /* trigger when in view */
            const on_intersect = (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        /* start the animation */
                        container_node.classList.add('reveal-effect-in');
                        observer.unobserve(container_node);
                    }
                });
            };

            const intersection_observer = new IntersectionObserver(on_intersect, {
                root: null,
                rootMargin: '0px 0px -10% 0px',
                threshold: 0.1
            });

            intersection_observer.observe(container_node);
        });
    </script>
<?php endif ?>

<?php if(settings()->main->display_index_testimonials): ?>
    <div class="my-5">&nbsp;</div>

    <div class="p-4">
        <div class="mt-5 py-7 bg-primary-100 rounded-2x">
            <div class="container">
                <div class="text-center">
                    <h2><?= l('index.testimonials.header') ?> <i class="fas fa-fw fa-xs fa-check-circle text-primary"></i></h2>
                </div>

                <?php
                $language_array = \Altum\Language::get(\Altum\Language::$name);
                if(\Altum\Language::$main_name != \Altum\Language::$name) {
                    $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
                }

                $testimonials_language_keys = [];
                foreach ($language_array as $key => $value) {
                    if(preg_match('/index\.testimonials\.(\w+)\./', $key, $matches)) {
                        $testimonials_language_keys[] = $matches[1];
                    }
                }

                $testimonials_language_keys = array_unique($testimonials_language_keys);
                ?>

                <div class="row mt-8 mx-n3">
                    <?php foreach($testimonials_language_keys as $key => $value): ?>
                        <div class="col-12 col-lg-4 mb-7 mb-lg-0 px-4" data-aos="fade-up" data-aos-delay="<?= $key * 100 ?>">
                            <div class="card border-0 zoom-animation-subtle">
                                <div class="card-body">
                                    <img src="<?= get_custom_image_if_any('index/testimonial-' . $value . '.webp') ?>" class="img-fluid index-testimonial-avatar" alt="<?= l('index.testimonials.' . $value . '.name') . ', ' . l('index.testimonials.' . $value . '.attribute') ?>" loading="lazy" />

                                    <p class="mt-5">
                                        <span class="text-gray-800 font-weight-bold text-muted h5">“</span>
                                        <span><?= l('index.testimonials.' . $value . '.text') ?></span>
                                        <span class="text-gray-800 font-weight-bold text-muted h5">”</span>
                                    </p>

                                    <div class="blockquote-footer mt-4">
                                        <span class="font-weight-bold"><?= l('index.testimonials.' . $value . '.name') ?></span><br /> <span class="text-muted index-testimonial-comment"><?= l('index.testimonials.' . $value . '.attribute') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if(settings()->main->display_index_plans): ?>
    <div class="my-5">&nbsp;</div>

    <div id="plans" class="container">
        <div class="text-center mb-5">
            <h2><?= l('index.pricing.header') ?></h2>
            <p class="text-muted"><?= l('index.pricing.subheader') ?></p>
        </div>

        <?= $this->views['plans'] ?>
    </div>
<?php endif ?>

<?php if(settings()->main->display_index_faq): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= l('index.faq.header') ?></h2>
        </div>

        <?php
        $language_array = \Altum\Language::get(\Altum\Language::$name);
        if(\Altum\Language::$main_name != \Altum\Language::$name) {
            $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
        }

        $faq_language_keys = [];
        foreach ($language_array as $key => $value) {
            if(preg_match('/index\.faq\.(\w+)\./', $key, $matches)) {
                $faq_language_keys[] = $matches[1];
            }
        }

        $faq_language_keys = array_unique($faq_language_keys);
        ?>

        <div class="accordion index-faq" id="faq_accordion">
            <?php foreach($faq_language_keys as $key): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="" id="<?= 'faq_accordion_' . $key ?>">
                            <h3 class="mb-0">
                                <button class="btn btn-lg font-weight-500 btn-block d-flex justify-content-between text-gray-800 px-0 icon-zoom-animation no-focus" type="button" data-toggle="collapse" data-target="<?= '#faq_accordion_answer_' . $key ?>" aria-expanded="true" aria-controls="<?= 'faq_accordion_answer_' . $key ?>">
                                    <span class="text-left"><?= l('index.faq.' . $key . '.question') ?></span>

                                    <span data-icon>
                                        <i class="fas fa-fw fa-circle-chevron-down"></i>
                                    </span>
                                </button>
                            </h3>
                        </div>

                        <div id="<?= 'faq_accordion_answer_' . $key ?>" class="collapse text-muted mt-2" aria-labelledby="<?= 'faq_accordion_' . $key ?>" data-parent="#faq_accordion">
                            <?= l('index.faq.' . $key . '.answer') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <?php ob_start() ?>
    <script>
        'use strict';

        $('#faq_accordion').on('show.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.transform = 'rotate(180deg)';
            svg.style.color = 'var(--primary)';
        })

        $('#faq_accordion').on('hide.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.color = 'var(--primary-800)';
            svg.style.removeProperty('transform');
        })
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<?php endif ?>

<?php if(settings()->users->register_is_enabled): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="card border-0 index-cta py-5 py-lg-6" data-aos="fade-up">
            <div class="card-body">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-5">
                        <div class="text-center text-lg-left mb-4 mb-lg-0">
                            <h2 class="h1"><?= l('index.cta.header') ?></h2>
                            <p class="h5"><?= l('index.cta.subheader') ?></p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                        <div class="text-center text-lg-right">
                            <?php if(is_logged_in()): ?>
                                <a href="<?= url('dashboard') ?>" class="btn btn-outline-primary zoom-animation">
                                    <?= l('dashboard.menu') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= url('register') ?>" class="btn btn-outline-primary zoom-animation">
                                    <?= l('index.cta.register') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<?php if (!empty($data->blog_posts)): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= sprintf(l('index.blog.header'), '<span class="text-primary">', '</span>') ?></h2>
        </div>

        <div class="row m-n4">
            <?php foreach($data->blog_posts as $blog_post): ?>
                <div class="col-12 col-lg-4 p-4">
                    <div class="card h-100 zoom-animation-subtle position-relative">
                        <div class="card-body">
                            <?php if($blog_post->image): ?>
                                <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>" aria-label="<?= $blog_post->title ?>">
                                    <img src="<?= \Altum\Uploads::get_full_url('blog') . $blog_post->image ?>" class="blog-post-image-small img-fluid w-100 rounded mb-4" alt="<?= $blog_post->image_description ?>" loading="lazy" />
                                </a>
                            <?php endif ?>

                            <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>" class="stretched-link text-decoration-none">
                                <h3 class="h5 card-title mb-2 d-inline"><?= $blog_post->title ?></h3>
                            </a>

                            <p class="text-muted mb-0"><?= $blog_post->description ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>


<?php ob_start() ?>
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/libraries/aos.min.css?v=' . PRODUCT_CODE ?>">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/aos.min.js?v=' . PRODUCT_CODE ?>"></script>

<script>
    'use strict';

    AOS.init({
        duration: 600
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php ob_start() ?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= settings()->main->title ?>",
        "url": "<?= url() ?>",
    <?php if(settings()->main->{'logo_' . \Altum\ThemeStyle::get()}): ?>
        "logo": "<?= settings()->main->{'logo_' . \Altum\ThemeStyle::get() . '_full_url'} ?>",
        <?php endif ?>
    "slogan": "<?= l('index.header') ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "url": "<?= url('contact') ?>",
            "contactType": "Contact us"
        }
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "<?= l('index.title') ?>",
                    "item": "<?= url() ?>"
                }
            ]
        }
</script>

<?php if(settings()->main->display_index_faq): ?>
    <?php
    $faqs = [];
    foreach($faq_language_keys as $key) {
        $faqs[] = [
            '@type' => 'Question',
            'name' => l('index.faq.' . $key . '.question'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => l('index.faq.' . $key . '.answer'),
            ]
        ];
    }
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": <?= json_encode($faqs) ?>
        }
    </script>
<?php endif ?>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php ob_start() ?>
<link href="<?= ASSETS_FULL_URL . 'css/index-custom.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>
