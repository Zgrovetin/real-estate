
<template>
    <Link href="/">Main page</Link>&nbsp;
    <Link href="/hello">Show page</Link>

    <slot>Default</slot>
</template>

<!--<style scoped>-->

<!--</style>-->

<script setup>
    import { Link } from '@inertiajs/vue3'
</script>
