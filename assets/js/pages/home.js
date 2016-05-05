$(function() {
    function initialize() {
        var marker;
        var mapProp;
        if (locations.length > 0) {
            mapProp = {
                center:new google.maps.LatLng(locations[0].lat, locations[0].lng),
                zoom:4,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
            $.each(locations, function(index, val) {
                var marker = new google.maps.Marker({
                    position: {lat: val.lat, lng: val.lng},
                    map: map
                });
            });

        }
        else {
            mapProp = {
                center:new google.maps.LatLng(51.508742, -0.120850),
                zoom:5,
                mapTypeId:google.maps.MapTypeId.ROADMAP
                };
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }
    }
    if ($("#googleMap").length > 0)
    {
        google.maps.event.addDomListener(window, 'load', initialize);
    }
})