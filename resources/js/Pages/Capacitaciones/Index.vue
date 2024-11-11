<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DarkButton from '@/Components/DarkButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
//importar los props (variables del controlador)
const props = defineProps({
	capacitacions:{type:Object}, flash:{type:Object}
}); 
const form = useForm({id:'',nombre:''}); //title
const showModalDel = ref(false);
const msj = ref( (props.flash.success != null) ? props.flash.success : '');
const classMsj = ref( (props.flash.success != null) ? '': 'hidden');

const openModalDel = (c) =>{
    form.id = c.id;
    form.nombre = c.nombre;
    showModalDel.value = true;
}
const closeModalDel = () =>{
    showModalDel.value = false;
}
const deleteCap = () =>{
	form.delete(route('capacitacions.destroy',form.id),{
		onSuccess: () =>{ok('Capacitacion eliminada')}
	});
}
const ok = (m) =>{
	closeModalDel();
	form.reset();
	msj.value = m;
	classMsj.value = 'block'
	setTimeout(()=>{
		classMsj.value = 'hidden';
	}, 6000)
}

</script>

<template>
    <Head title="Capacitaciones"/>
    <AuthenticatedLayout>
		<template #header> Capacitaciones
			
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
                           <th class="px-4 py-3">Empresa</th>
                           <th class="px-4 py-3">Descripcion</th>
						   <th class="px-4 py-3">Duracion</th>
						   <th class="px-4 py-3">Imagen</th>
						   <th class="px-4 py-3">Detalle</th>
						   <th class="px-4 py-3">Editar</th>
						   <th class="px-4 py-3">Eliminar</th>
                        </tr>
					</thead>
					<tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
						<tr v-for="c,i in capacitacions.data" :key="c.id" class="text-white">
							<td class="px-4 py-3 text-sm">
								{{ (i+1) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (c.nombre) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (c.empresa) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (c.descripcion) }}
							</td>
							<td class="px-4 py-3 text-sm">
								{{ (c.duracion) }}
							</td>
							<td class="px-4 py-3 text-sm">
								<img :src="'storage'+c.imagen" width="50">
							</td>
							<td class="px-4 py-3 text-sm">
							<NavLink :href="route('capacitacions.show',c.id)">
								<SecondaryButton >
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                  </svg>
                                </SecondaryButton>
							</NavLink>
							</td>
							<td class="px-4 py-3 text-sm">
								<NavLink :href="route('capacitacions.edit',c.id)">
								<WarningButton>
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                  </svg>
                                </WarningButton>
								</NavLink>
							</td>
							<td class="px-4 py-3 text-sm">
								<DangerButton @click="openModalDel(c)">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                </DangerButton>
							</td>
						</tr>
                    </tbody>
				</table>
			</div>
            <div
			    class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
			    <pagination :links="capacitacions.links" />
			</div>
		</div>
		<Modal :show="showModalDel" @close="closeModalDel">
			<div class="p-6">
				<p class="text-2xl font-medium text-gray-900">
					Do you really want to delete
				<span class="text-2xl font-medium text-gray-900">{{ form.nombre }}</span> ? </p>
				<PrimaryButton @click="deleteCap">Yes, I do</PrimaryButton>
			</div>
			<div class="mt-6" flex justify-end>
				<SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
			</div>
		</Modal>
	</AuthenticatedLayout>
</template>