<script setup>

import Form from './Form.vue';

const props = defineProps({
    empleados:{type:Object},
    capacitacion:{type:Object},
    empleadosOfCap:{type:Object},
});
</script>

<template>
    <Form :empleados="empleados" :capacitacion="capacitacion" 
    :empleadosOfCap="empleadosOfCap" />
</template>