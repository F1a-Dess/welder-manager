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

                    <!-- R1 Simple Skill Score -->
                    <!-- 
                    <div class="mb-3">
                        <label >Welding Skill Score</label>
                        <input type="number" v-model="form.welding_skill" class="py-1 w-full">
                        <div v-if="form.errors.welding_skill" class="text-red-500">{{ form.errors.welding_skill }}</div>
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
                    
                    -->

                    <!-- R2 Complex Skill Score -->
                    <div class="mb-5">
                        <div class="mb-1">
                            <label>Welding Score : {{ weldingScore }}</label>
                        </div>

                        <table class="table-auto border-collapse norder divide-gray-300">
                            <thead>
                                <tr>
                                    <th>U/C</th>
                                    <th>OV</th>
                                    <th>PO</th>
                                    <th>U/F/Vi</th>
                                    <th>Root Visual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.UC" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.OV" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.PO" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.UFVi" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.root_visual" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <input type="hidden" v-model="form.welding_skill">
                    </div>

                    <div class="mb-5">
                        <div class="mb-1">
                            <label>Lanugage Score : {{ languageScore }}</label>
                        </div>

                        <table class="table-auto border-collapse norder divide-gray-300">
                            <thead>
                                <tr style="width: 450px;">
                                    <th>Preparation</th>
                                    <th>Understanding</th>
                                    <th>Conversation</th>
                                    <th>Vocabulary</th>
                                    <th>Daily</th>
                                    <th>Korean Songs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="mb-3 text-center"><input type="number" v-model="form.class_prep" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                <td class="mb-3 text-center"><input type="number" v-model="form.understanding" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                <td class="mb-3 text-center"><input type="number" v-model="form.conversation" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                <td class="mb-3 text-center"><input type="number" v-model="form.vocabulary" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                <td class="mb-3 text-center"><input type="number" v-model="form.weekly" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                <td class="mb-3 text-center"><input type="number" v-model="form.k_song" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                            </tbody>
                        </table>

                        <input type="hidden" v-model="form.language">
                    </div>

                    <div class="mb-5">
                        <div class="mb-1">
                            <label>Attitude Score : {{ attitudeScore }}</label>
                        </div>

                        <table class="table-auto border-collapse norder divide-gray-300">
                            <thead>
                                <tr>
                                    <th>Responsibility</th>
                                    <th>Obidience</th>
                                    <th>Neatness</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.rci" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.opa" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                    <td class="mb-3 text-center"><input type="number" v-model="form.ncd" class="py-0.5 mr-1 ml-1" style="width: 120px;"></td>
                                </tr>
                            </tbody>
                        </table>

                        <input type="hidden" v-model="form.attitude">
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
                        <input type="text" maxlength="1" v-model="form.grade" class="py-1 w-30">
                        <div v-if="form.errors.attitude" class="text-red-500">{{ form.errors.grade }}</div>
                    </div>

                    <div class="mb-3">
                        <label >Type Welding</label>
                        <div>
                            <select v-model="form.type_weld" class="py-1 w-30">
                                <option value="" disabled>Select Welding Type</option>
                                <option value="3G 12T">3G 12T</option>
                                <option value="3G 20T">3G 20T</option>
                                <option value="4G 12T">4G 12T</option>
                                <option value="4G 20T">4G 20T</option>
                            </select>
                        </div>
                        <div v-if="form.errors.type_weld" class="text-red-500">{{ form.errors.type_weld }}</div>
                    </div>

                    <!-- Hidden field for student_id -->
                    <input type="hidden" v-model="form.student_id">

                    <!-- Action buttons-->
                    <div class="mb-3">
                        <Link 
                            :href="route('students.show', props.student.id)" 
                            class="bg-red-600 text-white py-2 m-2 px-5 rounded mb-4 inline-block"
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

    // language
    class_prep: props.score.class_prep,
    understanding: props.score.understanding,
    conversation: props.score.conversation,
    vocabulary: props.score.vocabulary,
    weekly: props.score.weekly,
    k_song: props.score.k_song,
    language: props.score.language,

    // attitude
    rci: props.score.rci,
    opa: props.score.opa,
    ncd: props.score.ncd,
    attitude: props.score.attitude,

    // welding
    welding_skill: props.score.welding_skill,
    UC: props.score.UC,
    OV: props.score.OV,
    PO: props.score.PO,
    UFVi: props.score.UFVi,
    root_visual: props.score.root_visual,

    // summary
    total_score: props.score.total_score, 
    grade: props.score.grade,
    type_weld: props.score.type_weld, 
    
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

// calculate language score automatically
const languageScore = computed(() => {
    const cp = Number(form.class_prep) || 0;    // class_prep
    const us = Number(form.understanding) || 0;    // understanding
    const cv = Number(form.conversation) || 0;    // conversation
    const vb = Number(form.vocabulary) || 0;  // vocabulary
    const we = Number(form.weekly) || 0;  // weekly
    const ks = Number(form.k_song) || 0;   // k_song
    
    return cp + us + cv + vb + we + ks;
});

// calculate welding score automatically
const attitudeScore = computed(() => {
    const rci = Number(form.rci) || 0;  // Responsibility, Cooperation, Initiative
    const opa = Number(form.opa) || 0;  // Obedience, Presence, Apperance
    const ncd = Number(form.ncd) || 0;  // Neatness, Craftmanship in the Dorm

    return rci + opa + ncd;
});

// calculate total score automatically
const totalScore = computed(() => {
    // const welding = Number(form.welding_skill) || 0;
    // const language = Number(form.language) || 0;
    // const attitude = Number(form.attitude) || 0;
    
    // R2
    const welding = weldingScore.value || 0;
    const language = languageScore.value || 0;
    const attitude = attitudeScore.value || 0;
    

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