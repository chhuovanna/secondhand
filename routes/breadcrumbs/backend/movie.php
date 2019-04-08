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
