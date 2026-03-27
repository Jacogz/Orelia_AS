@extends('layouts.app')

@section('title', 'Home')

@section('content')
<h1>Homepage</h1>

<ul>
	<li><a href="{{ route('pieces.index') }}">Pieces</a></li>
	<li><a href="{{ route('materials.index') }}">Materials</a></li>
	<li><a href="{{ route('collections.index') }}">Collections</a></li>
	<li><a href="{{ route('cart.index') }}">Cart</a></li>
	<li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
	<li><a href="{{ route('admin.pieces.index') }}">Admin Pieces</a></li>
	<li><a href="{{ route('admin.materials.index') }}">Admin Materials</a></li>
	<li><a href="{{ route('admin.collections.index') }}">Admin Collections</a></li>
</ul>
    