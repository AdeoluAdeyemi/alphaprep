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
import { Separator } from '@/components/ui/separator';
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
import { Label } from '@/components/ui/label'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';

import ExamLayout from '@/layouts/ExamLayout.vue';

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Categories',
            href: '/categories',
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

    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Categories" />

        <ExamLayout>
            <div class="flex flex-col space-y-6">
                <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 py-4">
                                <h2 class="font-semibold py-2">Card Content</h2>
                                <p>Test description</p>
                            </CardContent>
                            <CardFooter class="pb-6">
                                <Button variant="outline" class="h-7 px-3">Open</Button>
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                    </div>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 py-4">
                                <h2 class="font-semibold py-2">Card Content</h2>
                                <p>Test description</p>
                            </CardContent>
                            <CardFooter class="pb-6">
                                <Button variant="outline" class="h-7 px-3">Open</Button>
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                    </div>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 py-4">
                                <h2 class="font-semibold py-2">Card Content</h2>
                                <p>Test description</p>
                            </CardContent>
                            <CardFooter class="pb-6">
                                <Button variant="outline" class="h-7 px-3">Open</Button>
                            </CardFooter>
                        </Card>
                        <Card class="shadow-md">
                            <CardHeader class="flex flex-col gap-y-1.5 p-6 py-2">
                                <CardTitle>
                                    <img class="w-32" src="https://web-assets.zendesk.com/is/image/zendesk/Shopify_Default?$primary=%2311110D&$secondary=%235d5d59&$tertiary=%23777773&fmt=webp-alpha&qlt=65&scale=2" /> </CardTitle>
                                <!-- <CardDescription>Card Description</CardDescription> -->
                            </CardHeader>
                            <Separator />
                            <CardContent class="p-6 font-semibold py-4">
                                Card Content
                            </CardContent>
                            <CardFooter class="pb-6">
                                Card Footer
                            </CardFooter>
                        </Card>
                    </div>
                </div>
            </div>
        </ExamLayout>
    </AppLayout>
</template>
