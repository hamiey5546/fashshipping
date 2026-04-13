import './bootstrap';

const initReveal = () => {
    const elements = Array.from(document.querySelectorAll('[data-fs-reveal]'));
    if (!elements.length) return;

    elements.forEach((el) => el.classList.add('fs-reveal'));

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { root: null, rootMargin: '0px 0px -10% 0px', threshold: 0.12 }
    );

    elements.forEach((el) => observer.observe(el));
};

const initCounters = () => {
    const counters = Array.from(document.querySelectorAll('[data-fs-count]'));
    if (!counters.length) return;

    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const animate = (el) => {
        const raw = el.getAttribute('data-fs-count') ?? '0';
        const target = Number(raw);
        if (!Number.isFinite(target)) return;

        const startValue = 0;
        const duration = prefersReduced ? 0 : 900;
        const start = performance.now();

        const tick = (now) => {
            const t = duration === 0 ? 1 : Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - t, 3);
            const value = Math.round(startValue + (target - startValue) * eased);
            el.textContent = value.toLocaleString();
            if (t < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { root: null, rootMargin: '0px 0px -20% 0px', threshold: 0.2 }
    );

    counters.forEach((el) => observer.observe(el));
};

const loadScriptOnce = (src, id) => {
    return new Promise((resolve, reject) => {
        const existing = document.getElementById(id);
        if (existing) {
            resolve();
            return;
        }

        const script = document.createElement('script');
        script.id = id;
        script.src = src;
        script.async = true;
        script.onload = () => resolve();
        script.onerror = () => reject(new Error(`Failed to load script: ${src}`));
        document.head.appendChild(script);
    });
};

const initMapboxTracking = async () => {
    const mapEl = document.querySelector('[data-fs-mapbox="1"]');
    if (!mapEl) return;

    const token = mapEl.getAttribute('data-mapbox-token') ?? '';
    const pointsJson = mapEl.getAttribute('data-route-points') ?? '[]';

    if (!token) return;

    let points;
    try {
        points = JSON.parse(pointsJson);
    } catch {
        return;
    }

    if (!Array.isArray(points) || points.length < 2) return;

    await loadScriptOnce('https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js', 'mapbox-gl-js');

    const mapboxgl = window.mapboxgl;
    if (!mapboxgl) return;

    mapboxgl.accessToken = token;

    const toLngLat = (p) => [Number(p.longitude), Number(p.latitude)];
    const coordinates = points.map(toLngLat);

    const map = new mapboxgl.Map({
        container: mapEl,
        style: 'mapbox://styles/mapbox/light-v11',
        center: coordinates[0],
        zoom: 2,
        attributionControl: false,
    });

    map.addControl(new mapboxgl.NavigationControl({ showCompass: false }), 'top-right');

    const bounds = new mapboxgl.LngLatBounds();
    coordinates.forEach((c) => bounds.extend(c));

    const routeId = 'fs-route';
    const progressId = 'fs-route-progress';

    const buildLine = (coords) => ({
        type: 'Feature',
        geometry: { type: 'LineString', coordinates: coords },
        properties: {},
    });

    const cumulative = [];
    let total = 0;
    for (let i = 0; i < coordinates.length - 1; i++) {
        const a = coordinates[i];
        const b = coordinates[i + 1];
        const dx = b[0] - a[0];
        const dy = b[1] - a[1];
        const d = Math.sqrt(dx * dx + dy * dy);
        total += d;
        cumulative.push(total);
    }

    const interpolate = (t) => {
        if (t <= 0) return coordinates[0];
        if (t >= 1) return coordinates[coordinates.length - 1];

        const target = total * t;
        let idx = cumulative.findIndex((v) => v >= target);
        if (idx < 0) idx = cumulative.length - 1;

        const prevTotal = idx === 0 ? 0 : cumulative[idx - 1];
        const segT = (target - prevTotal) / (cumulative[idx] - prevTotal || 1);

        const a = coordinates[idx];
        const b = coordinates[idx + 1];
        return [a[0] + (b[0] - a[0]) * segT, a[1] + (b[1] - a[1]) * segT];
    };

    const sliceLine = (t) => {
        if (t <= 0) return [coordinates[0]];
        if (t >= 1) return coordinates.slice();

        const target = total * t;
        let idx = cumulative.findIndex((v) => v >= target);
        if (idx < 0) idx = cumulative.length - 1;

        const prevTotal = idx === 0 ? 0 : cumulative[idx - 1];
        const segT = (target - prevTotal) / (cumulative[idx] - prevTotal || 1);

        const coords = coordinates.slice(0, idx + 1);
        const a = coordinates[idx];
        const b = coordinates[idx + 1];
        coords.push([a[0] + (b[0] - a[0]) * segT, a[1] + (b[1] - a[1]) * segT]);

        return coords;
    };

    map.on('load', () => {
        map.fitBounds(bounds, { padding: 60, duration: 0 });

        map.addSource(routeId, { type: 'geojson', data: buildLine(coordinates) });
        map.addLayer({
            id: routeId,
            type: 'line',
            source: routeId,
            paint: {
                'line-color': '#0A2540',
                'line-width': 4,
                'line-opacity': 0.25,
            },
        });

        map.addSource(progressId, { type: 'geojson', data: buildLine([coordinates[0]]) });
        map.addLayer({
            id: progressId,
            type: 'line',
            source: progressId,
            paint: {
                'line-color': '#4cc3ff',
                'line-width': 4,
                'line-opacity': 0.9,
            },
        });

        points.forEach((p, idx) => {
            const el = document.createElement('div');
            el.style.width = '10px';
            el.style.height = '10px';
            el.style.borderRadius = '9999px';
            el.style.background = idx === 0 || idx === points.length - 1 ? '#0A2540' : '#4cc3ff';
            el.style.boxShadow = '0 8px 24px rgba(2, 6, 23, 0.18)';
            new mapboxgl.Marker(el).setLngLat(toLngLat(p)).addTo(map);
        });

        const markerEl = document.createElement('div');
        markerEl.style.width = '16px';
        markerEl.style.height = '16px';
        markerEl.style.borderRadius = '9999px';
        markerEl.style.background = '#4cc3ff';
        markerEl.style.border = '3px solid white';
        markerEl.style.boxShadow = '0 10px 26px rgba(2, 6, 23, 0.18)';
        const marker = new mapboxgl.Marker(markerEl).setLngLat(coordinates[0]).addTo(map);

        let start;
        const durationMs = 5200;

        const step = (ts) => {
            if (!start) start = ts;
            const t = Math.min(1, (ts - start) / durationMs);
            marker.setLngLat(interpolate(t));
            map.getSource(progressId).setData(buildLine(sliceLine(t)));
            if (t < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initReveal();
    initCounters();
    initMapboxTracking();
});

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('fs-mobile-toggle');
    const menu = document.getElementById('fs-mobile-menu');

    if (!toggle || !menu) return;

    const close = () => {
        menu.classList.add('hidden');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
            return;
        }

        close();
    });

    menu.addEventListener('click', (e) => {
        const link = e.target instanceof HTMLElement ? e.target.closest('a') : null;
        if (link) close();
    });
});
