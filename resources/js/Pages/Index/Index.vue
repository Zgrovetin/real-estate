<!--<template>Hello {{ counter }}!</template>-->

<!--<script setup>-->
<!--    import {ref} from 'vue'-->
<!--    const counter = ref(0)-->
<!--    setInterval(()=> counter.value++, 1000)-->
<!--</script>-->

<template>
    <MainLayout>
        <div>Index</div>
        <Link href="/hello">Show page</Link>
        <div>
            The message is {{message}}
        </div>
    </MainLayout>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'
    import MainLayout from "../../Layouts/MainLayout.vue";

    defineProps({
        message: String
    })
</script>
