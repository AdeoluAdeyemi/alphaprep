<script setup lang="ts">
    import { Button } from '@/components/ui/button'
    import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
    import { Pencil, Trash, Trash2, Eye } from 'lucide-vue-next'

    defineProps<{
        payment: {
            id: string
        }
    }>()

    defineEmits<{
        (e: 'expand'): void
    }>()

    function copy(id: string) {
        navigator.clipboard.writeText(id)
    }
</script>


<template>
    <div class="flex items-center space-x-2">
        <Button
            variant="outline"
            class="w-[80px] h-8 p-0 lg:flex flex text-blue-500 border border-blue-500 hover:bg-blue-500 hover:text-white hover:border-blue-500">
            <Eye class="w-4 h-4" />
            <span>View</span>
        </Button>
        <Button
            variant="outline"
            class="w-[80px] h-8 p-0 lg:flex flex text-green-500 border border-green-500 hover:bg-green-500 hover:text-white hover:border-green-500">
            <Pencil class="w-4 h-4" />
            <span>Edit</span>
        </Button>
        <Button
            variant="outline"
            class="w-[80px] h-8 p-0 lg:flex flex text-red-500 border border-red-500  hover:bg-red-500 hover:text-white hover:border-red-500">
            <Trash2 class="w-4 h-4" />
            <span>Delete</span>
        </Button>
    </div>
</template>
