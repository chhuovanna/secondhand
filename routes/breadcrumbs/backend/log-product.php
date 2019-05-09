<?php

Breadcrumbs::for('log-product::dashboard', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('menus.backend.log-product.main'), url('admin/log-product'));
});

Breadcrumbs::for('log-product::logs.list', function ($trail) {
    $trail->parent('log-product::dashboard');
    $trail->push(__('menus.backend.log-product.logs'), url('admin/log-product/logs'));
});

Breadcrumbs::for('log-product::logs.show', function ($trail, $date) {
    $trail->parent('log-product::logs.list');
    $trail->push($date, url('admin/log-product/logs/'.$date));
});

Breadcrumbs::for('log-product::logs.filter', function ($trail, $date, $filter) {
    $trail->parent('log-product::logs.show', $date);
    $trail->push(ucfirst($filter), url('admin/log-product/'.$date.'/'.$filter));
});
