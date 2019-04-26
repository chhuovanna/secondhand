<?php
Breadcrumbs::for('reviewer.index', function ($trail) {
    $trail->push( 'List reviewer', route('reviewer.index'));
});

Breadcrumbs::for('reviewer.create', function ($trail) {
    $trail->parent('reviewer.index');
    $trail->push( 'Create reviewer', route('reviewer.create'));
});

Breadcrumbs::for('reviewer.edit', function ($trail,$id) {
	$trail->parent('reviewer.index');
    $trail->push( 'Create reviewer', route('reviewer.edit',$id));
});

Breadcrumbs::for('reviewer.rate', function ($trail) {
	$trail->parent('reviewer.index');
    $trail->push( 'Rate reviewer', route('reviewer.rate'));
});
