<?php
Breadcrumbs::for('sign_up.index', function ($trail) {
    $trail->push( 'List Sign_up', route('sign_up.index'));
});

Breadcrumbs::for('sign_up.create', function ($trail) {
    $trail->parent('sign_up.index');
    $trail->push( 'Create sign_up', route('sign_up.create'));
});

Breadcrumbs::for('sign_up.edit', function ($trail,$id) {
    $trail->parent('sign_up.index');
    $trail->push( 'Create sign_up', route('sign_up.edit',$id));
});