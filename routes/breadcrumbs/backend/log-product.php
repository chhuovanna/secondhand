<?php

Breadcrumbs::for('log-seller::dashboard', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push(__('menus.backend.log-seller.main'), url('admin/log-seller'));
});

Breadcrumbs::for('log-seller::logs.list', function ($trail) {
    $trail->parent('log-seller::dashboard');
    $trail->push(__('menus.backend.log-seller.logs'), url('admin/log-seller/logs'));
});

Breadcrumbs::for('log-seller::logs.show', function ($trail, $date) {
    $trail->parent('log-seller::logs.list');
    $trail->push($date, url('admin/log-seller/logs/'.$date));
});

Breadcrumbs::for('log-seller::logs.filter', function ($trail, $date, $filter) {
    $trail->parent('log-seller::logs.show', $date);
    $trail->push(ucfirst($filter), url('admin/log-seller/'.$date.'/'.$filter));
});
