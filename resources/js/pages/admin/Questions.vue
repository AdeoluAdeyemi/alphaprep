<script setup lang="ts">
    //import type { Payment } from '@/components/payments/columns'
    import { onMounted, ref } from 'vue'
    import { columns, payments } from '@/components/payments/columns'
    import DataTable from '@/components/ui/data-table/DataTable.vue'
    import AppLayout from '@/layouts/AppLayout.vue';
    import { type BreadcrumbItem } from '@/types';
    import { Button } from '@/components/ui/button';
    import { Switch } from '@/components/ui/switch';
    import { Label } from '@/components/ui/label';
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
        DialogScrollContent,
        DialogDescription,
        DialogFooter,
        DialogHeader,
        DialogTitle,
        DialogTrigger,
    } from '@/components/ui/dialog';
    import { Input } from '@/components/ui/input';

    import {
        Select,
        SelectContent,
        SelectGroup,
        SelectItem,
        SelectLabel,
        SelectTrigger,
        SelectValue,
    } from '@/components/ui/select'
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Questions',
            href: '/admin/questions',
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
                    Questions
                </h2>
                <div class="flex items-center space-x-2">
                    <Dialog class="create">
                        <DialogTrigger>
                            <!-- <Button size="sm" class="relative">
                                Add Podcast
                            </Button> -->
                            <Button class="h-9">
                                <CirclePlus class="mr-2 h-4 w-4" />
                                Add Question
                            </Button>
                        </DialogTrigger>
                        <DialogScrollContent>
                            <DialogHeader>
                                <DialogTitle>Add Question</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="name">Exam</Label>

                                        <Select>
                                            <SelectTrigger class="">
                                                <SelectValue placeholder="Select an exam" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Exam</SelectLabel>
                                                    <SelectItem value="apple">
                                                    Apple
                                                    </SelectItem>
                                                    <SelectItem value="banana">
                                                    Banana
                                                    </SelectItem>
                                                    <SelectItem value="blueberry">
                                                    Blueberry
                                                    </SelectItem>
                                                    <SelectItem value="grapes">
                                                    Grapes
                                                    </SelectItem>
                                                    <SelectItem value="pineapple">
                                                    Pineapple
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <InputError :message="form.errors.name" />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="email">Type</Label>

                                        <Select>
                                            <SelectTrigger class="">
                                                <SelectValue placeholder="Select a type" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Type</SelectLabel>
                                                    <SelectItem value="apple">
                                                    Apple
                                                    </SelectItem>
                                                    <SelectItem value="banana">
                                                    Banana
                                                    </SelectItem>
                                                    <SelectItem value="blueberry">
                                                    Blueberry
                                                    </SelectItem>
                                                    <SelectItem value="grapes">
                                                    Grapes
                                                    </SelectItem>
                                                    <SelectItem value="pineapple">
                                                    Pineapple
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <InputError :message="form.errors.email" />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="city">Question*</Label>
                                    <QuillEditor theme="snow" toolbar="full" />

                                    <InputError :message="form.errors.city" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="state">Explanation*</Label>
                                    <QuillEditor :modules="modules" theme="snow" toolbar="full" />

                                    <InputError :message="form.errors.state" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="state">Position*</Label>
                                    <Input
                                        id="state"
                                        type="text"
                                        v-model="form.state"
                                        required
                                        autofocus
                                        autocomplete="state"
                                    />

                                    <InputError :message="form.errors.zip_code" />
                                </div>
                            </div>
                            <DialogFooter>
                                <Button class="h-9">Save Question</Button>
                            </DialogFooter>
                        </DialogScrollContent>
                    </Dialog>
                    <Dialog class="edit">
                        <DialogTrigger>
                            <!-- <Button size="sm" class="relative">
                                Add Podcast
                            </Button> -->
                            <Button class="h-9">
                                <Pencil class="mr-2 h-4 w-4" />
                                Edit Question
                            </Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogHeader>
                                <DialogTitle>Edit Question</DialogTitle>
                                <DialogDescription>
                                    Fields with asterisks <span class="text-red-600">(*)</span> are mandatory fields.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="grid gap-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="grid gap-2">
                                        <Label for="name">Exam</Label>

                                        <Select>
                                            <SelectTrigger class="">
                                                <SelectValue placeholder="Select an exam" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Exam</SelectLabel>
                                                    <SelectItem value="apple">
                                                    Apple
                                                    </SelectItem>
                                                    <SelectItem value="banana">
                                                    Banana
                                                    </SelectItem>
                                                    <SelectItem value="blueberry">
                                                    Blueberry
                                                    </SelectItem>
                                                    <SelectItem value="grapes">
                                                    Grapes
                                                    </SelectItem>
                                                    <SelectItem value="pineapple">
                                                    Pineapple
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <InputError :message="form.errors.name" />
                                    </div>

                                    <div class="grid gap-2">
                                        <Label for="email">Type</Label>

                                        <Select>
                                            <SelectTrigger class="">
                                                <SelectValue placeholder="Select a type" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectLabel>Type</SelectLabel>
                                                    <SelectItem value="apple">
                                                    Apple
                                                    </SelectItem>
                                                    <SelectItem value="banana">
                                                    Banana
                                                    </SelectItem>
                                                    <SelectItem value="blueberry">
                                                    Blueberry
                                                    </SelectItem>
                                                    <SelectItem value="grapes">
                                                    Grapes
                                                    </SelectItem>
                                                    <SelectItem value="pineapple">
                                                    Pineapple
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                        <InputError :message="form.errors.email" />
                                    </div>
                                </div>

                                <div class="grid gap-2">
                                    <Label for="city">Question*</Label>
                                    <QuillEditor theme="snow" toolbar="full" />

                                    <InputError :message="form.errors.city" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="state">Explanation*</Label>
                                    <QuillEditor :modules="modules" theme="snow" toolbar="full" />

                                    <InputError :message="form.errors.state" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="state">Position*</Label>
                                    <Input
                                        id="state"
                                        type="text"
                                        v-model="form.state"
                                        required
                                        autofocus
                                        autocomplete="state"
                                    />

                                    <InputError :message="form.errors.zip_code" />
                                </div>
                            </div>
                            <DialogFooter>
                                <Button class="h-9">Update Question</Button>
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
