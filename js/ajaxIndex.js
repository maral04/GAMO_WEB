$(document).ready(function () {
    $('#sports img').on('click', function () {
        id = $(this).attr('id').replace('img-', '');
        if($(this).hasClass("icon-selected"))window.location.replace("index.php");
        else window.location.replace("index.php?sport="+id);
        /*if ($(this).hasClass('icon-selected')) {
         $('#' + id).prop("checked", false);

         $(this).removeClass('icon-selected');
         } else {
         $('#sports input').prop("checked", false);
         $('#sports img').removeClass('icon-selected');

         $('#' + id).prop("checked", true);
         $(this).addClass('icon-selected');
         }*/
    });
    $(".accordion").on("click", function () {
        //Si troba la class "active", no fa la funció.
        if ($(this).hasClass("active")) {

            //Apunta fletxes amunt.
            $('.cte', this).rotate({
                duration: 1,
                angle: 0,
                animateTo: 180
            })

            var id = $(this).attr('eventid');

            $.ajax({
                // la URL para la petición
                url: 'http://'+$("#ipServer").val()+'/GAMO_WEB/api/events/getProves.php',

                // la información a enviar
                // (también es posible utilizar una cadena de datos)
                data: {eventId: id},

                // especifica si será una petición POST o GET
                type: 'GET',

                // el tipo de información que se espera de respuesta
                dataType: 'json',

                // código a ejecutar si la petición es satisfactoria;
                // la respuesta es pasada como argumento a la función
                success: function (json) {

                    //Recupero la primera prova per saber a quin event pertanyen totes les proves.
                    idDiv = json[0].FK_Id_event;

                    //Eliminem el contingut del panel.
                    $("[eventpanelid='" + idDiv + "']").empty();

                    for (var i = 0; i < json.length; i++) {

                        //El block general de cada prova redirigeix a la fitxa de la prova.
                        $("[eventpanelid='" + idDiv + "']").append("" +
                            "<div class='block3 click' onclick='location.href=\"fitxaProva.php?id=" + json[i].Id + "\"'\>" +
                            "<div class='block2'>" +
                            "<div class='grid_2'>" +
                                <!-- Imatges (prova) -->
                            "<img class='' src='images/proves/"+json[i].Id+"/"+json[i].Imatges+"' alt=''>" +
                            "</div>" +
                            "<div class='grid_4 g4Gran'>" +
                                <!-- nom (prova) -->
                            "<h4>" + json[i].nom + "</h4>" +
                                <!-- FK_Id_Localitzacio (prova) poblacio (localitzacio) -->
                            "<a>" + json[i].poblacio + "</a>" +
                            "<div class='fRight'>" +
                                <!-- data_hora_inici (prova) -->
                            "<a>" + json[i].data_hora_inici + "</a>" +
                            "</div>" +

                            "<div class='descripcioProva'>" +
                                <!-- descripcio (prova) -->
                            "<a>" + json[i].descripcio + "</a>" +
                            "</div>" +
                            "<a>Max. Participants: " + json[i].limit_inscrits + "</a>" +
                            "<div class='gran grid_1 fRight'>" +
                                <!-- Max Members, desnivellPositiu, Distancia -->
                            json[i].distancia
                            + "Km</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "");
                    }
                },
                // código a ejecutar si la petición falla;
                // son pasados como argumentos a la función
                // el objeto de la petición en crudo y código de estatus de la petición
                error: function (request, status, error) {
                    alert(request.responseText);
                },

                // código a ejecutar sin importar si la petición falló o no
                complete: function (xhr, status) {
                }
            });
        } else {
            //Apunta fletxes abaix.
            $('.cte', this).rotate({
                duration: 1,
                angle: 0,
                animateTo: 0
            })
        }
    });
});
