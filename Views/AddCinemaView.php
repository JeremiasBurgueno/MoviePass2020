
<?php 

require_once("navbar.php");
?> 

<body>
<div class="container">
        <!-- Inicio Index -->
        <div id="box" class="row justify-content-center" style="background-color: rgba(255, 255, 255, 0.5);">
            <div class="col-md-10 text-center m-auto">
                <h1 class="" id="cinemaTitle"><i class="fas fa-film"></i></i>&nbsp;</i>Cines</h1>
            </div>
            <!-- form     -->
            <div class="col-md-10">
            <?php require_once("alertMessage.php");?>
            <form action = "<?php echo FRONT_ROOT ?>Cinema/Add" method="post">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6">
                            <label for="inputNombre"><i style="color: red;">&#42&nbsp</i>Nombre</label>
                            <input type="text" class="form-control" id="inputNombre" placeholder="Nombre" name="cinemaName" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputProvincia"><i style="color: red;">&#42&nbsp</i>Provincia</label>
                            <select id="inputProvincia" class="form-control" required>
                                <option selected>Elije una</option>
                                <?php 
                                    foreach ($states as $state) {
                                        echo ('<option value="' . $state->getIdState() . '">' . $state->getStateName() . '</option>');
                                    } 
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCiudad"><i style="color: red;">&#42&nbsp</i>Ciudad</label>
                            <select id="inputCiudad" class="form-control" name="cityId" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-6">
                            <label for="inputDireccion"><i style="color: red;">&#42&nbsp</i>Dirección</label>
                            <input type="text" class="form-control" id="inputNombre" placeholder="Dirección" name="address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNumero"><i style="color: red;">&#42&nbsp</i>Número</label>
                            <input type="number" min="1" max="9999" class="form-control" id="inputNombre" placeholder="Número" name="number" required>
                        </div>                        
                    </div>                    
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>&nbspAgregar nuevo Cine</button>
                    <a type="button" href="<?php echo FRONT_ROOT ?>Cinema/ShowListView" class="btn btn-primary"><i class="fas fa-arrow-left"></i>&nbspVolver</a>
                </form>
                <!-- form -->
            </div>
        </div>
        <!-- Fin Index -->
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>


</body>

<script>
  
   
  $(document).ready(function(){
  
    $("#inputCiudad").prop('disabled', true);

    function loadCities(provincia, datos){

        var url = <?php echo FRONT_ROOT ?> + "Cinema/LoadCities";        
        var ciudades = $("#inputCiudad");

        if(provincia.val() != '') {

          $.ajax({ 
            url: url,
            method: 'POST',
            data: datos,
            context: 'document.body',
            beforeSend: function () 
            {
                provincia.prop('disabled', true);
            },
            success:  function (r) 
            {
                provincia.prop('disabled', false);
                // Limpiamos el select
                ciudades.find('option').remove();
                ciudades.append("<option value=''>Elija una...</option>");

                var jsonText = r.substring(r.indexOf('$')+1 ,r.indexOf('%'));
                var json = JSON.parse(jsonText);
                
                $(json).each(function(i, v){ 
                    ciudades.append('<option value="' + v.IdCity + '">' + v.CityName + '</option>');
                })

                ciudades.prop('disabled', false);
            },
            error: function(jqXHR, textStatus )
            {
                alert('Ocurrio un error en el servidor: ' + textStatus);
                provincia.prop('disabled', false);
            }

          });
        }  
        else
        {
            ciudades.find('option').remove();
            ciudades.prop('disabled', true);
        }
    }

    $('#inputProvincia').change(function() {

      var id = $(this).val();
      var datos = { idState: id };
      var provincia = $("#inputProvincia");

      loadCities(provincia, datos);

    });

  });

</script>


<style>
#box {
    margin-top: 2%;
    min-height: 85vh !important;
    border-radius: 25px;
}

</style>