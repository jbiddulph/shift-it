<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Access todos from the Inertia page props
const { props } = usePage();
console.log('Todos:', props);
const todos = props.todos || []; // Fallback to an empty array


</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="text-2xl font-bold">Your Todos</h1>
            <ul class="space-y-4">
                <li
                    v-for="todo in todos"
                    :key="todo.id"
                    class="p-4 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                >
                    <h2 class="text-lg font-semibold text-black dark:text-white">{{ todo.title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ todo.description }}</p>
                    <span
                        class="inline-block mt-2 px-2 py-1 text-sm font-medium rounded-full"
                        :class="{
                            'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100': todo.completed,
                            'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100': !todo.completed,
                        }"
                    >
                        {{ todo.completed ? 'Completed' : 'Pending' }}
                    </span>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>