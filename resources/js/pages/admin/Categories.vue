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
    import { Label } from '@/components/ui/label'

import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet'

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

            <Sheet>
                <SheetTrigger><button>Open</button></SheetTrigger>
                <SheetContent  class="w-[800px] sm:w-[740px] sm:max-w-[800px]" side="left">
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

            <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                <DataTable :columns="columns" :data="payments" />
            </div> -->
            <!-- <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">

            </div> -->

            <div class="">
				<div class="window-header">
					<div data-v-6faa85c1="" class="half"><img data-v-6faa85c1="" class="agent circle" src="/images/ai.jpg" alt="AI Assistant" /></div>
					<div class="window-header-title chat_chat-body-title">
						<div class="window-header-main-title chat_chat-body-main-title">ExamDuctus</div>
						<div class="window-header-sub-title">AI Assistant</div>
					</div>
				</div>
				<div class="chat_chat-main">
					<div class="chat_chat-body-container">
						<div class="chat_chat-body">
							<div class="chat_chat-message">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello! How can I assist you today?</p></div>
									</div>
									<div class="chat_chat-message-action-date">Contextual Prompt</div>
								</div>
							</div>
							<div class="chat_chat-message-user">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello</p></div>
									</div>
									<div class="chat_chat-message-action-date">28/01/2025, 22:33:05</div>
								</div>
							</div>
							<div class="chat_chat-message-user">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello</p></div>
									</div>
									<div class="chat_chat-message-action-date">28/01/2025, 22:33:05</div>
								</div>
							</div>
							<div class="chat_chat-message-user">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello</p></div>
									</div>
									<div class="chat_chat-message-action-date">28/01/2025, 22:33:05</div>
								</div>
							</div>
							<div class="chat_chat-message-user">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello</p></div>
									</div>
									<div class="chat_chat-message-action-date">28/01/2025, 22:33:05</div>
								</div>
							</div>
							<div class="chat_chat-message-user">
								<div class="chat_chat-message-container">
									<div class="chat_chat-message-item">
										<div class="markdown-body" dir="auto" style="font-size: 14px; font-family: inherit;"><p node="[object Object]" dir="auto">Hello</p></div>
									</div>
									<div class="chat_chat-message-action-date">28/01/2025, 22:33:05</div>
								</div>
							</div>
						</div>
						<div class="chat_chat-input-panel">
							<label class="chat_chat-input-panel-inner" for="chat-input">
								<textarea id="chat-input" class="chat_chat-input" placeholder="Enter to send, Shift + Enter to wrap, / to search prompts, : to use commands" rows="3" spellcheck="false" style="font-size: 14px;"></textarea>
								<button class="bg-deep-blue text-white hover:bg-alt-deep-blue chat_chat-input-send" role="button">
									<div aria-label="Send" class="button_icon-button-icon no-dark">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" fill="none">
											<defs><path id="send-white_svg__a" d="M0 0h16v16H0z"></path></defs>
											<g>
												<mask id="send-white_svg__b" fill="#fff"><use xlink:href="#send-white_svg__a"></use></mask>
												<g mask="url(#send-white_svg__b)">
													<path
														d="M0 4.71 6.67 6l1.67 6.67L12.67 0 0 4.71Z"
														transform="translate(1.333 2)"
														style="stroke: rgb(255, 255, 255); stroke-width: 1.33333; stroke-opacity: 1; stroke-dasharray: 0, 0;"
													></path>
													<path d="M0 1.89 1.89 0" transform="translate(8.003 6.117)" style="stroke: rgb(255, 255, 255); stroke-width: 1.33333; stroke-opacity: 1; stroke-dasharray: 0, 0;"></path>
												</g>
											</g>
										</svg>
									</div>
								</button>
							</label>
						</div>
					</div>
				</div>
			</div>
			<!-- v-model="form.question_id" -->

        </div>
    </AppLayout>
</template>

<style lang="css">
textarea#chat-input {
    height: 100%;
    width: 100%;
    border-radius: 10px;
    border: none;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, .03);
    background-color: var(--white);
    color: var(--black);
    font-family: inherit;
    padding: 10px 90px 10px 14px;
    resize: none;
    outline: none;
    box-sizing: border-box;
    min-height: 68px;
}

label.chat_chat-input-panel-inner {
    cursor: text;
    display: flex;
    flex: 1 1;
    border-radius: 10px;
    border: 1px solid #dedede;
}

button.chat_chat-input-send {
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    cursor: pointer;
    transition: all .3s ease;
    overflow: hidden;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    outline: none;
    border: none;
    color: var(--black);
    /* background-color: #131735; */
    color: #fff;
    position: absolute;
    right: 10px;
    bottom: 28px;
}

.chat_chat-input-panel {
    position: relative;
    width: 100%;
    padding: 10px 0px 0px;
    box-sizing: border-box;
    flex-direction: column;
    border-top: 1px solid #dedede;
    /* box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, .05); */
}

.chat_chat-body {
    flex: 1 1;
    overflow: auto;
    overflow-x: hidden;
    /* padding: 20px 20px 40px; */
    position: relative;
    overscroll-behavior: none;
    max-height: 310px;
}

.chat_chat-message {
    display: flex;
    flex-direction: row;
}

.chat_chat-message-container {
    max-width: 80%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.chat_chat-message-item {
    box-sizing: border-box;
    margin-top: 10px;
    border-radius: 10px;
    background-color: rgba(0, 0, 0, .05);
    font-size: 14px;
    -webkit-user-select: text;
    -moz-user-select: text;
    user-select: text;
    word-break: break-word;
    border: var(--border-in-light);
    position: relative;
    transition: all .3s ease;
    max-width: 100%;
    padding: 10px;
}

.markdown-body {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
    margin: 0;
    color: #24292f;
    background-color: transparent;
    font-size: 14px;
    line-height: 1.5;
    word-wrap: break-word;
}

.markdown-body>:last-child {
    margin-bottom: 0 !important;
}

.markdown-body>:first-child {
    margin-top: 0 !important;
}

.markdown-body:after {
    clear: both;
}
.markdown-body:after, .markdown-body:before {
    display: table;
    content: "";
}

.chat_chat-message-action-date {
    font-size: 12px;
    opacity: .6;
    white-space: nowrap;
    transition: all .6s ease;
    color: #303030;
    text-align: right;
    width: 100%;
    box-sizing: border-box;
    padding-right: 10px;
    pointer-events: none;
    z-index: 1;
}

.chat_chat-message-user {
    display: flex;
    flex-direction: row-reverse;
}

.chat_chat-message-user>.chat_chat-message-container {
    align-items: flex-end;
}

.chat_chat-body-container {
    height: 100%;
    display: flex;
    flex-direction: column;
    flex: 1 1;
    width: 100%;
}

.chat_chat-main {
    display: flex;
    height: 100%;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.window-header {
    /* padding: 14px 20px; */
    border-bottom: 1px solid rgba(0, 0, 0, .1);
    position: relative;
    display: flex;
    /* justify-content: space-between; */
    /* align-items: center; */
}

.window-header-title.chat_chat-body-title {
    max-width: calc(100% - 100px);
    overflow: hidden;
}

.window-header-main-title.chat_chat-body-main-title {
    font-size: 20px;
    font-weight: bolder;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    max-width: 50vw;
}
</style>
