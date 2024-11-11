<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import InputGroup from '@/Components/InputGroup.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
//import { c } from 'vite/dist/node/types.d-aGj9QkWt';
//importar los props (variables del controlador)
const props = defineProps({
	empleados:{type:Object}, puestos:{type:Object}
}); 
//crear formulario
const form = useForm({nombre:'',apellidos:'',puesto_id:'',email:''});
const v =ref({id:'',nombre:'',apellidos:'',capacitacions:[],email:''});
const showModalView= ref(false);
const showModalForm= ref(false);
const showModalDel= ref(false);
const nombre = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalView = (e) =>{
	v.value.nombre = e.apellidos+' '+e.nombre;
	v.value.puesto = e.puesto.puesto;
	v.value.capacitacions = e.capacitacions;
	showModalView.value=true;
}
const openModalForm = (op,e) =>{
	console.log("Modal abierto para:", op, e);
	showModalForm.value=true;
	operation.value = op;
	if( op === 1){
		nombre.value = 'Crear empleado'
		form.nombre = e.nombre;
		form.reset();
	}else{
		nombre.value = 'Editar empleado'
		form.nombre = e.nombre;
		form.apellidos = e.apellidos;
        form.puesto_id = e.puesto_id;
		
		form.email = e.email;
		v.value.id = e.id;
	}
}
const openModalDel = (e) =>{
	showModalDel.value=true;
	v.value.id = e.id;
	v.value.nombre = e.apellidos+' '+e.nombre;
}
const closeModalView = () =>{
	showModalView.value=false;
}
const closeModalForm = () =>{
	showModalForm.value=false;
	form.reset();
}
const closeModalDel = () =>{
	showModalDel.value=false;
}
const save = () =>{
	if(operation.value === 1){
		form.post(route('empleados.store'),{
			onSuccess: () => {ok('Empleado añadido correctamente')}
		});
	}else{
	form.put(route('empleados.update',v.value.id),{
			onSuccess: () => {ok('Empleado modificado correctamente')}
		});
	}	
}
const ok = (m) =>{
	if(operation.value == 2){
		closeModalForm();
	}
	closeModalDel();
	form.reset();
	msj.value = m;
	classMsj.value = 'block'
	setTimeout(()=>{
		classMsj.value = 'hidden';
	}, 6000)
}

const deleteEmpleado = () =>{
	form.delete(route('empleados.destroy',v.value.id),{
		onSuccess: () => { ok('Empleado eliminado') }
	})
}

</script>

<template>
    <Head title="Empleados"/>
    <AuthenticatedLayout>
		<template #header> Empleados 
			<DarkButton @click="openModalForm(1,e)"><i fa-solid fa-trash><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
        </svg>
        </i></DarkButton>
		</template>
		<!--div de mensaje-->
		<div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
				<div class="flex justify-center items-center w-12 bg-green-600">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                    </svg>
				</div>
				
				<div class="px-4 py-2 -mx-3">
					<div class="mx-3">
						<span class="font-semibold text-red-500">Succes</span>
						<p class="text-sm text-gray-600">{{ msj }}</p>
					</div>
				</div>
			</div>
		
		<div class="w-full overflow-hidden rounded-lg border shadow-md">
			<div class="w-full overflow-x-auto bg-white">
				<table class="w-full whitespace-no-wrap">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                           <th class="px-4 py-3">#</th>
                           <th class="px-4 py-3">Nombre</th>
                           <th class="px-4 py-3">Apellidos</th>
                           <th class="px-4 py-3">Puesto</th>

						   <th class="px-4 py-3">E-mail</th>
						   <th class="px-4 py-3">Detalle</th>
						   <th class="px-4 py-3">Editar</th>
						   <th class="px-4 py-3">Eliminar</th>
                        </tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
						<tr v-for="e,i in empleados" :key="e.id" class="text-white">
							<td class="px-4 py-3 text-sm">
								{{ (i+1) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (e.nombre) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (e.apellidos) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (e.puesto.puesto) }}
							</td>


							<td class="px-4 py-3 text-sm">
								{{ (e.email) }}
							</td>
							<td class="px-4 py-3 text-sm">
								<SecondaryButton @click="openModalView(e)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                  </svg>
                                </SecondaryButton>
							</td>
							<td class="px-4 py-3 text-sm">
								<WarningButton @click="openModalForm(2,e)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                  </svg>
                                </WarningButton>
							</td>
							<td class="px-4 py-3 text-sm">
								<DangerButton @click="openModalDel(e)">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                </DangerButton>
							</td>
						</tr>
                    </tbody>
				</table>
			</div>
		</div>
		<Modal :show="showModalView" @close="closeModalView">
			<div class="p-6">
				<p>Empleado: <span class="text-lg font-medium text-gray-900">{{ v.nombre }}</span></p>
				<p>Puesto: <span class="text-lg font-medium text-gray-900">{{ v.puesto }}</span></p>
				Capacitaciones tomadas:
				<ol>
					<li class="text-lg font-medium text-gray-900" v-for="c,i in v.capacitacions">
						{{ (1+1)+')'+ c.nombre}}
					</li>
				</ol>
			</div>
			<div class="mt-6" flex justify-end>
				<SecondaryButton @click="closeModalView">Cancelar</SecondaryButton>
			</div>
		</Modal>

		<Modal :show="showModalForm" @close="closeModalForm">
			<div class="p-6">
				<h2 class="text-lg font-medium text-gray-900">{{ nombre }}</h2>
				<div class="mt-6 mb-6 space-y-6 max-w-xl">
					<InputGroup :text="'Nombre'" :required="'required'" v-model="form.nombre" type="text">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
					</InputGroup>
					<InputError class="mt-1" :message="form.errors.nombre"></InputError>

					<InputGroup :text="'Apellidos'" :required="'required'" v-model="form.apellidos" type="text">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
					</InputGroup>
					<InputError class="mt-1" :message="form.errors.apellidos"></InputError>

					<SelectInput :text="'Puesto'" :required="'required'" v-model="form.puesto_id" :options="puestos">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
					</SelectInput>
					<InputError class="mt-1" :message="form.errors.puesto_id"></InputError>
					


					<InputGroup :text="'E-mail'" :required="'required'" v-model="form.email" type="email">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                        </svg>
					</InputGroup>
					<InputError class="mt-1" :message="form.errors.email"></InputError>					

					<PrimaryButton @click="save"> Guardar 
					</PrimaryButton>
				</div>
			</div>
			<div class="mt-6" flex justify-end>
				<SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
			</div>
		</Modal>

		<Modal :show="showModalDel" @close="closeModalDel">
			<div class="p-6">
				<p class="text-2xl font-medium text-gray-900">
					Do you really want to delete
				<span class="text-2xl font-medium text-gray-900">{{ v.nombre }}</span> ? </p>
				<PrimaryButton @click="deleteEmpleado">Yes, I do</PrimaryButton>
			</div>
			<div class="mt-6" flex justify-end>
				<SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
			</div>
		</Modal>
	</AuthenticatedLayout>
</template>