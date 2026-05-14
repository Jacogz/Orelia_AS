@extends('layouts.app')

@section('title', __('general.home'))

@section('content')
<h1>{{ __('general.homepage') }}</h1>

<ul>
	<li><a href="{{ route('pieces.index') }}">{{ __('general.pieces') }}</a></li>
	<li><a href="{{ route('materials.index') }}">{{ __('general.materials') }}</a></li>
	<li><a href="{{ route('collections.index') }}">{{ __('general.collections') }}</a></li>
	<li><a href="{{ route('cart.index') }}">{{ __('general.cart') }}</a></li>
	<li><a href="{{ route('admin.dashboard') }}">{{ __('general.admin_dashboard') }}</a></li>
	<li><a href="{{ route('admin.pieces.index') }}">{{ __('general.manage_pieces') }}</a></li>
	<li><a href="{{ route('admin.materials.index') }}">{{ __('general.manage_materials') }}</a></li>
	<li><a href="{{ route('admin.collections.index') }}">{{ __('general.manage_collections') }}</a></li>
</ul>
    