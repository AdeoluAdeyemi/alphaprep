<script setup lang="ts" generic="TData, TValue">
    import type { ColumnDef, Updater, SortingState, ColumnFiltersState, ExpandedState } from '@tanstack/vue-table'
    import { ChevronLeft, ChevronsLeft, ChevronRight, ChevronsRight } from 'lucide-vue-next'
    import {
        Table,
        TableBody,
        TableCell,
        TableHead,
        TableHeader,
        TableRow,
    } from '@/components/ui/table'

    import {
        FlexRender,
        getCoreRowModel,
        getPaginationRowModel,
        getFilteredRowModel,
        getSortedRowModel,
        getExpandedRowModel,
        useVueTable,
    } from '@tanstack/vue-table'

    import { valueUpdater } from '@/lib/utils'

    import { Input } from '@/components/ui/input'
    import { Button } from '@/components/ui/button'

    import {
        Select,
        SelectContent,
        SelectItem,
        SelectTrigger,
        SelectValue,
    } from '@/components/ui/select'

    import { ref } from 'vue'

    const props = defineProps<{
        columns: ColumnDef<TData, TValue>[]
        data: TData[]
    }>()

    const sorting = ref<SortingState>([])
    const columnFilters = ref<ColumnFiltersState>([])
    const expanded = ref<ExpandedState>({})

    const table = useVueTable({
        get data() { return props.data },
        get columns() { return props.columns },
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        getExpandedRowModel: getExpandedRowModel(),
        onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
        onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
        onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
        state: {
            get sorting() { return sorting.value },
            get columnFilters() { return columnFilters.value },
            get expanded() { return expanded.value },
        },
    })
</script>

<template>
    <div class="flex items-center justify-between py-4 space-x-2">
        <Input class="max-w-sm h-8 py-1" placeholder="Filter emails..."
            :model-value="table.getColumn('email')?.getFilterValue() as string"
            @update:model-value=" table.getColumn('email')?.setFilterValue($event)" />
        <!-- <Button>Add Provider</Button> -->
    </div>
    <div class="border rounded-md">
        <Table>
            <TableHeader>
                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                <TableHead v-for="header in headerGroup.headers" :key="header.id" class="px-2">
                    <FlexRender
                    v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                    :props="header.getContext()"
                    />
                </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() ? 'selected' : undefined">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id" class="p-2">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length" class="p-2">
                                    Email: {{ row.getValue('email') }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>
                <template v-else>
                    <TableRow>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                        No results.
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>
    <div class="flex items-center justify-end py-4 space-x-2">
        <!-- <Button
            variant="outline"
            size="sm"
            :disabled="!table.getCanPreviousPage()"
            @click="table.previousPage()"
        >
            Previous
        </Button>
        <Button
            variant="outline"
            size="sm"
            :disabled="!table.getCanNextPage()"
            @click="table.nextPage()"
        >
            Next
        </Button> -->
        <div class="flex items-center space-x-6 lg:space-x-8">
        <div class="flex items-center space-x-2">
            <p class="text-sm font-medium">
                Rows per page
            </p>
            <Select
            :model-value="`${table.getState().pagination.pageSize}`"
            @update:model-value="table.setPageSize"
            >
            <SelectTrigger class="h-8 w-[70px]">
                <SelectValue :placeholder="`${table.getState().pagination.pageSize}`" />
            </SelectTrigger>
            <SelectContent side="top">
                <SelectItem v-for="pageSize in [10, 20, 30, 40, 50]" :key="pageSize" :value="`${pageSize}`">
                {{ pageSize }}
                </SelectItem>
            </SelectContent>
            </Select>
        </div>
        <div class="flex w-[100px] items-center justify-center text-sm font-medium">
            Page {{ table.getState().pagination.pageIndex + 1 }} of
            {{ table.getPageCount() }}
        </div>
        <div class="flex items-center space-x-2">
            <Button
            variant="outline"
            class="hidden w-8 h-8 p-0 lg:flex"
            :disabled="!table.getCanPreviousPage()"
            @click="table.setPageIndex(0)"
            >
            <span class="sr-only">Go to first page</span>
            <ChevronsLeft class="w-4 h-4" />
            </Button>
            <Button
            variant="outline"
            class="w-8 h-8 p-0"
            :disabled="!table.getCanPreviousPage()"
            @click="table.previousPage()"
            >
            <span class="sr-only">Go to previous page</span>
            <ChevronLeft class="w-4 h-4" />
            </Button>
            <Button
            variant="outline"
            class="w-8 h-8 p-0"
            :disabled="!table.getCanNextPage()"
            @click="table.nextPage()"
            >
            <span class="sr-only">Go to next page</span>
            <ChevronRight class="w-4 h-4" />
            </Button>
            <Button
            variant="outline"
            class="hidden w-8 h-8 p-0 lg:flex"
            :disabled="!table.getCanNextPage()"
            @click="table.setPageIndex(table.getPageCount() - 1)"
            >
            <span class="sr-only">Go to last page</span>
            <ChevronsRight class="w-4 h-4" />
            </Button>
        </div>
        </div>
    </div>
</template>
