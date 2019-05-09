<?php
Breadcrumbs::for('category.index', function ($trail) {
    $trail->push( 'List Category', route('category.index'));
});

Breadcrumbs::for('category.create', function ($trail) {
    $trail->parent('category.index');
    $trail->push( 'Create Category', route('category.create'));
});

Breadcrumbs::for('category.edit', function ($trail,$id) {
	$trail->parent('category.index');
    $trail->push( 'Create Category', route('category.edit',$id));
});

Breadcrumbs::for('category.showrate', function ($trail) {
	$trail->parent('category.index');
    $trail->push( 'Rate Category', route('category.rate'));
});


Breadcrumbs::for('category.rate', function ($trail) {
	$trail->parent('category.index');
	$trail->parent('category.showrate');
    $trail->push( 'Show Rate', route('category.showrate'));
});

