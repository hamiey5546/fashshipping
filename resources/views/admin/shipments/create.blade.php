@extends('admin.layouts.app')

@section('title', 'Create Shipment — Admin')

@section('content')
    <form method="POST" action="{{ route('admin.shipments.store') }}" class="space-y-6">
        @csrf

        @include('admin.shipments._form', ['shipment' => $shipment, 'statuses' => $statuses])

        <div class="flex justify-end">
            <button class="rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                Create Shipment
            </button>
        </div>
    </form>
@endsection
