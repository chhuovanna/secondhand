<?php
Breadcrumbs::for('seller.index', function ($trail) {
    $trail->push( 'List Seller', route('seller.index'));
});

Breadcrumbs::for('seller.create', function ($trail) {
    $trail->parent('seller.index');
    $trail->push( 'Create seller', route('seller.create'));
});

Breadcrumbs::for('seller.edit', function ($trail,$id) {
    $trail->parent('seller.index');
    $trail->push( 'Create seller', route('seller.edit',$id));
});