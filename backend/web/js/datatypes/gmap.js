var google;
$(document).ready(function () {


    function initAllMaps() {
        $maps = $('.admin-gmap');
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

            var myLatLng = {lat: parseFloat(val[0]), lng: parseFloat(val[1])};
            var zoom = parseInt(val[2]);

        } else {

            var myLatLng = {lat: 56.84086, lng: 60.60037};
            var zoom = 12;
        }


        var map = new google.maps.Map($map, {
            center: myLatLng,
            scrollwheel: true,
            zoom: zoom,
        });


        google.maps.event.addListener(map, 'click', function (event) {
            placeMarker(event.latLng);

            setInfo();
        });
        google.maps.event.addListener(map, 'zoom_changed', function (event) {

            setInfo();

        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });

        function placeMarker(location) {

            marker.setPosition(location);

        }


        setInfo();

        function setInfo() {

            var $input = $($map).prev().find('input');
            var pos = marker.getPosition();
            var result = pos.lat() + ";" + pos.lng() + ";" + map.getZoom();

            $input.val(result);
        }

    }

    if (google) {
        google.maps.event.addDomListener(window, "load", initAllMaps);
    }


});