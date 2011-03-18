<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
	<Document>
		<name>GeoModule dospuntocero.cl</name>
		<% include Styles %>		
		<% control Places %>
		<Placemark>
			<name>$Name</name>
			<address>$City, $State, $Zip</address>
			<description>
        		<![CDATA[
				<div id="bubble-information" class="cf">
					<div class="address">
						$City, $State, $Zip						
					</div>
					<% if Image %>
						<div class="image">
								<img src="$BaseHref<% control Image %><% control SetWidth(290) %>$URL<% end_control %><% end_control %>" />
						</div>
					<% end_if %>						
					<% if Description %>
						$Description
					<% else %>
							No existe más información acerca de este punto
					<% end_if %>
				</div>

        		]]>				
			</description>
			<styleUrl>#style1</styleUrl>			
			<Point><coordinates>$JsLng,$JsLat</coordinates></Point>
		</Placemark>
		<% end_control %>

	</Document>
</kml>