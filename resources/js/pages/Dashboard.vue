<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import TodoModal from '@/components/TodoModal.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { computed, ref, watch } from 'vue';
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
const todos = ref<Todo[]>(Array.isArray(props.todos) ? props.todos : []); // Ensure todos is always an array

const isModalOpen = ref(false); // Manage modal state here

function openModal() {
    isModalOpen.value = true;
}

interface Todo {
    id: number;
    title: string;
    description: string;
    status: string;
}

// Computed properties to filter todos
const completedTodos = computed(() => todos.value.filter((todo) => todo.status === 'Complete'));

async function updateStatus(todo: Todo): Promise<void> {
    try {
        await axios.patch(`/todos/${todo.id}/status`, {
            status: todo.status,
        });

        // No need to remove the todo from the todos array.
        // The computed properties will automatically update the UI.
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
            const index = todos.value.findIndex((todo) => todo.id === todoId);
            if (index !== -1) {
                todos.value.splice(index, 1);
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

function addTodo(newTodo: Todo) {
    console.log('Adding new todo:', newTodo); // Debugging: Log the newTodo object
    todos.value.push(newTodo);
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Your Tasks</h1>
                <div class="mb-4">
                    <Button
                        variant="pop"
                        size="icon"
                        class="w-full px-4 cursor-pointer lg:flex"
                        @click="openModal"
                    >
                        Add Todo
                    </Button>
                </div>
            </div>

            <template v-if="todos.filter(todo => todo.status !== 'Complete').length > 0">
                <!-- Legend -->
                <div class="mb-4 flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 block bg-[#ffe8f6] rounded"></span>
                        <span>Pending</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 block bg-[#3cbf8e] rounded"></span>
                        <span>In Progress</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 block bg-[#f48c3c] rounded"></span>
                        <span>In Testing</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 h-4 block bg-[#d71964] rounded"></span>
                        <span>Completed</span>
                    </div>
                </div>
                <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="todo in todos.filter(todo => todo.status !== 'Complete')"
                        :key="todo.id"
                        :class="{
                            'bg-[#ffe8f6]': todo.status === 'Pending',
                            'bg-[#3cbf8e]': todo.status === 'In Progress',
                            'bg-[#f48c3c]': todo.status === 'In Testing',
                        }"
                        class="relative p-4 rounded-lg"
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
                        <div class="flex items-center gap-2 text-sm mt-4">
                            <span>Status: </span>
                            <select
                                v-model="todo.status"
                                @change="updateStatus(todo)"
                                class="border p-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black dark:text-white bg-white dark:bg-[#2a2a2a]"
                            >
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="In Testing">In Testing</option>
                                <option value="Complete">Complete</option>
                            </select>
                        </div>
                    </li>
                </ul>
            </template>
            <p v-else class="text-gray-600 dark:text-gray-400">There are currently no tasks.</p>

            <h2 class="text-2xl font-bold mt-8">Shifted Tasks</h2>
            <template v-if="completedTodos.length > 0">
                <ul class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <li
                        v-for="todo in completedTodos"
                        :key="todo.id"
                        :class="{
                            'bg-[#d71964]': todo.status === 'Complete',
                        }"
                        class="relative p-4 rounded-lg"
                    >
                        <!-- Delete Button -->
                        <button
                            @click="deleteTodo(todo.id)"
                            class="absolute top-2 right-2 text-red-500 hover:text-red-700"
                            aria-label="Delete Todo"
                        >
                            ✖
                        </button>

                        <h2 class="text-lg font-semibold text-white dark:text-white">{{ todo.title }}</h2>
                        <p class="text-gray-400 dark:text-gray-400">{{ todo.description }}</p> 
                        <div class="flex items-center mt-2 gap-2 text-sm mt-4">
                            <span>Status: </span>
                            <select
                                v-model="todo.status"
                                @change="updateStatus(todo)"
                                class="border p-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-black dark:text-white bg-white dark:bg-[#2a2a2a]"
                            >
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="In Testing">In Testing</option>
                                <option value="Complete">Complete</option>
                            </select>
                        </div>
                    </li>
                </ul>
            </template>
            <p v-else class="text-gray-600 dark:text-gray-400">There are currently no completed tasks.</p>
        </div>

        <!-- TodoModal Component -->
        <TodoModal 
            v-if="isModalOpen" 
            @close="isModalOpen = false" 
            @todo-added="addTodo" 
        />
    </AppLayout>
</template>