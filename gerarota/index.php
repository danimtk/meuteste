<!doctyp html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Get Latitude and Longitude</title>

    
  <!-- Mobile support -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
        
     <!-- Material Design fonts -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="css/boostrap.min.css" rel="stylesheet">

  <!-- Bootstrap Material Design -->
  <link href="dist/css/bootstrap-material-design.css" rel="stylesheet">
  <link href="dist/css/ripples.min.css" rel="stylesheet">

  <!-- Dropdown.js -->
  <link href="css/jquery.dropdown.css" rel="stylesheet">

  <!-- Page style -->
  <link href="index.css" rel="stylesheet">

  <!-- jQuery -->
  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyB6K1CFUQ1RwVJ-nyXxd6W0rfiIBe12Q&libraries=places" type="text/javascript"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="https://googlemaps.github.io/js-map-label/src/maplabel-compiled.js" type="text/javascript"> </script>

    
</head>
<body style="margin: 0px;" >
    <div class="col-md-12" style="position:fixed; z-index: 1000;">
                            <div class="col-md-4">
                                <div style="color: #333;" class="form-group">
                                    <input style="background: #fff; padding-left: 20px;" type="text" id="name" class="form-control" placeholder="Nome do arquivo de rota">
                                </div>
                            </div>
                            <div class="col-md-5"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="javascript:void(0)" class="btn btn-raised btn-info">Gerar arquivo de rota</div></a>   
                                </div>
                            </div>
                        </div>

<div id="map_canvas" style="height: 100%;width: 100%;"></div>

<script>
     $(function () {
         
         var marker_id = 1;
         
         var coordenadas = [];
         
         function saveCoordenada(id, lat, lng) 
         {
            var coordenada = {'lat' : lat , 'lng' : lng};
            
            coordenadas.push(coordenada); 
            
            marker_id ++;
            addMarker(id, lat, lng);
         }

         var myStyles = [
            {
                featureType: "poi",
                elementTypeS: "labels",
                stylers: [
                    { visibility: "off" }
                ]
            }
        ];
         
         var lat = -28.2592564,
             lng = -52.4112256,
             
            latlng = new google.maps.LatLng(lat, lng),
            image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

         var mapOptions = {
            center: new google.maps.LatLng(lat, lng),
            zoom: 15,
            styles : myStyles,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: false,
            scrollwheel: false,
            streetViewControl: false,
            TiltGestures: false,
            AllGestures: false,
            ZoomGestures: false,
            ScrollGestures: false,
            zoomControl: true
         },
         
         map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
             
            marker = new google.maps.Marker({
                 position: latlng,
                 map: map
             });

        var infowindow = new google.maps.InfoWindow();

        google.maps.event.addListener(marker, "dblclick", function (e) { 
            e.preventDefault();  
        });
        
        
         google.maps.event.addListener(map, 'click', function (event) 
         {
            latlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
          
            saveCoordenada(marker_id, event.latLng.lat(), event.latLng.lng());
            
            infowindow.close();
         });
          
         
         function addMarker(id, lat, lng) {
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                id : id,
                icon: image
             });
             
             var mapLabel = new MapLabel({
                text: id,
                position: new google.maps.LatLng(lat, lng),
                map: map,
                optimized: false,
                zIndex: 8888,
                fontSize: 18,
                align: 'center'
            });
        
            marker.bindTo('map', mapLabel);
            marker.bindTo('position', mapLabel);
         }
        
         function moveMarker(placeName, latlng) {
             marker.setIcon(image);
             marker.setPosition(latlng);
             infowindow.setContent(placeName);
         }
     
    
     
     $(document).on('click', 'a', function() 
     {
        var parameters = {};
        
        parameters['coor'] = coordenadas;
        
        if($('input#name').val() != "") {
            if(coordenadas.length > 3) {
                $.ajax({
                    type: 'POST', 
                    url: 'controller/writeJson.php',
                    dataType: 'json',
                    data : {'coor' : coordenadas, 'name' : $('input#name').val() },
                    success: function (data) {
                       if(data['ret']== true) {
                           alert('Criou, '+data['msg']);
                       } else {
                           alert('Ops, '+data['msg']);
                       }
                    } 
                });
            }else {
                alert('pelo menos 4 coordenadas');
            }
        } else {
            alert('insira o nome do arquivo');
        }
     });
     });
</script>
 <script src="dist/js/material.js"></script>
        <script src="dist/js/ripples.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                $.material.init();
                initMap();
            });
        </script>
</body>
</html>