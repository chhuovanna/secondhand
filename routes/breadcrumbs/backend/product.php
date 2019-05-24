<?php
Breadcrumbs::for('product.index', function ($trail) {
    $trail->push( 'List Product', route('product.index'));
});

Breadcrumbs::for('product.create', function ($trail) {
    $trail->parent('product.index');
    $trail->push( 'Create product', route('product.create'));
});

Breadcrumbs::for('product.edit', function ($trail,$id) {
    $trail->parent('product.index');
    $trail->push( 'Create product', route('product.edit',$id));
});

Breadcrumbs::for('product.showsign_up', function ($trail) {
    $trail->parent('product.index');
    $trail->push( 'Sign_up product', route('product.sign_up'));
});


Breadcrumbs::for('product.sign_up', function ($trail) {
    $trail->parent('product.index');
    $trail->parent('product.showsign_up');
    $trail->push( 'Show Sign_up', route('product.showsign_up'));
});

