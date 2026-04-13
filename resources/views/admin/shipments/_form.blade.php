<div class="grid gap-6">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold text-slate-900">Shipment</div>
        <div class="mt-5 grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-slate-700" for="tracking_id">Tracking ID (optional)</label>
                <input id="tracking_id" name="tracking_id" value="{{ old('tracking_id', $shipment->tracking_id) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="FSH-9X82K3" />
                @error('tracking_id')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="status">Status</label>
                <select id="status" name="status" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required>
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $shipment->status ?: 'pending') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="estimated_delivery_date">Estimated delivery date</label>
                <input id="estimated_delivery_date" name="estimated_delivery_date" type="date" value="{{ old('estimated_delivery_date', optional($shipment->estimated_delivery_date)->toDateString()) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                @error('estimated_delivery_date')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="dispatch_date">Dispatch date</label>
                <input id="dispatch_date" name="dispatch_date" type="date" value="{{ old('dispatch_date', optional($shipment->dispatch_date)->toDateString()) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                @error('dispatch_date')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="shipping_method">Shipping method</label>
                <select id="shipping_method" name="shipping_method" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
                    @php
                        $shippingMethod = old('shipping_method', $shipment->shipping_method);
                    @endphp
                    <option value="" @selected(! filled($shippingMethod))>Select method</option>
                    <option value="air" @selected($shippingMethod === 'air')>Air</option>
                    <option value="sea" @selected($shippingMethod === 'sea')>Sea</option>
                    <option value="express" @selected($shippingMethod === 'express')>Express</option>
                </select>
                @error('shipping_method')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">Sender</div>
            <div class="mt-5 grid gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-700" for="sender_name">Name</label>
                    <input id="sender_name" name="sender_name" value="{{ old('sender_name', $shipment->sender_name) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                    @error('sender_name')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="sender_email">Email</label>
                        <input id="sender_email" name="sender_email" type="email" value="{{ old('sender_email', $shipment->sender_email) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                        @error('sender_email')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="sender_phone">Phone</label>
                        <input id="sender_phone" name="sender_phone" value="{{ old('sender_phone', $shipment->sender_phone) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                        @error('sender_phone')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700" for="sender_address">Address</label>
                    <input id="sender_address" name="sender_address" value="{{ old('sender_address', $shipment->sender_address) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                    @error('sender_address')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">Receiver</div>
            <div class="mt-5 grid gap-4">
                <div>
                    <label class="text-sm font-medium text-slate-700" for="receiver_name">Name</label>
                    <input id="receiver_name" name="receiver_name" value="{{ old('receiver_name', $shipment->receiver_name) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                    @error('receiver_name')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="receiver_email">Email</label>
                        <input id="receiver_email" name="receiver_email" type="email" value="{{ old('receiver_email', $shipment->receiver_email) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                        @error('receiver_email')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700" for="receiver_phone">Phone</label>
                        <input id="receiver_phone" name="receiver_phone" value="{{ old('receiver_phone', $shipment->receiver_phone) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                        @error('receiver_phone')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700" for="receiver_address">Address</label>
                    <input id="receiver_address" name="receiver_address" value="{{ old('receiver_address', $shipment->receiver_address) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                    @error('receiver_address')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold text-slate-900">Parcel</div>
        <div class="mt-5 grid gap-4 sm:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-slate-700" for="parcel_weight">Weight (kg)</label>
                <input id="parcel_weight" name="parcel_weight" type="number" step="0.01" value="{{ old('parcel_weight', $shipment->parcel_weight) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                @error('parcel_weight')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="parcel_category">Category</label>
                <input id="parcel_category" name="parcel_category" value="{{ old('parcel_category', $shipment->parcel_category) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                @error('parcel_category')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700" for="parcel_value">Value (optional)</label>
                <input id="parcel_value" name="parcel_value" type="number" step="0.01" value="{{ old('parcel_value', $shipment->parcel_value) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                @error('parcel_value')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
            <div class="sm:col-span-3">
                <label class="text-sm font-medium text-slate-700" for="parcel_description">Description</label>
                <textarea id="parcel_description" name="parcel_description" rows="3" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">{{ old('parcel_description', $shipment->parcel_description) }}</textarea>
                @error('parcel_description')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-sm font-semibold text-slate-900">Locations</div>
        <div class="mt-5 grid gap-6 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs font-semibold text-slate-700">Origin</div>
                <div class="mt-3 space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-600" for="origin_label">Label</label>
                        <input id="origin_label" name="origin_label" value="{{ old('origin_label', $shipment->origin?->label) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('origin_label')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="origin_latitude">Lat</label>
                            <input id="origin_latitude" name="origin_latitude" type="number" step="0.0000001" value="{{ old('origin_latitude', $shipment->origin?->latitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('origin_latitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="origin_longitude">Lng</label>
                            <input id="origin_longitude" name="origin_longitude" type="number" step="0.0000001" value="{{ old('origin_longitude', $shipment->origin?->longitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('origin_longitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs font-semibold text-slate-700">Current (optional)</div>
                <div class="mt-3 space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-600" for="current_label">Label</label>
                        <input id="current_label" name="current_label" value="{{ old('current_label', $shipment->current?->label) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                        @error('current_label')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="current_latitude">Lat</label>
                            <input id="current_latitude" name="current_latitude" type="number" step="0.0000001" value="{{ old('current_latitude', $shipment->current?->latitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                            @error('current_latitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="current_longitude">Lng</label>
                            <input id="current_longitude" name="current_longitude" type="number" step="0.0000001" value="{{ old('current_longitude', $shipment->current?->longitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                            @error('current_longitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs font-semibold text-slate-700">Destination</div>
                <div class="mt-3 space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-600" for="destination_label">Label</label>
                        <input id="destination_label" name="destination_label" value="{{ old('destination_label', $shipment->destination?->label) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                        @error('destination_label')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="destination_latitude">Lat</label>
                            <input id="destination_latitude" name="destination_latitude" type="number" step="0.0000001" value="{{ old('destination_latitude', $shipment->destination?->latitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('destination_latitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-600" for="destination_longitude">Lng</label>
                            <input id="destination_longitude" name="destination_longitude" type="number" step="0.0000001" value="{{ old('destination_longitude', $shipment->destination?->longitude) }}" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" required />
                            @error('destination_longitude')<div class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
