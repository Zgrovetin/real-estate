
<template>
<!--    <Link href="/listing">Listings</Link>&nbsp;-->
<!--    <Link href="/listing/create">Create new listing</Link>-->
    <Link :href="route('listing.index')"> Listings </Link>
    <Link :href="route('listing.create')"> Create new listing </Link>
<!--    <div>The page with time {{timer}}</div>-->
    <div v-if="flashSuccess" class="success">
        {{ flashSuccess }}
    </div>

    <slot>Default</slot>
</template>

<!--<style scoped>-->

<!--</style>-->

<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    // page.props.value.flash.success
    const page = usePage()
    const flashSuccess = computed(() => page.props.flash.success)
    // import {ref} from 'vue'

    // const timer = ref(0)
    // setInterval(() => timer.value++, 1000)
</script>

<style scoped>
    .success {
        background-color: green;
        color: white;
    }
</style>
