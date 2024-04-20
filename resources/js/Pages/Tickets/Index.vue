<script setup>
import Pagination from '@/Components/Pagination.vue'
import {reactive, ref, watch} from "vue";
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

const props = defineProps({
    tickets: Object,
})

let currentPage = ref(props.tickets.current_page);
const perPage = ref(15);

let tickets = reactive(props.tickets)

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('dashboard')
    },
    {
        title: 'Tickets',
        href: route('tickets.index')
    }
]

const users = reactive(props.tickets.data.map(ticket => ticket['user']))

let search = reactive({
    title: null,
    user_id: null,
    priority: null,
    status: null,
    submitted_from: null,
    submitted_to: null
})

watch(search, newSearchValue => {
    let params = {}

    // Prepare params for the backend search handling
    Object.keys(newSearchValue).forEach(key => {
        if (newSearchValue[key]) params[`filter[${key}]`] = newSearchValue[key]
    })

    return router.get(route('tickets.index'), params, {
        preserveState: true,
        onSuccess: res => {
            tickets.data = res.props.tickets.data
            tickets.total = res.props.tickets.total
        }
    })
})

watch(currentPage, value => {
    router.get(route('tickets.index'), { page: value }, { preserveState: true })
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-100">Tickets</h1>
                    <Breadcrumbs :items="breadcrumbs" />
                </div>
                <a href="/tickets/create"
                   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Ticket
                </a>
            </div>
            <div class="overflow-x-auto shadow  sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Submitted
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Priority
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                &nbsp;
                            </th>

                        </tr>

                        <tr class="border-t border-t-gray-700">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Filter
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <div>
                                    <label for="from" class="text-white">From</label> <br />
                                    <input v-model="search.submitted_from" type="date" id="from" class="input">
                                </div>
                                <div class="mt-4">
                                    <label for="from" class="text-white">To</label> <br />
                                    <input v-model="search.submitted_to" type="date" class="input">
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <input v-model="search.title" type="text" class="input" placeholder="Title">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <select v-model="search.user_id" class="w-full input">
                                    <option
                                        v-for="(user, index) in users"
                                        :key="index"
                                        :value="user.id"
                                    >{{ user.name }}</option>
                                </select>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <select v-model="search.priority" class="w-full input">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                <select v-model="search.status" class="w-full input">
                                    <option value="open">Open</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{ ticket.title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.priority }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            <Link :href="route('tickets.show', [ticket.id])">
                                View
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <Pagination
                    :total-items="tickets.total"
                    :current-page.sync="currentPage"
                    :per-page="perPage"
                    @update:currentPage="currentPage = $event"
                />
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style>
.input {
    @apply bg-gray-900 rounded focus:shadow-none;
}
</style>

