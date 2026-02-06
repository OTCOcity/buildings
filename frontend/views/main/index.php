<?php

/** @var yii\web\View $this */
/** @var array $buildings */

$this->title = 'Карта объектов';
$this->registerJsVar('buildingsData', $buildings);
?>

<div class="map-page">
    <div id="buildings-map" class="map-page__map"></div>

    <aside id="building-drawer" class="building-drawer" aria-hidden="true">
        <button id="drawer-close" class="building-drawer__close" type="button" aria-label="Закрыть">×</button>
        <div id="drawer-content" class="building-drawer__content"></div>
    </aside>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
