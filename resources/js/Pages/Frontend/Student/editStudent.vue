<template>

    <Head title="Edit Student Data">
        Edit Student Data
    </Head>

    <FrontendLayout>

        <div v-if="$page.props.flash.message" class="alert">
            {{ $page.props.flash.message }}
        </div>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h3>Edit Student</h3>
            </div>

            <form @submit.prevent="updateStudent()">

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    
                    <!-- Inputs forms -->
                    <div class="mb-3">
                        <label >Student Name</label>
                        <input type="text" v-model="form.name" class="py-1 w-full">
                        <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                    </div>
                    <div class="mb-3">
                        <label >Student Wave</label>
                        <input type="text" v-model="form.wave" class="py-1 w-full">
                        <div v-if="errors.wave" class="text-red-500">{{ errors.wave }}</div>
                    </div>
                    <div class="mb-3">
                        <label >Test Number</label>
                        <input type="text" v-model="form.no_test" class="py-1 w-full">
                        <div v-if="errors.no_test" class="text-red-500">{{ errors.no_test }}</div>
                    </div>
                    
                    <!-- Action buttons-->
                    <div class="mb-3">
                        <Link 
                            :href="route('students.index')" 
                            class="bg-red-600 text-white py-2 px-5 rounded mb-4 mr-2 ml-2 inline-block"
                        >
                            Back
                        </Link>
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            class="bg-blue-500 text-white py-2 px-5 rounded mb-4 mr-2 ml-2"
                        >
                        <span v-if="form.processing">Updating...</span>
                        <span v-else>Update</span>
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

const props = defineProps({
    errors:Object,
    student: Object,
});

const form = useForm({
    name: props.student.name,
    wave: props.student.wave,
    no_test: props.student.no_test,
});

const updateStudent = () => {
    const res = form.put(route('students.update', props.student.id));
    if (res) {
        form.reset();
    }
}
</script>