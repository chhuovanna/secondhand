<?php
Breadcrumbs::for('movie.index', function ($trail) {
    $trail->push( 'List Movie', route('movie.index'));
});

Breadcrumbs::for('movie.create', function ($trail) {
    $trail->parent('movie.index');
    $trail->push( 'Create Movie', route('movie.create'));
});

Breadcrumbs::for('movie.edit', function ($trail,$id) {
	$trail->parent('movie.index');
    $trail->push( 'Create Movie', route('movie.edit',$id));
});

Breadcrumbs::for('movie.showrate', function ($trail) {
	$trail->parent('movie.index');
    $trail->push( 'Rate Movie', route('movie.rate'));
});


Breadcrumbs::for('movie.rate', function ($trail) {
	$trail->parent('movie.index');
	$trail->parent('movie.showrate');
    $trail->push( 'Show Rate', route('movie.showrate'));
});

