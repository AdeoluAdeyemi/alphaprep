<script setup lang="ts">
    //import type { Payment } from '@/components/payments/columns'
    import { onMounted, ref } from 'vue'
    import { columns, payments } from '@/components/payments/columns'
    import DataTable from '@/components/ui/data-table/DataTable.vue'
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Button } from '@/components/ui/button';
    import Editor from '@/components/Editor.vue';
    import ChatCard from '@/components/ChatCard.vue';
    import { CirclePlus, Pencil } from 'lucide-vue-next'
    import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import InputError from '@/components/InputError.vue';
    import {
        Dialog,
        DialogContent,
        DialogDescription,
        DialogFooter,
        DialogHeader,
        DialogTitle,
        DialogTrigger,
    } from '@/components/ui/dialog';
    import { Input } from '@/components/ui/input'

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Examinations',
            href: '/admin/exams',
        },
    ];


const form = useForm({
    email: '',
    password: '',
    remember: false,
});
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
    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <DataTable :columns="columns" :data="payments" /> -->
            <div class="flex items-center justify-between space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">
                    Categories
                </h2>
                <div class="flex items-center space-x-2">
                    <Dialog class="create">
                        <DialogTrigger>
                            <!-- <Button size="sm" class="relative">
                                Add Podcast
                            </Button> -->
                            <Button class="h-9">
                                <CirclePlus class="mr-2 h-4 w-4" />
                                Add Category
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Add Category</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4 py-4">
                                <div class="grid gap-2">
                                    <Label for="email">Name</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        autofocus
                                        :tabindex="1"
                                        autocomplete="email"
                                        v-model="form.email"
                                        placeholder="email@example.com"
                                    />
                                    <InputError :message="form.errors.email" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="url">Description</Label>
                                    <Editor />
                                </div>
                            </div>
                            <DialogFooter>
                                <Button class="h-9">Save Category</Button>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                    <Dialog class="edit">
                        <DialogTrigger>
                            <!-- <Button size="sm" class="relative">
                                Add Podcast
                            </Button> -->
                            <Button class="h-9">
                                <Pencil class="mr-2 h-4 w-4" />
                                Edit Category
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Edit Category</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4 py-4">
                                <div class="grid gap-2">
                                    <Label for="email">Name</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        autofocus
                                        :tabindex="1"
                                        autocomplete="email"
                                        v-model="form.email"
                                        placeholder="email@example.com"
                                    />
                                    <InputError :message="form.errors.email" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="url">Description</Label>
                                    <Editor />
                                </div>
                            </div>
                            <DialogFooter>
                                <Button class="h-9">Update Category</Button>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                </div>
            </div>

            <div class="container mx-auto">
                <DataTable :columns="columns" :data="payments" />
            </div>
        </div>
    </AppLayout>
</template>
