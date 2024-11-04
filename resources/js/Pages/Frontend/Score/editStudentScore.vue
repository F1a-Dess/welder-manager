<template>

    <Head title="Edit Student Score">
        Edit Student Score
    </Head>

    <FrontendLayout>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h3>Update Student Score for {{ studentName }}</h3>
            </div>

            <form @submit.prevent="updateScore()">

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-6">

                    <div class="mb-3">
                        <label >Date</label>
                        <input id="date" type="date" v-model="form.date" class="py-1 w-full">
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
                        <input id="language" type="number" v-model="form.language" class="py-1 w-full">
                        <div v-if="form.errors.language" class="text-red-500">{{ form.errors.language }}</div>
                    </div>

                    <div class="mb-3">
                        <label >Attitude Score</label>
                        <input id="attitude" type="number" v-model="form.attitude" class="py-1 w-full">
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
                        <select v-model="form.type_weld" class="py-1 w full">
                            <option value="" disabled>Select Welding Type</option>
                            <option value="3G">3G</option>
                            <option value="4G">4G</option>
                        </select>
                        <div v-if="form.errors.type_weld" class="text-red-500">{{ form.errors.type_weld }}</div>
                    </div>

                    <!-- Hidden field for student_id -->
                    <input type="hidden" v-model="form.student_id">

                    <!-- Action buttons-->
                    <div class="mb-3">
                        <Link 
                            :href="route('students.show', props.student.id)" 
                            class="bg-red-600 text-white py-2 px-5 rounded mb-4 inline-block"
                        >
                            Cancel
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
import { computed } from 'vue';

const props = defineProps({
    errors: Object,
    student: Object,// This will contain the student's data, including the id
    score : Object
});

const studentName = computed(() => props.student?.name || 'Unknown Student');

const form = useForm({
    student_id: props.student.id, // Automatically set to the current student's ID
    date: props.score.date,

    language: props.score.language,
    attitude: props.score.attitude,
    total_score: props.score.total_score, // should be automaticly shown the result
    grade: props.score.grade,
    type_weld: props.score.type_weld, 
    
    welding_skill: props.score.welding_skill,
    UC: props.score.UC,
    OV: props.score.OV,
    PO: props.score.PO,
    UFVi: props.score.UFVi,
    root_visual: props.score.root_visual,
});

const weldingScore = computed(() => {
    const uc = Number(form.UC) || 0;
    const ov = Number(form.OV) || 0;
    const po = Number(form.PO) || 0;
    const ufvi = Number(form.UFVi) || 0;
    const root_visual = Number(form.root_visual) || 0;

    return uc + ov + po + ufvi + root_visual;
});

// calculate total score automatically
const totalScore = computed(() => {
    const welding = Number(form.welding_skill) || 0;
    const language = Number(form.language) || 0;
    const attitude = Number(form.attitude) || 0;

    return welding + language + attitude;
});

const updateScore = () => {
    form.total_score = totalScore.value;

    // ensure that props.score.id exist
    if (!props.score || !props.score.id) {
        console.error('student_score ID is missing');
        return;
    }

    form.put(route('student-scores.update', {student_score : props.score.id, student_id : props.student.id}), {
        preserveScroll: true,
        onSuccess: () => {
            if (props.student?.id) {
                window.location = route('students.show', props.student.id);
            } else {
                window.location = route('student-scores.index');
            }
        },
    });
   
}


</script>