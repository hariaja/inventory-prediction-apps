<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
  $trail->push(trans('page.overview.title'), route('home'));
});

// Roles Breadcrumbs
Breadcrumbs::for('roles.index', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push(trans('page.roles.index'), route('roles.index'));
});

Breadcrumbs::for('roles.create', function (BreadcrumbTrail $trail) {
  $trail->parent('roles.index');
  $trail->push(trans('page.roles.create'), route('roles.create'));
});

Breadcrumbs::for('roles.edit', function (BreadcrumbTrail $trail, $role) {
  $trail->parent('roles.index');
  $trail->push(trans('page.roles.edit'), route('roles.edit', $role->uuid));
});

Breadcrumbs::for('roles.show', function (BreadcrumbTrail $trail, $role) {
  $trail->parent('roles.index');
  $trail->push(trans('page.roles.show'), route('roles.show', $role->uuid));
});
// Roles Breadcrumbs