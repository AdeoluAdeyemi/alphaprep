<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { columns, payments } from '@/components/payments/columns'
import DataTable from '@/components/ui/data-table/DataTable.vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
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
} from '@/components/ui/sheet'

import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'

import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Exam',
        href: '/myaccount/exam',
    },
];


const form = useForm({
    email: '',
    password: '',
    remember: false,
});

import {
    RadioGroup,
    RadioGroupItem,
} from '@/components/ui/radio-group'

const plans = [
    {
        id: 'starter',
        name: 'Starter Plan',
        description:
        'Perfect for small businesses getting started with our platform',
        price: '$10',
    },
    {
        id: 'pro',
        name: 'Pro Plan',
        description: 'Advanced features for growing businesses with higher demands',
        price: '$20',
    },
    {
        id: 'pro',
        name: 'Pro Plan',
        description: 'Advanced features for growing businesses with higher demands',
        price: '$20',
    },
    {
        id: 'pro',
        name: 'Pro Plan',
        description: 'Advanced features for growing businesses with higher demands',
        price: '$20',
    },
] as const
</script>

<template>
    <Head title="Exam" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <DataTable :columns="columns" :data="payments" /> -->
            <div class="flex items-center justify-between space-y-2">
                <h2 class="text-2xl font-semibold tracking-tight">
                    Exam
                </h2>
                <div class="flex items-center space-x-2">
                    <Pagination v-slot="{ page }" :items-per-page="10" :total="100" :sibling-count="1" show-edges :default-page="2">
                        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                        <PaginationFirst />
                        <PaginationPrev />

                        <template v-for="(item, index) in items">
                            <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                            <Button class="w-9 h-9 p-0" :variant="item.value === page ? 'default' : 'outline'">
                                {{ item.value }}
                            </Button>
                            </PaginationListItem>
                            <PaginationEllipsis v-else :key="item.type" :index="index" />
                        </template>

                        <PaginationNext />
                        <PaginationLast />
                        </PaginationList>
                    </Pagination>
                </div>
            </div>

            <div class="grid auto-rows-min">
                <Card>
                    <CardHeader>
                        <CardTitle class="question_number font-semibold text-lg text-gray-800 mb-3">Create project</CardTitle>
                        <CardDescription>Deploy your new project in one-click.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form>
                            <div class="grid items-center w-full gap-4">
                                <div class="flex flex-col space-y-1.5">
                                    <RadioGroup default-value="starter">
                                        <Label
                                            v-for="plan in plans"
                                            :key="plan.id"
                                            class="hover:bg-accent/50 flex items-start gap-3 rounded-lg border p-4 has-[[data-state=checked]]:border-green-600 has-[[data-state=checked]]:bg-green-50 dark:has-[[data-state=checked]]:border-green-900 dark:has-[[data-state=checked]]:bg-green-950"
                                        >
                                            <RadioGroupItem
                                            :id="plan.name"
                                            :value="plan.id"
                                            class="shadow-none data-[state=checked]:border-green-600 data-[state=checked]:bg-green-600 *:data-[slot=radio-group-indicator]:[&>svg]:fill-white *:data-[slot=radio-group-indicator]:[&>svg]:stroke-white"
                                            />
                                            <div class="grid gap-1 font-normal">
                                                <div class="font-medium">{{ plan.name }}</div>
                                            </div>
                                        </Label>
                                    </RadioGroup>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                    <CardFooter class="flex justify-between px-6 pb-6">
                    <Button variant="outline">Ask AI</Button>
                        <Sheet>
                            <SheetTrigger variant="outline" class="">Ask AI</SheetTrigger>
                            <SheetContent  class="w-[800px] sm:w-[740px] sm:max-w-[800px]" side="right">
                                <SheetHeader>
                                    <SheetTitle>Are you absolutely sure?</SheetTitle>
                                    <SheetDescription>
                                    This action cannot be undone. This will permanently delete your account
                                    and remove your data from our servers.
                                    <ChatCard />
                                    </SheetDescription>
                                </SheetHeader>
                            </SheetContent>
                        </Sheet>
                        <Button>Deploy</Button>
                    </CardFooter>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
