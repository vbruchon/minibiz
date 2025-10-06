@extends('layouts.dashboard')

@section('title', 'Ajouter un client')

@section('content')
<div>
  <a href="{{ route('customers.all') }}"
    class="flex items-center gap-2 w-fit px-4 py-2 bg-muted/50 text-gray-200 rounded-lg font-semibold hover:bg-muted transition-colors">
    <x-heroicon-s-arrow-left class="size-5" />

    Back
  </a>
  <div class="max-w-4xl mx-auto mt-12 p-8">
    <h2 class="text-5xl font-bold text-foreground mb-8">Add customer</h2>

    <x-customer-form />

  </div>
</div>
@endsection