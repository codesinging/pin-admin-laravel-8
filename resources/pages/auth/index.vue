<template>
    <div>
        {{ message }}
        <input v-model="message">
    </div>
</template>

<script setup>
    import {ref} from "vue";

    const message = ref('hello world');
</script>

<style scoped>

</style>
