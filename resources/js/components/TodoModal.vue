<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <header class="flex justify-between items-center border-b pb-2 mb-4">
                <h2 class="text-lg font-semibold">Add Todo</h2>
                <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </header>
            <form @submit.prevent="submitTodo">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        id="title"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    ></textarea>
                </div>
                <div class="flex justify-end">
                    <button
                        type="button"
                        @click="closeModal"
                        class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, defineEmits } from 'vue';

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

function submitTodo() {
    emits('save', form.value);
    closeModal();
}
</script>