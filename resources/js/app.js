import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


window.fetchear = async function (link){
    try {
        const response = await fetch(link);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al cargar:', error);
        throw error;
    }
}

window.error_al_cargar_opciones_de_select = async function (error, SELECT){
    SELECT.innerHTML = '<option selected disabled>Error al cargar</option>';
    console.error(error);
    return;
}

window.add_km = async function (id_machine, destino, id_destino){
    let 
    horas_de_uso = "";

    const { value: km } = await Swal.fire({
        allowOutsideClick:false,
        title: "Agregar horario", 
        icon: "info", 
        showCancelButton: true, 
        confirmButtonText: "Guardar", 
        cancelButtonText: "Cancelar",
        input: "number",
        inputLabel: "Kilómetros recorridos",
        inputAttributes: {
            min: 0 
        },
        inputValidator: (value) => {
            if (!value) {
                return "Falta ingresar la cantidad de kilómetros";
            }
            if(value<1){
                return "Verifique la cantidad de kilómetros"
            }else if(value > 300){
                return "El kilometraje máximo por jornada es de 300 km"
            }
        },
        html:`
                Horas de uso: <input type="time" id="swal_horas_de_uso" class="swal_horas_de_uso" value="01:00" max="12:00"></input> <br>
        `,
        preConfirm: () => {
            horas_de_uso = document.getElementById("swal_horas_de_uso").value;
        }
    });
    esta_seguro_trail(id_machine, horas_de_uso, km, destino, id_destino);
    return;
}

window.esta_seguro_trail = async function (id_machine, horas_de_uso, km, destino, id_destino){
    if(km){
        const result = await Swal.fire({
            allowOutsideClick:false,
            title: "¿Está seguro?",
            icon: "warning",
            html:`<b><span class="importante">Esta información no se podrá borrar:</span><br><br>
                <h1>Kilómetros: <span class="importante">`+km+` km</span><h1><br>
                <h1>Horas de uso: <span class="importante">`+horas_de_uso+` hs</span></b><h1><br>
            `,
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmar y Guardar",
            cancelButtonText: "Cancelar"
            });
        if (result.isConfirmed) {
            const datos = {
                "km":km,
                "date": new Date().toISOString(),
                "use_time": horas_de_uso,
                "machine_id": id_machine
            };
            const continuar = await agregar_inputs_a_form(datos, "add_km_form", destino, id_destino);
            const listo = await datos_guardados("Se guardó el kilometraje de hoy.");

            if(continuar && listo){
                const add_km_form = document.getElementById("add_km_form");
                add_km_form.submit();
            }

        }else{
            add_km();
            return;
        }
    }

}

window.agregar_inputs_a_form = async function (datos, id_formulario, destino, id_destino){ 
    const formulario = document.getElementById(id_formulario);
    Object.entries(datos).forEach(([propiedad, valor]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.id = "input"+propiedad;
        input.name = propiedad;
        input.value = valor;
        formulario.appendChild(input);
    });
    
    const input_destino = document.createElement('input');
    input_destino.type = 'hidden';
    input_destino.id = "input_destino";
    input_destino.name = "destino";
    input_destino.value = destino;
    formulario.appendChild(input_destino);

    const input_id_destino = document.createElement('input');
    input_id_destino.type = 'hidden';
    input_id_destino.id = "input_id_destino";
    input_id_destino.name = "id_destino";
    input_id_destino.value = id_destino;
    formulario.appendChild(input_id_destino);
    return true;
}

window.datos_guardados = async function(texto){
    const listo = await Swal.fire({
        title: "Guardado!",
        text: texto,
        icon: "success",
        timer: 1800,
    });
    if (listo){ return true}
}

window.end_allocation = async function(dataset, destino){
    var end_motive_id = 1;
    await Swal.fire({
        allowOutsideClick:false,
        title: "Estás seguro?",
        html: `La <b>`+dataset.machine_type+` `+dataset.machine+`</b><br> ya no se podrá utilizar en <br><b>`+dataset.construction+`</b>
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
            agregar_motivos(dataset.link_motivos); /// reVER ESTO
        },
        preConfirm: () => {
            end_motive_id = document.getElementById("select_motivo").value;
        },
    }).then(async (result) => {
        if (result.isConfirmed) {
            try{
                const allocation = JSON.parse(dataset.allocation);
                const datos = {
                    "id": allocation.id,
                    "start_date": allocation.start_date,
                    "end_date": new Date().toISOString(),
                    "machine_id": allocation.machine_id,
                    "construction_id":allocation.construction_id,
                    "allocation_end_motive_id": ""+end_motive_id
                }; 
                const continuar = agregar_inputs_a_form(datos, "end_allocation_form", destino, allocation.id);
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

window.agregar_motivos = async function(ruta){
    try {
        const motivos = await fetchear(ruta).catch(error => {console.log(error)});
        const select_motivo = document.getElementById('select_motivo');
        
        select_motivo.innerHTML = '';
        const opcion_falsa = document.createElement('option');
        opcion_falsa.textContent = "Elije un motivo...";
        opcion_falsa.diabled = true;
        opcion_falsa.selected = true;
        opcion_falsa.hidden = true;
        select_motivo.appendChild(opcion_falsa);
        motivos.forEach(motivo => {
            const opcion_motivo = document.createElement('option');
            opcion_motivo.value = motivo.id;
            opcion_motivo.textContent = motivo.motive;
            select_motivo.appendChild(opcion_motivo);
        });
    }  catch (error) {
        console.error('Error al cargar motivos:', error);
        Swal.showValidationMessage('Error al cargar motivos');
    }
}

window.evento_select_tipo = async function(link){
    const SELECT_MAQUINA = document.getElementById('select_maquina');
    SELECT_MAQUINA.disabled = true;
    SELECT_MAQUINA.innerHTML = '<option selected disabled>Cargando...</option>';
    let 
        cargaron_las_maquinas = true;
    const 
        maquinas = await fetchear(link).catch(error => {error_al_cargar_opciones_de_select(error); cargaron_las_maquinas = false;});
    if(cargaron_las_maquinas){
        agregar_maquinas_a_Select(maquinas);
    }
}

function agregar_maquinas_a_Select(maquinas){
    const SELECT_MAQUINA = document.getElementById('select_maquina');
    SELECT_MAQUINA.innerHTML = '<option selected disabled>Elija una máquina</option>';
    maquinas.forEach(maquina => {
        const option = document.createElement('option');
        option.value = maquina.id;
        option.textContent = maquina.series; 
        SELECT_MAQUINA.appendChild(option);
    });
    SELECT_MAQUINA.disabled = false;
}