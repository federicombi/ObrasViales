
function agregarEventos(){
    document.getElementById('select_provincia').addEventListener('change', function(){evento_select_principal('select_provincia','select_construction', '/obras/by_province/')});
    evento_add_km();
    evento_end_allocations();
}

agregarEventos();

async function agregar_a_select (SELECT, datos){
    SELECT.innerHTML = '<option selected disabled>Elija una obra...</option>';
    datos.forEach(provincia => {
        const option = document.createElement('option');
        option.value = provincia.id;
        option.textContent = provincia.name; 
        SELECT.appendChild(option);
    });
    SELECT.disabled = false;
    return;
}

async function evento_select_principal(id_select_cat, select_id, link){
    const SELECT_CAT = document.getElementById(id_select_cat);
    const opcion = SELECT_CAT.value;

    const SELECT = document.getElementById(select_id);
    SELECT.disabled = true;
    SELECT.innerHTML = '<option selected disabled>Cargando...</option>';
    let 
    cargaron_los_datos = true,
    enlace =  link+opcion;
    const datos = await fetchear(enlace).catch(error => {error_al_cargar_opciones_de_select(error, SELECT); cargaron_los_datos = false;});
    if(cargaron_los_datos){
        agregar_a_select(SELECT, datos);
    }
    return;
}

async function evento_add_km() {
    const ADD_KM_BUTTONS = document.querySelectorAll('.add_km_button');
    ADD_KM_BUTTONS.forEach(button => {
        button.addEventListener('click', event=>{
            const id_machine = button.dataset.id_machine;
            const id_destino = button.dataset.id_destino;
            add_km(id_machine, "construction", id_destino);
        });
    });
}

async function evento_end_allocations() {
    const END_ALLOCATION_BUTTONS =document.querySelectorAll('.end_allocation_button');
    if(END_ALLOCATION_BUTTONS.length >0){
        END_ALLOCATION_BUTTONS.forEach(button => {
            button.addEventListener('click', event=>{
                const dataset = button.dataset;
                end_allocation(dataset, "construction");
            });
        });
    } 
}