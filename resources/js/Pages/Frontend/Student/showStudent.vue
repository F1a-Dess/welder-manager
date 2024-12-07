<template>

    <Head title="Show Student Data">
        Show Student Data
    </Head>

    <FrontendLayout>

        <div v-if="$page.props.flash.message" class="alert bg-green-200 mt-40 mx-5 py-2 rounded">
            {{ $page.props.flash.message }}
        </div>

        <div class="mt-4 mx-4">
            <h3>Show Student</h3>

            <div v-if="props.student" class="grid grid-cols-12 gap-4">
                <div class="col-span-6">
                    
                    <!-- Student name  -->
                    <div class="mb-3">
                        <label >Student Name</label>
                        <p>
                            {{ props.student.name }}
                        </p>
                    </div>
                    <!-- Batch Optional -->
                    <div class="mb-3">
                        <label >Batch</label>
                        <p>
                            {{ props.student.wave }}
                        </p>
                    </div>
                    <!-- Test Number -->
                    <div class="mb-3">
                        <label >Test Number</label>
                        <p>
                            {{ props.student.no_test }}
                        </p>
                    </div>

                    <div class="mt-10">
                        <Link :href="route('students.index')" class="bg-red-500 text-white p-3 rounded mb-4 mr-2 ml-2">Back</Link>
                        <Link :href="route('students.create-score', {student: props.student.id})" class="bg-blue-500 text-white p-3 rounded mb-4 mr-2 ml-2">Add New Data</Link>
                    </div>

                    <!-- Student Scores Table -->
                    <div class="mt-6">
                        <h4>Student Score</h4>
                        <table class="table-auto w-full border-collapse norder divide-gray-300">
                            <thead>
                                <tr>
                                    <!-- <th class="mb-3">No</th>
                                    <th class="mb-3">Date</th>
                                    <th class="mb-3">Welding Skill</th>
                                    <th class="mb-3">Language</th>
                                    <th class="mb-3">Attitude</th>
                                    <th class="mb-3">Total Score</th>
                                    <th class="mb-3">Grade</th> -->

                                    <th>
                                    No
                                    </th>

                                    <th 
                                        @click="toggleSort('date')" 
                                        class="cursor-pointer">
                                    Date
                                        <span v-if="sortColumn === 'date'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>

                                    <th 
                                        @click="toggleSort('welding_skill')" 
                                        class="cursor-pointer">
                                    Welding Skill
                                        <span v-if="sortColumn === 'welding_skill'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>

                                    <th 
                                        @click="toggleSort('language')" 
                                        class="cursor-pointer">
                                    Language
                                        <span v-if="sortColumn === 'language'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>
                                    
                                    <th 
                                        @click="toggleSort('attitude')" 
                                        class="cursor-pointer">
                                    Attitude
                                        <span v-if="sortColumn === 'attitude'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>

                                    <th 
                                        @click="toggleSort('total_score')" 
                                        class="cursor-pointer">
                                    Total Score
                                        <span v-if="sortColumn === 'total_score'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>
                                    
                                    <th 
                                        @click="toggleSort('grade')" 
                                        class="cursor-pointer">
                                    Grade
                                        <span v-if="sortColumn === 'grade'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>
                                    
                                    <th 
                                        @click="toggleSort('type_weld')" 
                                        class="cursor-pointer">
                                    Type Welding
                                        <span v-if="sortColumn === 'type_weld'">
                                            {{ sortOrder === 'asc' ? '↑' : '↓' }}
                                        </span>
                                    </th>

                                    <th>
                                    Option
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="props.student.scores && props.student.scores.length" v-for="(score, index) in sortedScores" :key="score.id">
                                    <td class="mb-3 text-center">{{ index + 1 }}</td>
                                    <td class="mb-3 text-center">{{ score.date }}</td>
                                    <td class="mb-3 text-center">{{ score.welding_skill }}</td>
                                    <td class="mb-3 text-center">{{ score.language }}</td>
                                    <td class="mb-3 text-center">{{ score.attitude }}</td>
                                    <td class="mb-3 text-center">{{ score.total_score }}</td>
                                    <td class="mb-3 text-center">{{ score.grade }}</td>
                                    <td class="mb-3 text-center">{{ score.type_weld }}</td>
                                    <td>
                                        <Link 
                                            :href="route('student-scores.edit', { student : props.student.id, student_score : score.id})" 
                                            class="px-4 oy-1 text-sm bg-green-400 text-dark me-2 rounded inline-block">
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteScore(score.id, props.student.id)" 
                                            class="px-4 oy-1 text-sm bg-red-500 text-dark me-2 rounded inline-block">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="6">No scores available</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </FrontendLayout>

</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, ref, computed } from 'vue';

const props = defineProps({
    student: Object,
    score: Object,
});

const deleteScore = (scoreId) => {
    if (confirm('Are you sure you want to delete this score?')) {
        router.delete(route('student-scores.destroy', scoreId), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                location.reload();
            },
            onError: () => {
                alert('Failed to delete score.');
            },
        });
  }
};

// State to track sorting
const sortColumn = ref('date'); // Default sorting by date
const sortOrder = ref('asc'); // Default order: ascending

// Computed property to sort scores dynamically
const sortedScores = computed(() => {
    if (!props.student || !props.student.scores) return [];

    return [...props.student.scores].sort((a, b) => {
        let compareA = a[sortColumn.value];
        let compareB = b[sortColumn.value];

        // If the column is 'date', compare by date objects
        if (sortColumn.value === 'date') {
        compareA = new Date(compareA).getTime();
        compareB = new Date(compareB).getTime();
        }

        // Sort ascending or descending
        return sortOrder.value === 'asc' ? compareA - compareB : compareB - compareA;
    });
});

// Method to toggle sorting order
const toggleSort = (column) => {
    if (sortColumn.value === column) {
        // Toggle order if the same column is clicked again
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        // Change to the new column with default ascending order
        sortColumn.value = column;
        sortOrder.value = 'asc';
    }
};


</script>
