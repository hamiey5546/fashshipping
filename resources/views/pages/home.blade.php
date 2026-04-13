@extends('layouts.app')

@section('title', 'FashShipping — Delivering Efficiency. Driving Growth.')

@section('content')
    @php
        $assetFromFolder = function (array $candidates, string $fallback): string {
            foreach ($candidates as $path) {
                if (file_exists(public_path($path))) {
                    return asset($path);
                }
            }

            return asset($fallback);
        };

        $boom = function (int $n, string $fallback) use ($assetFromFolder): string {
            $base = "shipping images/boom ($n)";

            return $assetFromFolder(
                [
                    $base.'.jpg',
                    $base.'.jpeg',
                    $base.'.png',
                    $base.'.webp',
                ],
                $fallback
            );
        };

        $heroImage = $boom(10, 'images/hero-cargo.svg');

        $serviceImages = [
            'Freight Forwarding' => $boom(7, 'images/service-freight.svg'),
            'Ocean Freight' => $boom(1, 'images/service-ocean.svg'),
            'Air Freight' => $boom(9, 'images/service-air.svg'),
            'Warehousing' => $boom(6, 'images/service-warehouse.svg'),
        ];

        $solutionImages = [
            'Ocean network' => $boom(2, 'images/solution-ocean.svg'),
            'Air priority' => $boom(9, 'images/solution-air.svg'),
            'Containerized freight' => $boom(7, 'images/solution-container.svg'),
            'Warehouse ops' => $boom(6, 'images/solution-warehouse.svg'),
        ];

        $testimonialPhotos = [
            $boom(3, 'images/avatar-1.svg'),
            $boom(4, 'images/avatar-2.svg'),
            $boom(5, 'images/avatar-3.svg'),
            $boom(8, 'images/avatar-4.svg'),
        ];
    @endphp

    <section class="relative overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="{{ $heroImage }}"
                alt="Cargo ship logistics"
                class="h-full w-full object-cover"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-[#061b33]/85 via-[#061b33]/55 to-[#061b33]/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent"></div>
        </div>

        <div class="relative">
            <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
                <div class="grid gap-10 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-7" data-fs-reveal>
                        <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-semibold text-white/80 backdrop-blur">
                            <span class="inline-block size-2 rounded-full bg-sky-400"></span>
                            Global logistics • Real-time tracking • Enterprise-ready
                        </div>
                        <h1 class="mt-6 text-4xl font-semibold leading-tight tracking-tight text-white sm:text-5xl">
                            Delivering Efficiency. Driving Growth.
                        </h1>
                        <p class="mt-4 max-w-2xl text-base leading-relaxed text-white/80">
                            Smart global logistics and real-time shipment tracking.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                <a href="{{ route('home', [], false) }}#quote" class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#061b33] shadow-sm transition hover:brightness-105">
                                Get a Quote
                            </a>
                <a href="{{ route('home', [], false) }}#track" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-white/10">
                                Track Shipment
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5" data-fs-reveal>
                        <div id="track" class="rounded-3xl border border-white/15 bg-white/10 p-6 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-sm font-semibold text-white">Track a shipment</div>
                                    <div class="mt-1 text-xs text-white/70">Get live status, checkpoints, and route playback.</div>
                                </div>
                                <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-semibold text-white/80">Live</span>
                            </div>

                            <form action="{{ route('tracking.lookup', [], false) }}" method="POST" class="mt-5">
                                @csrf
                                <label for="tracking_id" class="sr-only">Enter Tracking Number</label>
                                <div class="flex flex-col gap-3 sm:flex-row">
                                    <input
                                        id="tracking_id"
                                        name="tracking_id"
                                        placeholder="Enter Tracking Number"
                                        class="w-full flex-1 rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-white/55 shadow-sm outline-none transition focus:border-white/25 focus:ring-4 focus:ring-white/10"
                                        required
                                    />
                                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-sky-400 px-5 py-3 text-sm font-semibold text-[#061b33] shadow-sm transition hover:brightness-105">
                                        Track Now
                                    </button>
                                </div>
                                <div class="mt-3 text-xs text-white/70">
                                    Tracking number connects to backend API to fetch shipment status.
                                </div>
                            </form>

                            <div class="mt-6 rounded-2xl border border-white/15 bg-white/5 p-4">
                                <div class="text-xs font-semibold text-white/80">Example lanes</div>
                                <div class="mt-3 grid gap-2 text-xs text-white/70 sm:grid-cols-2">
                                    <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">New York → London</div>
                                    <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">Shanghai → Dubai</div>
                                    <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">Singapore → Frankfurt</div>
                                    <div class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">Toronto → Paris</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 grid gap-4 sm:grid-cols-3" data-fs-reveal>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-white shadow-sm backdrop-blur">
                        <div class="text-xs font-semibold text-white/70">Coverage</div>
                        <div class="mt-2 text-lg font-semibold">Worldwide lanes</div>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-white shadow-sm backdrop-blur">
                        <div class="text-xs font-semibold text-white/70">Tracking</div>
                        <div class="mt-2 text-lg font-semibold">Timeline + map view</div>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-white shadow-sm backdrop-blur">
                        <div class="text-xs font-semibold text-white/70">Reliability</div>
                        <div class="mt-2 text-lg font-semibold">Performance-first UX</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between" data-fs-reveal>
                <div>
                    <div class="text-xs font-semibold tracking-wide text-slate-500">Services</div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Comprehensive Logistics Solutions</h2>
                </div>
                <a href="{{ route('home', [], false) }}#quote" class="inline-flex items-center justify-center rounded-xl bg-[#0A2540] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    Request Pricing
                </a>
            </div>

            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $services = [
                        ['Freight Forwarding', 'End-to-end coordination across carriers and modes.', $serviceImages['Freight Forwarding']],
                        ['Ocean Freight', 'Reliable ocean shipping with transparent milestones.', $serviceImages['Ocean Freight']],
                        ['Air Freight', 'Fast global air routes for time-sensitive cargo.', $serviceImages['Air Freight']],
                        ['Warehousing', 'Secure storage and fulfillment with real-time visibility.', $serviceImages['Warehousing']],
                    ];
                @endphp
                @foreach ($services as $service)
                    <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-slate-900 shadow-sm transition hover:-translate-y-1 hover:shadow-lg" data-fs-reveal>
                        <div class="relative h-52">
                            <img src="{{ $service[2] }}" alt="{{ $service[0] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
                            <div class="absolute inset-0 bg-gradient-to-t from-[#061b33] via-[#061b33]/40 to-transparent"></div>
                        </div>
                        <div class="p-5">
                            <div class="text-sm font-semibold text-white">{{ $service[0] }}</div>
                            <div class="mt-2 text-sm leading-relaxed text-white/75">{{ $service[1] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" data-fs-reveal>
                    <div class="text-3xl font-semibold tracking-tight text-slate-900"><span data-fs-count="24">24</span>+</div>
                    <div class="mt-2 text-sm font-medium text-slate-600">Years Experience</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" data-fs-reveal>
                    <div class="text-3xl font-semibold tracking-tight text-slate-900"><span data-fs-count="67">67</span>M+</div>
                    <div class="mt-2 text-sm font-medium text-slate-600">Satisfied Clients</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" data-fs-reveal>
                    <div class="text-3xl font-semibold tracking-tight text-slate-900"><span data-fs-count="83">83</span>+</div>
                    <div class="mt-2 text-sm font-medium text-slate-600">Monthly Deliveries</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" data-fs-reveal>
                    <div class="text-3xl font-semibold tracking-tight text-slate-900"><span data-fs-count="3457">3457</span></div>
                    <div class="mt-2 text-sm font-medium text-slate-600">Total Shipments</div>
                </div>
            </div>
        </div>
    </section>

    <section id="solutions" class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-5" data-fs-reveal>
                    <div class="text-xs font-semibold tracking-wide text-slate-500">Solutions</div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">End-to-End Logistics & Management Solutions</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        A modern platform that combines planning, movement, and visibility—built for operational speed and customer trust.
                    </p>

                    <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm" data-fs-reveal>
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Shipping calculator</div>
                                <div class="mt-1 text-xs text-slate-500">Quick estimate for route planning.</div>
                            </div>
                            <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-700">Mini</span>
                        </div>

                        <form class="mt-5 grid gap-3">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="text-xs font-semibold text-slate-600" for="calc_from">From</label>
                                    <select id="calc_from" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
                                        <option>New York</option>
                                        <option>London</option>
                                        <option>Singapore</option>
                                        <option>Shanghai</option>
                                        <option>Dubai</option>
                                        <option>Frankfurt</option>
                                        <option>Toronto</option>
                                        <option>Tokyo</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-slate-600" for="calc_to">To</label>
                                    <select id="calc_to" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
                                        <option>London</option>
                                        <option>New York</option>
                                        <option>Dubai</option>
                                        <option>Shanghai</option>
                                        <option>Singapore</option>
                                        <option>Frankfurt</option>
                                        <option>Paris</option>
                                        <option>Los Angeles</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600" for="calc_weight">Weight</label>
                                <div class="mt-2 flex items-center gap-3">
                                    <input id="calc_weight" type="number" min="0" step="0.1" placeholder="e.g., 12.5" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" />
                                    <span class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700">kg</span>
                                </div>
                            </div>
                            <button type="button" class="mt-2 inline-flex items-center justify-center rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                                Estimate
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="grid gap-4 sm:grid-cols-2">
                        @php
                            $tiles = [
                                ['Ocean network', 'Global lanes with milestone visibility.', $solutionImages['Ocean network']],
                                ['Air priority', 'Fast air routes for critical shipments.', $solutionImages['Air priority']],
                                ['Containerized freight', 'Structured handling for scale and reliability.', $solutionImages['Containerized freight']],
                                ['Warehouse ops', 'Storage, pick/pack, and outbound coordination.', $solutionImages['Warehouse ops']],
                            ];
                        @endphp
                        @foreach ($tiles as $tile)
                            <div class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg" data-fs-reveal>
                                <div class="relative h-40">
                                    <img src="{{ $tile[2] }}" alt="{{ $tile[0] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#061b33]/85 via-[#061b33]/35 to-transparent"></div>
                                </div>
                                <div class="p-5">
                                    <div class="text-sm font-semibold text-slate-900">{{ $tile[0] }}</div>
                                    <div class="mt-2 text-sm text-slate-600">{{ $tile[1] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="bg-[#061b33]">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-4" data-fs-reveal>
                    <div class="text-xs font-semibold tracking-wide text-white/70">Testimonials</div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white">See What Our Happy Clients Are Saying</h2>
                    <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-xs font-semibold text-white/75">
                        Trusted by fast-moving teams worldwide
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold text-white/70">
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">Atlas</span>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">Northwind</span>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">Cloudline</span>
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">ShipFast</span>
                    </div>
                </div>

                <div class="grid gap-4 lg:col-span-8 sm:grid-cols-2">
                    @php
                        $reviews = [
                            ['Avery K.', 'Operations Manager', 'FashShipping makes tracking feel effortless—customers always know what’s happening.', $testimonialPhotos[0]],
                            ['Jordan M.', 'Supply Chain Lead', 'The visibility and timeline updates reduced support tickets and improved delivery confidence.', $testimonialPhotos[1]],
                            ['Sam R.', 'Logistics Director', 'Premium UX, clear milestones, and fast workflows. Exactly what a modern carrier platform needs.', $testimonialPhotos[2]],
                            ['Taylor P.', 'E-commerce Founder', 'Our customers love the tracking experience—it feels trustworthy and professional.', $testimonialPhotos[3]],
                        ];
                    @endphp
                    @foreach ($reviews as $review)
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-sm backdrop-blur" data-fs-reveal>
                            <div class="flex items-center gap-3">
                                <img src="{{ $review[3] }}" alt="{{ $review[0] }}" class="size-11 rounded-2xl object-cover" loading="lazy" />
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-white">{{ $review[0] }}</div>
                                    <div class="mt-1 text-xs text-white/70">{{ $review[1] }}</div>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-1 text-amber-400">
                                @foreach (range(1, 5) as $star)
                                    <svg viewBox="0 0 20 20" class="size-4" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.375 2.454a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.539 1.118l-3.375-2.454a1 1 0 00-1.175 0L6.45 18.05c-.783.57-1.838-.196-1.539-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.46 9.394c-.783-.57-.38-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/>
                                    </svg>
                                @endforeach
                            </div>

                            <div class="mt-4 text-sm leading-relaxed text-white/80">{{ $review[2] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="quote" class="bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-5" data-fs-reveal>
                    <div class="text-xs font-semibold tracking-wide text-slate-500">Quote</div>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Get a fast, accurate shipping quote</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">
                        Tell us the lane, service type, and weight. A specialist will respond with pricing and next steps.
                    </p>
                </div>

                <div class="lg:col-span-7" data-fs-reveal>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                        <form class="grid gap-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm font-medium text-slate-700" for="q_name">Name</label>
                                    <input id="q_name" type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="Your name" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700" for="q_email">Email</label>
                                    <input id="q_email" type="email" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="you@company.com" />
                                </div>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-3">
                                <div class="sm:col-span-1">
                                    <label class="text-sm font-medium text-slate-700" for="q_service">Service</label>
                                    <select id="q_service" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
                                        <option>Freight Forwarding</option>
                                        <option>Ocean Freight</option>
                                        <option>Air Freight</option>
                                        <option>Warehousing</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="text-sm font-medium text-slate-700" for="q_lane">Lane</label>
                                    <input id="q_lane" type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="e.g., New York → London" />
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700" for="q_message">Details</label>
                                <textarea id="q_message" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm outline-none transition focus:border-slate-300 focus:ring-4 focus:ring-slate-100" placeholder="Weight, dimensions, pickup window, delivery target, special handling..."></textarea>
                            </div>
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-xs text-slate-500">Quote requests are handled by a logistics specialist.</div>
                                <button type="button" class="inline-flex items-center justify-center rounded-xl bg-[#0A2540] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                                    Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
