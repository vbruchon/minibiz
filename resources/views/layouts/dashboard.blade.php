@extends('layouts.app')

@section('title', 'MiniBiz Dashboard')

@section('body')
<x-sidebar />

<main class="ml-56 p-8">
  @yield('content')
</main>

@if(session('success'))
<x-toast type="success" :message="session('success')" />
@endif

@if(session('error'))
<x-toast type="error" :message="session('error')" />
@endif
@endsection