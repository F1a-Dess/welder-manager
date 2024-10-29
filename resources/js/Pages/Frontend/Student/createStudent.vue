<template>

    <Head title="Create Student Data">
        Create Student Data
    </Head>

    <FrontendLayout>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h3>Create Student</h3>
                <Link :href="route('students.index')" class="bg-red-500 text-white py-2 px-5 rounded mb-4 inline-block">Back</Link>
            </div>

            <form @submit.prevent="saveStudent()">

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    
                    <!-- Inputs forms -->
                    <div class="mb-3">
                        <label >Student Name</label>
                        <input type="text" v-model="form.name" placeholder="Enter Full Name (Required)" class="py-1 w-full">
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>
                    <div class="mb-3">
                        <label >Batch</label>
                        <input type="text" v-model="form.wave" placeholder="Enter Batch (Optional)" class="py-1 w-full" >
                        <div v-if="errors.wave" class="text-red-500">{{ errors.wave }}</div>
                    </div>
                    <div class="mb-3">
                        <label >Test Number</label>
                        <input type="text" v-model="form.no_test" placeholder="Enter No Test (Optional)" class="py-1 w-full">
                        <div v-if="errors.no_test" class="text-red-500">{{ errors.no_test }}</div>
                    </div>
                    
                    <!-- Action buttons-->
                    <div class="mb-3">
                        <Link 
                            :href="route('students.index')" 
                            class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block"
                        >
                            Back
                        </Link>
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-500 text-white py-2 px-5 rounded mb-4"
                        >
                        <span v-if="form.processing">Saving...</span>
                        <span v-else>Save</span>
                        </button>
                    </div>

                </div>
            </div>

            </form>

        </div>

    </FrontendLayout>

</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    errors:Object
});

const form = useForm({
    name: '',
    wave: '',
    no_test: '',
});

const saveStudent = () => {
    const res = form.post(route('students.store'));
    if (res) {
        form.reset();
    }
}
</script>