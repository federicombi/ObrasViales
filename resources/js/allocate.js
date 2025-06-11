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
        html:`<b>Se asignará la `+tipo_maquina+` `+maquina_seleccionada+`a la obra en `+obra_seleccionada+`</b><h1><br>
        `,
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar"
    });
    if (result.isConfirmed) {
        console.log("se confirmo");
    }else{
        console.log("NOPE");
        return;
    }



}

