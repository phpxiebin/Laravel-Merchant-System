<?php
/**
 * 面包屑配置
 */
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('控制台', route('home'), ['icon' => 'home.png']);
});

Breadcrumbs::register('face', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('人脸信息管理', route('face'));
    $breadcrumbs->push('人脸数据列表', route('face'));
});

Breadcrumbs::register('face.store', function($breadcrumbs)
{
    $breadcrumbs->parent('face');
    $breadcrumbs->push('添加人脸', route('face.store'));
});

Breadcrumbs::register('face.update', function($breadcrumbs)
{
    $breadcrumbs->parent('face');
    $breadcrumbs->push('修改人脸', route('face.update'));
});

Breadcrumbs::register('group', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('人脸信息管理', route('face'));
    $breadcrumbs->push('组数据列表', route('group'));
});

Breadcrumbs::register('group.store', function($breadcrumbs)
{
    $breadcrumbs->parent('group');
    $breadcrumbs->push('添加组', route('group.store'));
});

Breadcrumbs::register('group.update', function($breadcrumbs)
{
    $breadcrumbs->parent('group');
    $breadcrumbs->push('修改组', route('group.update'));
});

Breadcrumbs::register('group.identify', function($breadcrumbs)
{
    $breadcrumbs->parent('group');
    $breadcrumbs->push('组识别', route('group.identify'));
});