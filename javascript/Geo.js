// Standard jQuery header
(function($) {
	$(document).ready(function() {
  		var map = null;
		var geocoder = null;
		var center = null;

		function initialize() {
			if (GBrowserIsCompatible()) {
				map = new GMap2(document.getElementById("gmap"));

				center = showAddress("españa");
		        map.addControl(new GSmallMapControl());
		        map.addControl(new GMapTypeControl());


		        map.setCenter(center, 5);
		        map.setMapType(G_HYBRID_MAP);


				geocoder = new GClientGeocoder();


				jQuery(document).ready(function(){

					jQuery(".address").each(function(){
						showAddress(jQuery(this).text());
					});

				});


			}
		}
		initialize();
		function showAddress(address) {
			if (geocoder) {
				geocoder.getLatLng(
					address,
					function(point) {
						if (!point) {
						alert(address + " not found");
						} else {
						map.setCenter(point, 10);
						var marker = new GMarker(point);
						map.addOverlay(marker);
						marker.openInfoWindowHtml(address);
						}
					}
				);
			}
		}


  	
	})

})(jQuery);
