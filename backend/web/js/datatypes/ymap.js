$(document).ready(function () {


    function initAllMaps() {
        $maps = $('.admin-ymap');
        if ($maps.length) {

            for (var i = 0; i < $maps.length; i++) {
                initMap($maps.get(i))
            }

        }
    }


    function initMap($map) {

        $input = $($map).prev().find('input');
        if ($input.val() != '') {

            var val = $input.val().split(";");

            var myLatLng = [parseFloat(val[0]), parseFloat(val[1])];
            var zoom = parseInt(val[2]);

        } else {

            var myLatLng = [56.84086, 60.60037];
            var zoom = 12;
        }


        var map = new ymaps.Map($map, {
            center: myLatLng,
            zoom: zoom,
            controls: ['zoomControl']
        });


        map.events.add('click', function (event) {
            placeMarker(event.get('coords'));

            setInfo();
        });
        map.events.add('boundschange', function (event) {

            setInfo();

        });

        var marker = new ymaps.Placemark(myLatLng, {}, {
            draggable: false
        });

        map.geoObjects.add(marker);

        function placeMarker(location) {

            marker.geometry.setCoordinates(location);

        }


        setInfo();

        function setInfo() {

            var $input = $($map).prev().find('input');
            var pos = marker.geometry.getCoordinates();
            var result = pos[0] + ";" + pos[1] + ";" + map.getZoom();

            $input.val(result);
        }

    }

    if (typeof ymaps !== 'undefined') {
        ymaps.ready(initAllMaps);
    }


});
