<?php
Breadcrumbs::for('view.index', function ($trail) {
    $trail->push( 'List view', route('view.index'));
});

Breadcrumbs::for('view.create', function ($trail) {
    $trail->parent('view.index');
    $trail->push( 'Create view', route('view.create'));
});

Breadcrumbs::for('view.edit', function ($trail,$id) {
    $trail->parent('view.index');
    $trail->push( 'Create view', route('view.edit',$id));
});

Breadcrumbs::for('view.sign_up', function ($trail) {
    $trail->parent('view.index');
    $trail->push( 'Sign_up view', route('view.sign_up'));
});
