<script setup>

import Form from './Form.vue';

const props = defineProps({
    empleados:{type:Object}
});
</script>

<template>
    <Form :empleados="empleados" />
</template>