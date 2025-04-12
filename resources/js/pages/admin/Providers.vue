<script setup lang="ts">
    //import type { Payment } from '@/components/payments/columns'
    import { onMounted, ref } from 'vue'
    import { columns, payments } from '@/components/payments/columns'
    import DataTable from '@/components/ui/data-table/DataTable.vue'
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Button } from '@/components/ui/button';
    import { Switch } from '@/components/ui/switch'
    import Editor from '@/components/Editor.vue';
    import ChatCard from '@/components/ChatCard.vue';
    import { CirclePlus, Pencil } from 'lucide-vue-next'
    import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import ImageUploader from '@/components/ImageUploader.vue';
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

    import {
        Select,
        SelectContent,
        SelectGroup,
        SelectItem,
        SelectLabel,
        SelectTrigger,
        SelectValue,
    } from '@/components/ui/select'
    import { Input } from '@/components/ui/input'
    import { Label } from '@/components/ui/label'

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Providers',
            href: '/admin/providers',
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
    <Head title="Providers" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <DataTable :columns="columns" :data="payments" /> -->
            <div class="flex items-center justify-between space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">
                    Providers
                </h2>
                <div class="flex items-center space-x-2">
                    <Dialog class="create">
                        <DialogTrigger>
                            <!-- <Button size="sm" class="relative">
                                Add Podcast
                            </Button> -->
                            <Button class="h-9">
                                <CirclePlus class="mr-2 h-4 w-4" />
                                Add Provider
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Add Provider</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="name">Name</Label>
                                        <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                                        <InputError :message="form.errors.name" />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="email">Slug</Label>
                                        <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                                        <InputError :message="form.errors.email" />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="password">Provider Logo*</Label>

                                    <ImageUploader
                                        v-model="form.logo"
                                        label="Provider Logo"
                                        required
                                        :error="form.errors.logo"
                                    />
                                    <InputError :message="form.errors.password" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="city">URL*</Label>
                                        <Input
                                            id="city"
                                            type="text"
                                            v-model="form.city"
                                            required
                                            autofocus
                                            autocomplete="city"
                                        />

                                        <InputError :message="form.errors.city" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="state">Category*</Label>
                                        <Input
                                            id="state"
                                            type="text"
                                            v-model="form.state"
                                            required
                                            autofocus
                                            autocomplete="state"
                                        />

                                        <InputError :message="form.errors.state" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <div class="flex items-center space-x-2">
                                        <Switch id="airplane-mode" />
                                        <Label for="airplane-mode">Choose Status</Label>

                                        <InputError :message="form.errors.zip_code" />
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Switch id="airplane-mode" />
                                        <Label for="airplane-mode">Featured provider</Label>

                                        <InputError :message="form.errors.country" />
                                    </div>
                                </div>

                            </div>
                            <DialogFooter>
                                <Button type="submit" class="mt-2 h-9" tabindex="5" :disabled="form.processing">
                                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                    Save Provider
                                </Button>
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
                                Edit Provider
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Edit Category</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="name">Name</Label>
                                        <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Full name" />
                                        <InputError :message="form.errors.name" />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="email">Slug</Label>
                                        <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                                        <InputError :message="form.errors.email" />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="password">Provider Logo*</Label>

                                    <ImageUploader
                                        v-model="form.logo"
                                        label="Provider Logo"
                                        required
                                        :error="form.errors.logo"
                                    />
                                    <InputError :message="form.errors.password" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="city">URL*</Label>
                                        <Input
                                            id="city"
                                            type="text"
                                            v-model="form.city"
                                            required
                                            autofocus
                                            autocomplete="city"
                                        />

                                        <InputError :message="form.errors.city" />
                                    </div>
                                    <div class="grid gap-2">
                                        <Label for="state">Category*</Label>
                                        <Input
                                            id="state"
                                            type="text"
                                            v-model="form.state"
                                            required
                                            autofocus
                                            autocomplete="state"
                                        />

                                        <InputError :message="form.errors.state" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <div class="flex items-center space-x-2">
                                        <Switch id="airplane-mode" />
                                        <Label for="airplane-mode">Choose Status</Label>

                                        <InputError :message="form.errors.zip_code" />
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <Switch id="airplane-mode" />
                                        <Label for="airplane-mode">Featured provider</Label>

                                        <InputError :message="form.errors.country" />
                                    </div>
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
