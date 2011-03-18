<a href="contacto">
	<img src="http://maps.google.com/staticmap?zoom=14&amp;size=300x170&amp;maptype=mobile
	&amp;markers=<% control SiteConfig %><% control Places %>$Lat,$Lng,<% if IsHQ %>yellow<% else %>smallblue<% end_if %><% if Last %><% else %>|<% end_if %><% end_control %><% end_control %>&amp;key=$GetKey&amp;sensor=false" alt="$Title"/>		
</a>