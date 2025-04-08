import { h } from 'vue'
import DropdownAction from '@/components/DataTableDropDown.vue'
import type { ColumnDef } from '@tanstack/vue-table'
import { Button } from '@/components/ui/button';
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next';

export const columns: ColumnDef<Payment>[] = [
    {
        accessorKey: 'status',
        header: () => h('div', { class: 'relative' }, 'Status'),
        cell: ({ row }) => {
            const rowText = row.getValue('status')
            // const capitalHeader = rowText.charAt(0).toUpperCase() + rowText.slice(1)

            // return h('div', { class: 'relative' }, capitalHeader)

            return  h('div', { class: 'capitalize' }, row.getValue('status'))
        },
    },
    {
        accessorKey: 'email',
        // header: () => h('div', { class: 'relative' }, 'Email'),
        // cell: ({ row }) => {

        //     const email = row.getValue('email')

        //     return h('div', { class: 'relative' }, email)
        // },
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email')),

    },
    {
        accessorKey: 'amount',
        header: () => h('div', { class: 'text-right' }, 'Amount'),
        cell: ({ row }) => {
            const amount = Number.parseFloat(row.getValue('amount'))
            const formatted = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            }).format(amount)

            return h('div', { class: 'text-right font-medium' }, formatted)
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const payment = row.original

            return h('div', { class: 'relative' }, h(DropdownAction, {
                payment,
                onExpand: row.toggleExpanded,
            }))
        },
    },
]

interface Payment {
    id: string
    amount: number
    status: 'pending' | 'processing' | 'success' | 'failed'
    email: string
}

export const payments: Payment[] = [
    {
        id: 'm5gr84i9',
        amount: 316,
        status: 'success',
        email: 'ken99@yahoo.com',
    },
    {
        id: '3u1reuv4',
        amount: 242,
        status: 'success',
        email: 'Abe45@gmail.com',
    },
    {
        id: 'derv1ws0',
        amount: 837,
        status: 'processing',
        email: 'Monserrat44@gmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    },
    {
        id: 'bhqecj4p',
        amount: 721,
        status: 'failed',
        email: 'carmella@hotmail.com',
    }
]
