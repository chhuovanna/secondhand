<?php
Breadcrumbs::for('message.listmessage', function ($trail) {
    $trail->push( 'List message', route('message.listmessage'));
});
