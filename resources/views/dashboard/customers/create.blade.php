@extends('layouts.dashboard')

@section('title', 'Add customer')

@section('content')
<div>
  <x-back-button />

  <div class=" mx-auto mt-2 p-8">
    <h1 class="text-3xl font-bold text-foreground mb-8">Add customer</h1>

    <x-customer-form />

  </div>
</div>
@endsection