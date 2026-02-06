(function () {
    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function parsePosition(position) {
        if (!position) {
            return null;
        }

        const [lat, lng, zoom] = String(position).split(';');
        const parsedLat = parseFloat(lat);
        const parsedLng = parseFloat(lng);
        const parsedZoom = parseFloat(zoom);

        if (Number.isNaN(parsedLat) || Number.isNaN(parsedLng)) {
            return null;
        }

        return {
            lat: parsedLat,
            lng: parsedLng,
            zoom: Number.isNaN(parsedZoom) ? null : parsedZoom,
        };
    }

    function formatValue(key, value) {
        if (value === null || value === undefined || value === '') {
            return '—';
        }

        if (key.includes('date')) {
            const timestamp = Number(value);
            if (!Number.isNaN(timestamp) && timestamp > 0) {
                return new Date(timestamp * 1000).toLocaleDateString('ru-RU');
            }
        }

        return String(value);
    }

    function createInfoRows(building, excludedKeys) {
        return Object.entries(building)
            .filter(([key]) => !excludedKeys.includes(key))
            .map(([key, value]) => `
                <div class="building-row">
                    <span class="building-row__label">${escapeHtml(key)}</span>
                    <span class="building-row__value">${escapeHtml(formatValue(key, value))}</span>
                </div>
            `)
            .join('');
    }

    function initMap() {
        if (typeof ymaps === 'undefined' || typeof buildingsData === 'undefined') {
            return;
        }

        const buildings = Array.isArray(buildingsData) ? buildingsData : [];
        const buildingsWithCoords = buildings
            .map((building) => ({ ...building, _coords: parsePosition(building.position) }))
            .filter((building) => building._coords);

        const firstBuilding = buildingsWithCoords[0];
        const center = firstBuilding ? [firstBuilding._coords.lat, firstBuilding._coords.lng] : [55.751244, 37.618423];
        const zoom = firstBuilding && firstBuilding._coords.zoom ? firstBuilding._coords.zoom : 11;

        const map = new ymaps.Map('buildings-map', {
            center,
            zoom,
            controls: ['zoomControl', 'fullscreenControl'],
        });

        const drawer = document.getElementById('building-drawer');
        const drawerContent = document.getElementById('drawer-content');
        const closeButton = document.getElementById('drawer-close');

        function closeDrawer() {
            drawer.classList.remove('building-drawer--open');
            drawer.setAttribute('aria-hidden', 'true');
        }

        function openDrawer(building) {
            drawerContent.innerHTML = `
                <div class="building-drawer__header">
                    <h2>${escapeHtml(building.name || 'Объект')}</h2>
                </div>
                <div class="building-drawer__section">
                    ${createInfoRows(building, [])}
                </div>
            `;

            drawer.classList.add('building-drawer--open');
            drawer.setAttribute('aria-hidden', 'false');
        }

        closeButton.addEventListener('click', closeDrawer);

        drawer.addEventListener('click', function (event) {
            if (event.target === drawer) {
                closeDrawer();
            }
        });

        buildingsWithCoords.forEach((building) => {
            const balloonContent = `
                <div class="building-balloon">
                    <div class="building-balloon__title">${escapeHtml(building.name || 'Объект')}</div>
                    ${createInfoRows(building, ['history', 'files'])}
                    <button class="building-balloon__action" type="button" data-building-id="${escapeHtml(building.id)}" title="Открыть детали">
                        <span>Подробнее</span>
                        <span class="building-balloon__icon">➜</span>
                    </button>
                </div>
            `;

            const placemark = new ymaps.Placemark(
                [building._coords.lat, building._coords.lng],
                {
                    balloonContent,
                    hintContent: escapeHtml(building.name || 'Объект'),
                },
                {
                    preset: 'islands#blueCircleDotIcon',
                    balloonPanelMaxMapArea: 0,
                },
            );

            map.geoObjects.add(placemark);

            placemark.events.add('balloonopen', function () {
                setTimeout(function () {
                    const button = document.querySelector(`.building-balloon__action[data-building-id="${building.id}"]`);
                    if (!button) {
                        return;
                    }

                    button.addEventListener('click', function () {
                        openDrawer(building);
                    });
                }, 0);
            });
        });
    }

    if (document.getElementById('buildings-map')) {
        if (typeof ymaps !== 'undefined') {
            ymaps.ready(initMap);
        } else {
            window.addEventListener('load', function () {
                if (typeof ymaps !== 'undefined') {
                    ymaps.ready(initMap);
                }
            });
        }
    }
})();
