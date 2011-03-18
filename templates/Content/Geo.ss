<script type="text/javascript">
var geoXml = null;
            jQuery(document).ready(function(){
                var myOptions = {
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                
                geoXml = new geoXML3.parser({
                    map: map,
                    singleInfoWindow: false,
                    afterParse: useTheData
                });
                //geoXml.parse('{$BaseHref}{$URLSegment}/Places');
            });
            
            function useTheData(doc){
                for (var i = 0; i < doc[0].markers.length; i++) {
                    jQuery('#map_text').append(doc[0].markers[i].title + ', ');
                }
            };

   function hide_markers_kml(){

            geoXml.hideDocument();  // see geoxml3-modify: http://geocontext.org/pliki/2010/test-geoxml3/test2/geoxml3-modify.js

   }

   function unhide_markers_kml(){

            geoXml.showDocument();  // see geoxml3-modify: http://geocontext.org/pliki/2010/test-geoxml3/test2/geoxml3-modify.js

   }


        </script>
  <button onclick="hide_markers_kml();">hide markers</button>
  <button onclick="unhide_markers_kml();">unhide markers</button>
        <div id="map_canvas" style="width:   100%;	height:  480px;	margin:  0;	padding: 0; background: #000;">
        </div>
        <div id="map_text">
        </div>		
$Content