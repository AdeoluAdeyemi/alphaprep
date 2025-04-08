<script setup lang="ts">
    //import type { Payment } from '@/components/payments/columns'
    import { onMounted, ref } from 'vue'
    import { columns, payments } from '@/components/payments/columns'
    import DataTable from '@/components/ui/data-table/DataTable.vue'
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Head } from '@inertiajs/vue3';
    import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Demo',
            href: '/demo',
        },
    ];
    // const data = ref<Payment[]>([])

    // async function getData(): Promise<Payment[]> {
    //     // Fetch data from your API here.
    //     return [
    //         {
    //             id: '728ed52f',
    //             amount: 100,
    //             status: 'pending',
    //             email: 'm@example.com',
    //         },
    //         // ...
    //     ]
    // }

    // onMounted(async () => {
    //     data.value = await getData()
    // })
</script>

<template>
    <Head title="Demo" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <DataTable :columns="columns" :data="payments" /> -->

            <div class="container mx-auto">
                <DataTable :columns="columns" :data="payments" />
            </div>
            <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                <DataTable :columns="columns" :data="payments" />
            </div> -->
            <!-- <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

            </div> -->
        </div>
    </AppLayout>
</template>
