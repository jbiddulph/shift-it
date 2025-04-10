<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { computed, reactive } from 'vue';
import Swal from 'sweetalert2';

const $toast = useToast();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Access todos from the Inertia page props
const { props } = usePage();
const todos = reactive(props.todos || []); // Make todos reactive

interface Todo {
    id: number;
    title: string;
    description: string;
    status: string;
}

// Computed properties to filter todos
const pendingTodos = computed(() => todos.filter((todo) => todo.status !== 'Complete'));
const completedTodos = computed(() => todos.filter((todo) => todo.status === 'Complete'));

async function updateStatus(todo: Todo): Promise<void> {
    try {
        await axios.patch(`/todos/${todo.id}/status`, {
            status: todo.status,
        });
        $toast.open({
            message: 'Updated task status successfully!',
            type: 'success',
            position: 'top',
            duration: 2000,
        });
    } catch (error) {
        console.error('Error updating status:', error);
        alert('Failed to update status.');
    }
}

async function deleteTodo(todoId: number): Promise<void> {
    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        });

        if (result.isConfirmed) {
            // Perform the delete operation
            await axios.delete(`/todos/${todoId}`);

            // Show the "Deleted!" SweetAlert
            await Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
            });

            // Show the toast message
            $toast.open({
                message: "Todo deleted successfully!",
                type: "success",
                position: "top",
                duration: 2000,
            });

            // Remove the deleted todo from the todos array
            const index = todos.findIndex((todo) => todo.id === todoId);
            if (index !== -1) {
                todos.splice(index, 1);
            }
        }
    } catch (error) {
        console.error("Error deleting todo:", error);
        $toast.open({
            message: "Failed to delete todo.",
            type: "error",
            position: "top",
            duration: 2000,
        });
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="text-2xl font-bold">Your Tasks</h1>
            <template v-if="pendingTodos.length > 0">
                <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="todo in pendingTodos"
                        :key="todo.id"
                        class="relative p-4 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                    >
                        <!-- Delete Button -->
                        <button
                            @click="deleteTodo(todo.id)"
                            class="absolute top-2 right-2 text-red-500 hover:text-red-700"
                            aria-label="Delete Todo"
                        >
                            ✖
                        </button>

                        <h2 class="text-lg font-semibold text-black dark:text-white">{{ todo.title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ todo.description }}</p>
                        <select
                            v-model="todo.status"
                            @change="updateStatus(todo)"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="In Testing">In Testing</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </li>
                </ul>
            </template>
            <p v-else class="text-gray-600 dark:text-gray-400">There are currently no tasks.</p>

            <h2 class="text-2xl font-bold mt-8">Completed Tasks</h2>
            <template v-if="completedTodos.length > 0">
                <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="todo in completedTodos"
                        :key="todo.id"
                        class="relative p-4 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800"
                    >
                        <!-- Delete Button -->
                        <button
                            @click="deleteTodo(todo.id)"
                            class="absolute top-2 right-2 text-red-500 hover:text-red-700"
                            aria-label="Delete Todo"
                        >
                            ✖
                        </button>

                        <h2 class="text-lg font-semibold text-black dark:text-white">{{ todo.title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ todo.description }}</p>
                        <select
                            v-model="todo.status"
                            @change="updateStatus(todo)"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="In Testing">In Testing</option>
                            <option value="Complete">Complete</option>
                        </select>
                    </li>
                </ul>
            </template>
            <p v-else class="text-gray-600 dark:text-gray-400">There are currently no completed tasks.</p>
        </div>
    </AppLayout>
</template>