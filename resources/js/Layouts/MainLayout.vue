
<template>
    <Link href="/">Main page</Link>&nbsp;
    <Link href="/hello">Show page</Link>
    <div>The page with time {{timer}}</div>

    <slot>Default</slot>
</template>

<!--<style scoped>-->

<!--</style>-->

<script setup>
    import { Link } from '@inertiajs/vue3'
    import {ref} from 'vue'

    const timer = ref(0)
    setInterval(() => timer.value++, 1000)
</script>
