<?php
Breadcrumbs::for('seller.index', function ($trail) {
    $trail->push( 'List Seller', route('seller.index'));
});

Breadcrumbs::for('seller.create', function ($trail) {
    $trail->parent('seller.index');
    $trail->push( 'Create Seller', route('seller.create'));
});

Breadcrumbs::for('seller.edit', function ($trail,$id) {
    $trail->parent('seller.index');
    $trail->push( 'Create Seller', route('seller.edit',$id));
});

Breadcrumbs::for('seller.showsign_up', function ($trail) {
    $trail->parent('seller.index');
    $trail->push( 'Sign_up Seller', route('seller.sign_up'));
});


Breadcrumbs::for('seller.sign_up', function ($trail) {
    $trail->parent('seller.index');
    $trail->parent('seller.showsign_up');
    $trail->push( 'Show Sign_up', route('seller.showsign_up'));
});

