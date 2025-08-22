@extends('admin.layouts.master')
@section('module', 'Admin')
@section('action', 'Personal Profile')

@section('admin-content')

    <h2 class="section-title">Hello, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">Update your personal information below.</p>

    <div class="row mt-4">
        {{-- Left Column: Profile Info --}}
        @include('admin.profile.partials.left-profile-info')

        {{-- Right Column: Profile Form --}}
        @include('admin.profile.partials.right-profile-info')

    </div>

    @push('scripts')
        @include('admin.profile.partials.script')
    @endpush

@endsection
