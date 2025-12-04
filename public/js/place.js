(function(){
  'use strict';

  function loadGoogleMaps(apiKey){
    return new Promise(function(resolve,reject){
      if (window.google && window.google.maps) return resolve(window.google.maps);
      if (!apiKey) return reject(new Error('Google Maps API key not provided'));
      var s = document.createElement('script');
      s.src = 'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(apiKey);
      s.async = true; s.defer = true;
      s.onload = function(){
        if (window.google && window.google.maps) resolve(window.google.maps);
        else reject(new Error('Google Maps failed to initialize'));
      };
      s.onerror = function(err){ reject(err || new Error('Failed to load Google Maps script')); };
      document.head.appendChild(s);
    });
  }

  function showMessage(el, msg){
    if (!el) return;
    el.innerHTML = '<div style="color:#666;text-align:center;padding:12px;">' + (msg || '') + '</div>';
  }

  function initMiniMap(){
    var mapEl = document.getElementById('miniMap');
    var dataEl = document.getElementById('miniMapData');
    if (!mapEl || !dataEl) return;

    var lat = dataEl.dataset.lat || '';
    var lng = dataEl.dataset.lng || '';
    var destinationAddress = dataEl.dataset.destinationAddress || '';
    var originAddress = dataEl.dataset.originAddress || 'Senac Hub Academy, Campo Grande, MS';

    var apiKey = window.GOOGLE_MAPS_API_KEY || null;
    if (!apiKey) {
      showMessage(mapEl, 'Google Maps API key not set. Defina `window.GOOGLE_MAPS_API_KEY` com sua chave.');
      return;
    }

    loadGoogleMaps(apiKey).then(function(maps){
      var mapOpts = { zoom: 15 };
      if (lat !== '' && lng !== '') {
        mapOpts.center = { lat: parseFloat(lat), lng: parseFloat(lng) };
      } else if (destinationAddress) {
        mapOpts.center = { lat: -20.4699, lng: -54.6201 };
      } else {
        mapOpts.center = { lat: -20.4699, lng: -54.6201 };
      }

      var map = new maps.Map(mapEl, mapOpts);
      var directionsService = new maps.DirectionsService();
      var directionsRenderer = new maps.DirectionsRenderer({ map: map });

      var destination = null;
      if (lat !== '' && lng !== '') {
        destination = { lat: parseFloat(lat), lng: parseFloat(lng) };
      } else if (destinationAddress) {
        destination = destinationAddress;
      } else {
        showMessage(mapEl, 'Endereço de destino não disponível.');
        return;
      }

      var request = {
        origin: originAddress,
        destination: destination,
        travelMode: maps.TravelMode.DRIVING
      };

      directionsService.route(request, function(result, status){
        if (status === maps.DirectionsStatus.OK) {
          directionsRenderer.setDirections(result);
        } else {
          console.warn('Directions request failed:', status);
          showMessage(mapEl, 'Não foi possível calcular a rota (Google Maps status: ' + status + ').');
        }
      });
    }).catch(function(err){
      console.error(err);
      showMessage(mapEl, 'Erro ao carregar Google Maps: ' + (err.message || err));
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMiniMap);
  } else {
    setTimeout(initMiniMap, 0);
  }

  
  window.initPlaceMiniMap = initMiniMap;

})();
