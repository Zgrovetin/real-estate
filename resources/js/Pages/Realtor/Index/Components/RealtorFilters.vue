<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    id="deleted"
                    type="checkbox"
                    v-model="filterForm.deleted"
                    class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500" />
                <label for="deleted">Deleted</label>
            </div>
        </div>
    </form>
</template>

<script setup>
    import { reactive, watch } from 'vue';
    import { router } from '@inertiajs/vue3';

    const filterForm = reactive({
        deleted: false,
    })
// reactive / ref / computed
    watch(
        filterForm, () => router.get(
            route('realtor.listing.index'),
            filterForm,
            {preserveState: true, preserveScroll: true}
        ),
    )
</script>
