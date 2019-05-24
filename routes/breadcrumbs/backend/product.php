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




