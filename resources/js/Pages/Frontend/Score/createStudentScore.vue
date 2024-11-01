<template>

    <Head title="Create Student Score">
        Create Student Score
    </Head>

    <FrontendLayout>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h3>Create Student Score for {{ student.name }}</h3>
                <Link 
                    :href="route('students.show', student.id)" 
                    class="bg-red-500 text-white py-2 px-5 rounded mb-4 inline-block">
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit">

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    
                    <!-- Inputs forms -->
                    <!-- <div class="mb-3">
                        <label >Input student id</label>
                        <input type="number" v-model="form.student_id" class="py-1 w-full">
                        <div v-if="errors.student_id" class="text-red-500">{{ errors.student_id }}</div>
                    </div> -->

                    <div class="mb-10">
                        <label >Input Date</label>
                        <input type="date" v-model="form.date" class="py-1 w-full">
                        <div v-if="form.errors.date" class="text-red-500">{{ form.errors.date }}</div>
                    </div>

                    <!-- R1 Weldin Skill Score -->
                    <!-- <div class="mb-3">
                        <label >Welding Skill Score</label>
                        <input type="number" v-model="form.welding_skill" class="py-1 w-full">
                        <div v-if="form.errors.welding_skill" class="text-red-500">{{ form.errors.welding_skill }}</div>
                    </div> -->

                    <!-- R2 Welding Skill Score, adding daily score and calculation -->
                    <div class="mb-3">
                        <div class="mb-1">
                            <label>Welding Score : U/C || OV || PO || U/F/Vi || Root Visual</label>
                        </div>
                        <input type="number" v-model="form.UC" class="py-1 m-2 w-20">
                        <input type="number" v-model="form.OV" class="py-1 m-2 w-20">
                        <input type="number" v-model="form.PO" class="py-1 m-2 w-20">
                        <input type="number" v-model="form.UFVi" class="py-1 m-2 w-20">
                        <input type="number" v-model="form.root_visual" class="py-1 m-2 mb-3 w-20">

                        <label >Total Welding Skill Score</label>
                        <input type="hidden" v-model="form.welding_skill">
                        <div>{{ weldingScore }}</div>
                    </div>

                    <div class="mb-3">
                        <label >Language Score</label>
                        <input type="number" v-model="form.language" class="py-1 w-full">
                        <div v-if="form.errors.language" class="text-red-500">{{ form.errors.language }}</div>
                    </div>

                    <div class="mb-3">
                        <label >Attitude Score</label>
                        <input type="number" v-model="form.attitude" class="py-1 w-full">
                        <div v-if="form.errors.attitude" class="text-red-500">{{ form.errors.attitude }}</div>
                    </div>
                    
                    <!-- <div class="mb-3">
                        <label >Total Score</label>
                        <input type="number" v-model="form.total_score" class="py-1 w-full" disabled>
                        <div v-if="form.errors.total_score" class="text-red-500">{{ form.errors.total_score }}</div>
                    </div> -->
                    <input type="hidden" v-model="form.total_score">
                    <div class="mb-3">
                        <label>Total Score : </label>
                        <div>{{ totalScore }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <label >Grade</label>
                        <div><label>A: > 75; B: > 60; C: > 50; D: < 50 </label></div>
                        <input type="text" maxlength="1" v-model="form.grade" class="py-1 w-full">
                        <div v-if="form.errors.attitude" class="text-red-500">{{ form.errors.grade }}</div>
                    </div>

                    <div class="mb-3">
                        <label >Type Welding</label>
                        <div>
                            <select v-model="form.type_weld" class="py-1 w full">
                                <option value="" disabled>Select Welding Type</option>
                                <option value="3G">3G</option>
                                <option value="4G">4G</option>
                            </select>
                        </div>
                        <div v-if="form.errors.type_weld" class="text-red-500">{{ form.errors.type_weld }}</div>
                    </div>

                    <!-- Hidden field for student_id -->
                    <input type="hidden" v-model="form.student_id">
                    
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
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, defineProps } from 'vue';

const props = defineProps({
    errors: Object,
    student: Object,// This will contain the student's data, including the id
});

const form = useForm({
    student_id: props.student.id, // Automatically set to the current student's ID
    date: '',

    language: 0,
    attitude: 0,
    total_score: 0, // should be automaticly shown the result
    grade: '',
    type_weld: '',
    
    welding_skill: 0,
    UC: 0,
    OV: 0,
    PO: 0,
    UFVi: 0,
    root_visual: 0,

});

// calculate total score automatically
const totalScore = computed(() => {
    const welding = weldingScore.value || 0;
    const language = Number(form.language) || 0;
    const attitude = Number(form.attitude) || 0;

    return welding + language + attitude;
});

// calculate welding score automatically
const weldingScore = computed(() => {
    const uc = Number(form.UC) || 0;
    const ov = Number(form.OV) || 0;
    const po = Number(form.PO) || 0;
    const ufvi = Number(form.UFVi) || 0;
    const root_visual = Number(form.root_visual) || 0;

    return uc + ov + po + ufvi + root_visual;
});

const submit = () => {
    form.total_score = totalScore.value;
    form.post(route('student-scores.store'), {
        preserveScroll: true
    });
}

</script>