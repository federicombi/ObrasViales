

const SELECT_MAQUINA = document.getElementById('select_maquina');
agregarEventos();

function agregarEventos(){
    document.getElementById('select_tipo').addEventListener('change', evento_select_tipo);
    const end_allocation_button =document.querySelector('.end_allocation_button');
    if(end_allocation_button){
        end_allocation_button.addEventListener('click', event=>{
            const dataset = end_allocation_button.dataset;
            end_allocation(dataset, "machine");
        });
    }

    const ADD_KM_BUTTON = document.getElementById('add_km_button');
    if(ADD_KM_BUTTON){
        ADD_KM_BUTTON.addEventListener('click', event=>{
            const id_machine = ADD_KM_BUTTON.dataset.id_machine;
            const id_destino = ADD_KM_BUTTON.dataset.id_machine;
            add_km(id_machine, "machine", id_destino);
        });
    }
}

async function evento_select_tipo(){
    const tipoId = this.value;
    SELECT_MAQUINA.disabled = true;
    SELECT_MAQUINA.innerHTML = '<option selected disabled>Cargando...</option>';
    let 
        cargaron_las_maquinas = true,
        link = '/maquinas/by_type/'+tipoId;

    const 
        maquinas = await fetchear(link).catch(error => {error_al_cargar_opciones_de_select(error); cargaron_las_maquinas = false;});

    if(cargaron_las_maquinas){
        agregar_maquinas_a_Select(maquinas);
    }

}

function agregar_maquinas_a_Select(maquinas){
    SELECT_MAQUINA.innerHTML = '<option selected disabled>Elija una máquina</option>';
    maquinas.forEach(maquina => {
        const option = document.createElement('option');
        option.value = maquina.id;
        option.textContent = maquina.series; 
        SELECT_MAQUINA.appendChild(option);
    });
    SELECT_MAQUINA.disabled = false;
}

function error_al_cargar_opciones_de_select(error){
    SELECT_MAQUINA.innerHTML = '<option selected disabled>Error al cargar</option>';
    console.error(error);
}
/*
async function end_allocation(){
    const boton = document.querySelector('.end_allocation_button');
    var all_id = 1;
    await Swal.fire({
        allowOutsideClick:false,
        title: "Estás seguro?",
        html: `La <b>`+boton.dataset.machine_type+` `+boton.dataset.machine+`</b><br> ya no se podrá utilizar en <br><b>`+boton.dataset.construction+`</b>
            <br><br><b style="color:darkblue;">Motivo de fin:</b>
            <select id="select_motivo" class="swal2-select" style="text-align:center;">
                <option value="">Cargando...</option>
            </select>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        didOpen: async () => {
            agregar_motivos(boton.dataset.link_motivos);
        },
        preConfirm: () => {
            all_id = document.getElementById("select_motivo").value;
        },
    }).then(async (result) => {
        if (result.isConfirmed) {
            try{
                const allocation = JSON.parse(boton.dataset.allocation);
                const datos = {
                    "id": allocation.id,
                    "start_date": allocation.start_date,
                    "end_date": new Date().toISOString(),
                    "machine_id": allocation.machine_id,
                    "construction_id":allocation.construction_id,
                    "allocation_end_motive_id": ""+all_id
                }; 
                const continuar = agregar_inputs_a_form_m(datos, "end_allocation_form");
                if(continuar){
                    const end_allocation_form = document.getElementById("end_allocation_form");
                    end_allocation_form.submit();
                }
                
            }  catch (error) {
                console.error('Error al guardar:', error);
                Swal.showValidationMessage('Error al cargar motivos');
            }
        }
    });
}
*/
async function agregar_inputs_a_form_m(datos, id_formulario){ 
    const formulario = document.getElementById(id_formulario);
    Object.entries(datos).forEach(([propiedad, valor]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.id = "input"+propiedad;
        input.name = propiedad;
        input.value = valor;
        formulario.appendChild(input);
    });
    return true;
}

async function eliminar_inputs(datos){
    try{
        Object.entries(datos).forEach(([propiedad, value]) => {
            const input = document.getElementById("input"+propiedad);
            input.value = value;
            if (input) {
                input.remove();
            }
        });
        return true;
    }catch{
        return false;
    }
    
}
