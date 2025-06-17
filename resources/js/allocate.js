agregarEventos();

async function agregarEventos(){
    const SELECT_TIPO = document.getElementById('select_tipo');
    SELECT_TIPO.addEventListener('change', evento=>{
        const tipoId = SELECT_TIPO.value;
        evento_select_tipo('/maquinas/available_by_type/'+tipoId);
    });
    const BOTON_OK = document.getElementById("ok_button");
    BOTON_OK.addEventListener('click', evento=>{
        confirmar();
    });
}

async function confirmar(){
    const select_obra = document.getElementById('select_obra');
    const select_maquina = document.getElementById('select_maquina');
    const select_tipo = document.getElementById("select_tipo");
    let 
    maquina_seleccionada = select_maquina.options[select_maquina.selectedIndex].textContent,
    tipo_maquina = select_tipo.options[select_tipo.selectedIndex].textContent,
    obra_seleccionada = select_obra.options[select_obra.selectedIndex].textContent;
    const result = await Swal.fire({
        allowOutsideClick:false,
        title: "¿Está seguro?",
        icon: "warning",
        html:`<b>Se asignará la <br>
        <spam class="important">`+tipo_maquina+` `+maquina_seleccionada+`</spam> <br>
        a la obra en <br>
        <spam class="important">`+obra_seleccionada+`</spam> </b><h1><br>
        `,
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
    });
    if (result.isConfirmed) {
        const datos = {
            "construction_id": select_obra.value,
            "machine_id": select_maquina.value,
        };
        const continuar = await agregar_inputs_a_form(datos, "allocate_form", "obras", select_obra.value);
        const listo = await datos_guardados("Se guardó el kilometraje de hoy.");
        ///// CAMBIAR ESTA PARTE DESDE EL IF PARA QUE GUARDE LA ALLOCATION NUEVA.

        if(continuar && listo){
            const add_km_form = document.getElementById("add_km_form");
            add_km_form.submit();
        }

    }else{
    console.log("NOPE");
    return;
    }



}

