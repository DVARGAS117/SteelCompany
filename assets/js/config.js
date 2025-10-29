$(function(){
    /*********************************************/
    /*************** AUTENTICACION ***************/
    /*********************************************/
    $("#bingresa").click(function(){
        Validar();
        return false;
    })
    /*********************************************/
    $("#usuario").keypress(function(e){
        if(e.which == 13){
            Validar();
            return false;
        }
    })
    /*********************************************/
    $("#clave").keypress(function(e){
        if(e.which == 13){
            Validar();
            return false;
        }
    })
    /*********************************************/
    function Validar(){
        var usuario = $("#usuario").val();
        var clave   = $("#clave").val();
        if(usuario==''){
            alert("¡Error, debe ingresar su usuario!");
            $("#usuario").focus();
            return false;
        }
        if(clave==''){
            alert("¡Error, debe ingresar su contraseña!");
            $("#clave").focus();
            return false;
        }
        autenticarUsuario();
    }
    /*********************************************/
    function autenticarUsuario(){
        $("#proceso").val('IniciarProceso');
        var EnviarDatos = $("#formulariologin").serialize();
        $.ajax({
            data        : EnviarDatos,
            url         : 'config/validar-usuarios.php',
            type        : 'POST',
            dataType    : 'json',
            beforeSend   : function(){
                $("#bingresa").val('Procesando Datos, Espere...');
            },
            success     : function(datos){
                var respuesta = datos.respuesta;
                if(respuesta=='SI'){
                    $("#bingresa").val('Redireccionando, Espere...');
                    setTimeout(function(){
                        window.location.href = "dashboard.php";
                    }, 3000)
                }else{
                    $("#bingresa").val('¡Error, datos incorrectos!');
                    setTimeout(function(){
                        $("#usuario").val('');
                        $("#clave").val('');
                        $("#bingresa").val('INGRESAR AHORA');
                        $("#usuario").focus();
                    },3000)
                }
            }
        })
    }
    /*********************************************/
})