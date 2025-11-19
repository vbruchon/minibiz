@extends('layouts.dashboard')

@section('title', 'MiniBiz - Tableau de bord')

@section('content')
<div class="space-y-8">
  @include('dashboard.partials._header')

  @include('dashboard.partials._global_kpi')
  <div class="h-[1px] bg-primary/20 my-8"></div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-2">
      @include('dashboard.partials._customers_section')
      <div class="h-[1px] bg-primary/20 my-8"></div>
      @include('dashboard.partials._products_section')
    </div>

    <div class="space-y-12">
      @include('dashboard.partials._bills_section')
      <div class="h-[1px] bg-primary/20"></div>
      @include('dashboard.partials._activity_section')
    </div>
  </div>
</div>
@endsection