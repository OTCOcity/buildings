/* global ymaps, $ */

(function () {
  "use strict";

  var state = {
    map: null,
    placemarks: [],
    selectedId: null,
  };

  function setDrawerVisible(isVisible) {
    $("#drawer")
      .toggleClass("drawer--hidden", !isVisible)
      .attr("aria-hidden", String(!isVisible));
    $("#backdrop").toggleClass("backdrop--hidden", !isVisible);
  }

  function closeDrawer() {
    setDrawerVisible(false);
  }

  function openDrawerById(id) {
    var infoTpl = document.getElementById("build-info-" + id);
    if (!infoTpl) return;

    // Подставляем HTML из template как есть
    $("#drawerContent").html(infoTpl.innerHTML);
    state.selectedId = String(id);
    setDrawerVisible(true);
  }

  function collectPointsFromTemplates() {
    // Берём все template, у которых есть data-lat и data-lng
    var nodes = document.querySelectorAll("template[data-lat][data-lng]");
    var result = [];

    for (var i = 0; i < nodes.length; i++) {
      var tpl = nodes[i];
      var lat = parseFloat(tpl.getAttribute("data-lat"));
      var lng = parseFloat(tpl.getAttribute("data-lng"));

      if (!isFinite(lat) || !isFinite(lng)) continue;

      // id берём из id="build-baloon-XXX"
      var id = String(tpl.id || "");
      var match = id.match(/^build-baloon-(.+)$/);
      if (!match) continue;

      result.push({
        id: match[1],
        coords: [lat, lng],
        balloonHtml: tpl.innerHTML,
      });
    }

    return result;
  }

  function computeBounds(points) {
    if (!points.length) return null;

    var minLat = points[0].coords[0];
    var maxLat = points[0].coords[0];
    var minLng = points[0].coords[1];
    var maxLng = points[0].coords[1];

    for (var i = 1; i < points.length; i++) {
      var lat = points[i].coords[0];
      var lng = points[i].coords[1];

      if (lat < minLat) minLat = lat;
      if (lat > maxLat) maxLat = lat;
      if (lng < minLng) minLng = lng;
      if (lng > maxLng) maxLng = lng;
    }

    return [
      [minLat, minLng],
      [maxLat, maxLng],
    ];
  }

  function initMap(points) {
    ymaps.ready(function () {
      state.map = new ymaps.Map(
        "map",
        {
          center: [55.751244, 37.618423],
          zoom: 12,
          controls: ["zoomControl"],
        },
        {
          suppressMapOpenBlock: true,
        }
      );

      // Создаём метки
      for (var i = 0; i < points.length; i++) {
        (function (p) {
          var placemark = new ymaps.Placemark(
            p.coords,
            {}, // контент не храним тут
            {
              cursor: "pointer",
              hideIconOnBalloonOpen: false,
            }
          );

          placemark.events.add("click", function () {
            // на всякий случай закрываем текущий, чтобы повторный клик по тому же маркеру всегда работал
            state.map.balloon.close();

            state.map.balloon.open(p.coords, p.balloonHtml, {
              closeButton: true,
              autoPan: true,
              maxWidth: 320,
            });
          });

          state.map.geoObjects.add(placemark);
          state.placemarks.push(placemark);
        })(points[i]);
      }

      // Центр/зум, чтобы все точки были на экране
      if (points.length === 1) {
        state.map.setCenter(points[0].coords, 16, { duration: 0 });
      } else if (points.length > 1) {
        var bounds = computeBounds(points);
        if (bounds) {
          state.map.setBounds(bounds, {
            checkZoomRange: true,
            zoomMargin: 48,
          });
        }
      }

      // Клик по карте закрывает drawer (если хочешь — убери)
      state.map.events.add("click", function () {
        closeDrawer();
      });
    });
  }

  function bindUi() {
    var $appMenu = $("#appMenu");
    var $appMenuToggle = $("#appMenuToggle");
    var $appMenuPanel = $("#appMenuPanel");

    function setMenuOpen(isOpen) {
      $appMenu.toggleClass("app-menu--open", isOpen);
      $appMenuToggle.attr("aria-expanded", String(isOpen));
      $appMenuPanel.attr("aria-hidden", String(!isOpen));
    }

    $appMenuToggle.on("click", function (e) {
      e.stopPropagation();
      setMenuOpen(!$appMenu.hasClass("app-menu--open"));
    });

    $(document).on("click", function (e) {
      if (!$(e.target).closest("#appMenu").length) {
        setMenuOpen(false);
      }
    });

    $(document).on("click", ".js-close-drawer", function () {
      closeDrawer();
    });

    $("#backdrop").on("click", function () {
      closeDrawer();
    });

    $(document).on("keydown", function (e) {
      if (e.keyCode === 27) {
        closeDrawer();
        setMenuOpen(false);
      }
    });

    // ВАЖНО: кнопка "Подробнее" уже есть в твоём balloon-template и имеет data-id="{{ build.id }}"
    // Balloon — это DOM, который создаёт Яндекс.Карта, поэтому делаем делегирование.
    $(document).on("click", "[data-id]", function (e) {
      // Чтобы не перехватывать все элементы на странице с data-id,
      // ограничим: реагируем только если клик внутри балуна.
      // У балуна Я.Карт есть контейнеры с классами ymaps-2-1-79-*
      var $t = $(e.target);
      var $idEl = $t.closest("[data-id]");
      if (!$idEl.length) return;

      var insideBalloon = $t.closest("[class*='ymaps-2-1-']").length > 0;
      if (!insideBalloon) return;

      var id = $idEl.attr("data-id");
      if (!id) return;

      if (state.map && state.map.balloon) state.map.balloon.close();
      openDrawerById(id);
    });
  }

  $(function () {
    bindUi();

    var points = collectPointsFromTemplates();
    initMap(points);
  });
})();
