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

// Users Breadcrumbs
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push(trans('page.users.index'), route('users.index'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
  $trail->parent('users.index');
  $trail->push(trans('page.users.create'), route('users.create'));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, $user) {
  $trail->parent('users.index');
  $trail->push(trans('page.users.edit'), route('users.edit', $user->uuid));
});

Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail, $user) {
  $trail->parent('users.index');
  $trail->push(trans('page.users.show'), route('users.show', $user->uuid));
});
// Users Breadcrumbs

// materials Breadcrumbs
Breadcrumbs::for('materials.index', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push(trans('page.materials.index'), route('materials.index'));
});

Breadcrumbs::for('materials.create', function (BreadcrumbTrail $trail) {
  $trail->parent('materials.index');
  $trail->push(trans('page.materials.create'), route('materials.create'));
});

Breadcrumbs::for('materials.edit', function (BreadcrumbTrail $trail, $material) {
  $trail->parent('materials.index');
  $trail->push(trans('page.materials.edit'), route('materials.edit', $material->uuid));
});

Breadcrumbs::for('materials.show', function (BreadcrumbTrail $trail, $material) {
  $trail->parent('materials.index');
  $trail->push(trans('page.materials.show'), route('materials.show', $material->uuid));
});
// materials Breadcrumbs

// products Breadcrumbs
Breadcrumbs::for('products.index', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push(trans('page.products.index'), route('products.index'));
});

Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
  $trail->parent('products.index');
  $trail->push(trans('page.products.create'), route('products.create'));
});

Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail, $product) {
  $trail->parent('products.index');
  $trail->push(trans('page.products.edit'), route('products.edit', $product->uuid));
});

Breadcrumbs::for('products.show', function (BreadcrumbTrail $trail, $product) {
  $trail->parent('products.index');
  $trail->push(trans('page.products.show'), route('products.show', $product->uuid));
});
// materials Breadcrumbs