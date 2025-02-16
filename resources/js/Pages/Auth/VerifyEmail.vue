<template>
    <div>You need to be verified first to see this page</div>
    <div>
        <Link
            :href="route('verification.send')"
            method="post" as="button"
            class="text-orange-600 dark:text-orange-400">
            Resend verification email
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
