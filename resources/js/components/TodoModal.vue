<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md dark:bg-[#1a1a1a] m-4">
            <header class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-lg font-semibold text-black dark:text-white">Add Todo</h2>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-300">
                    &times;
                </button>
            </header>
            <form @submit.prevent="submitTodo">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black dark:text-white bg-white dark:bg-[#2a2a2a]"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        class="p-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-black dark:text-white bg-white dark:bg-[#2a2a2a]"
                    ></textarea>
                </div>
                <div class="flex justify-end">
                    <Button
                        variant="outline"
                        class="mr-2"
                        @click="closeModal"
                    >
                        Cancel
                    </Button>
                    <Button
                        variant="pop"
                        type="submit"
                    >
                        Save
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, defineEmits } from 'vue';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast();

const emits = defineEmits(['close', 'save']);

const isOpen = ref(true);
const form = ref({
    title: '',
    description: '',
});

function closeModal() {
    isOpen.value = false;
    emits('close');
}

async function submitTodo() {
    try {
        await router.post(route('todos.store'), form.value);
        emits('save', form.value);
        closeModal();
        $toast.open({
            message: 'You added a new todo!',
            type: 'success',
            position: 'top',
            duration: 2000,
        });
        // Reload the entire Dashboard component to fetch updated todos
        await router.reload();
    } catch (error) {
        console.error('Failed to save todo:', error);
        alert('An error occurred while saving the todo.');
    }
}
</script>