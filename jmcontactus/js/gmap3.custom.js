/*-----------------------------------------------------------------------------------*/
    /*	Google Maps
    /*-----------------------------------------------------------------------------------*/

    /* Helper function to check if a number is a float */
    function isFloat(n) {
        return parseFloat(n.match(/^-?\d*(\.\d+)?$/)) > 0;
    }

    /* Check if a string is a coordinate */
    function checkCoordinates(str) {
        if (!str) {
            return false;
        }

        str = str.split(',');
        var isCoordinate = true;

        if (str.length !== 2 || !isFloat(str[0].trim()) || !isFloat(str[1].trim())) {
            isCoordinate = false;
        }

        return isCoordinate;
    }

    $('.map').each(function() {
        /* Options */
        var gmap = {
            zoom: ($(this).attr('data-zoom')) ? parseInt($(this).attr('data-zoom')) : 15,
            address: $(this).attr('data-address'),
            markers: $(this).attr('data-markers'),
            icon: $(this).attr('data-icon'),
            typeID: $(this).attr('data-type'),
            ID: $(this).attr('id'),
            styles: $(this).attr('data-styles') ? JSON.parse($(this).attr('data-styles')) : '',
        };

        var gmapScroll = ($(this).attr('data-scroll')) ? $(this).attr('data-scroll') : 'false';
        var markersArray = [];
        var bound = new google.maps.LatLngBounds();

        if (gmapScroll == 'false') {
            gmap.draggable = false;
            gmap.scrollwheel = false;
        }

        if (gmap.markers) {
            gmap.markers = gmap.markers.split('|');

            /* Get markers and their options */
            gmap.markers.forEach(function(marker) {
                if (marker) {
                    marker = $.parseJSON(marker);

                    if (checkCoordinates(marker.address)) {
                        marker.position = marker.address.split(',');
                        delete marker.address;
                    }

                    markersArray.push(marker);
                }
            });

            /* Initialize map */
            $('#' + gmap.ID).gmap3({
                zoom: gmap.zoom,
                draggable: gmap.draggable,
                scrollwheel: gmap.scrollwheel,
                mapTypeId: google.maps.MapTypeId[gmap.typeID],
                styles: gmap.styles
            }).on({
                'tilesloaded': function() {
                    if (typeof window.anpsMapsLoaded !== 'undefined') {
                        window.anpsMapsLoaded();
                    }
                }
            }).marker(markersArray).then(function(results) {
                var center = null;

                if (typeof results[0].position.lat !== 'function' ||
                    typeof results[0].position.lng !== 'function') {
                    return false;
                }

                results.forEach(function(m, i) {
                    if (markersArray[i].center) {
                        center = new google.maps.LatLng(m.position.lat(), m.position.lng());
                    } else {
                        bound.extend(new google.maps.LatLng(m.position.lat(), m.position.lng()));
                    }
                });

                window.anpsMarkers = results;

                if (!center) {
                    center = bound.getCenter();
                }

                this.get(0).setCenter(center);
            }).infowindow({
                content: ''
            }).then(function(infowindow) {
                var map = this.get(0);
                this.get(1).forEach(function(marker) {
                    if (marker.data !== '') {
                        marker.addListener('click', function() {
                            infowindow.setContent(decodeURIComponent(marker.data));
                            infowindow.open(map, marker);
                        });
                    }
                });
            });
        } else {
            console.error('No markers found. Add markers to the Google maps item using Visual Composer.');
        }
    }); /* Each Map element */
