<template>

    <Head title="Students">
        Students
    </Head>

    <FrontendLayout>

        <div v-if="$page.props.flash.message" class="alert bg-green-200 mt-40 mx-5 py-2 rounded">
            {{ $page.props.flash.message }}
        </div>

        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h3>Student List</h3>
                <Link :href="route('students.create')" class="bg-blue-500 text-white p-3 rounded mb-4">Add New Data</Link>
            </div>

            <!-- {{ students }} -->

            <table v-if="studentData.length" class="w-full bg-white border border-gray-200 shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left border">
                            Option - Select All
                            <input 
                                type="checkbox"
                                @change="toggleSelectAll($event)"
                                :checked="areAllSelected"
                            />
                        </th>
                        <!-- <th class="py-2 px-4 text-left border">Id</th> -->
                        <th class="py-2 px-4 text-left border cursor-pointer" @click="changeSort('name')">
                            Nama
                            <span v-if="sortField === 'name'">
                                {{ sortOrder === 'asc' ? '↑' : '↓' }}
                            </span>
                        </th>
                        <th class="py-2 px-4 text-left border cursor-pointer" @click="changeSort('wave')">
                            Gelombang
                            <span v-if="sortField === 'wave'">
                                {{ sortOrder === 'asc' ? '↑' : '↓' }}
                            </span>
                        </th>
                        <th class="py-2 px-4 text-left border cursor-pointer" @click="changeSort('no_test')">
                            No Test
                            <span v-if="sortField === 'no_test'">
                                {{ sortOrder === 'asc' ? '↑' : '↓' }}
                            </span>
                        </th>
                        <th class="py-4 px-4 text-left border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr 
                        v-for="(item, index) in students.data"
                        :key="index"
                    > -->
                    <tr 
                        v-for="(item, index) in studentData"
                        :key="index"
                    >
                        <!-- <td class="py-2 px-4 border">
                            <input 
                                type="checkbox" 
                                :value="item.id"
                                :checked="selectedStudents.includes(item.id)"
                                @change="toggleStudentSelection(item)"
                                v-model="selectedStudents"
                            />
                        </td> -->

                        <td class="py-2 px-4 border">
                            <input 
                                type="checkbox" 
                                :value="item.id"
                                :checked="selectedStudents.includes(item.id)"
                                @change="toggleStudentSelection(item)"
                            />
                        </td>

                        <td class="py-2 px-4 border">{{item.name}}</td>
                        <td class="py-2 px-4 border">{{item.wave}}</td>
                        <td class="py-2 px-4 border">{{item.no_test}}</td>

                        <td class="py-2 px-4 border">
                            <Link
                                :href="route('students.show', item.id)"
                                class="px-4 oy-1 text-sm bg-blue-300 text-dark me-2 rounded inline-block">
                                Show
                            </Link>
                            <Link
                                :href="route('students.edit', item.id)"
                                class="px-4 oy-1 text-sm bg-green-400 text-dark me-2 rounded inline-block">
                                Edit
                            </Link>
                            <button
                                type="submit"
                                class="px-4 oy-1 text-sm bg-red-500 text-white me-2 rounded inline-block"
                                @click="deleteStudent(item.id)">
                                Delete
                            </button>
                        </td>
                    
                    </tr>
                </tbody>
            </table>

                <!-- Action buttons-->
                <div class="mb-3">
                    <button 
                        @click="openDateRangeModal"
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded"
                    >
                        Export Selected
                    </button>
                </div>

                <!-- Data Range Modal -->
                <div v-if="showModal" class="modal-overlay">
                    <div class="modal-content">
                        <h2>Export Selected Student Data</h2>

                        <label>
                            <input type="radio" v-model="reportType" value="weekly" />
                            Export Weekly Report  
                        </label>

                        <div class="mt-4">
                            <label>Daily Export Options :</label>
                        </div>

                        <div>
                            <label>
                                <input type="radio" v-model="reportType" value="dailyWelding" />
                                Export Daily Welding Report  
                            </label>
                        </div>

                        <div>
                            <label>
                                <input type="radio" v-model="reportType" value="dailyLanguage" />
                                Export Daily Language Report  
                            </label>
                        </div>
                        
                        <div>
                            <label>
                                <input type="radio" v-model="reportType" value="dailyAttitude" />
                                Export Daily Attitude Report  
                            </label>
                        </div>
                        
                        <!-- weekly report -->
                        <div class="mt-2" v-if="reportType === 'weekly'">
                            <label for="startDate">Start Date:</label>
                            <input 
                                type="date" 
                                id="startDate"
                                v-model="startDate"
                                :min="minDate"
                                :max="today"
                                class="py-1 w-full"
                                required
                            />
                                
                            <label for="endDate">End Date:</label>
                            <input 
                                type="date"
                                id="endDate"
                                v-model="endDate"
                                :min="startDate || minDate"
                                :max="today"
                                class="py-1 w-full"    
                                required
                            />
                        </div>

                        <!-- daily welding report options-->
                        <div class="mt-2" v-if="reportType === 'dailyWelding'">
                            <label for="selectedWeldingDate">Select Date:</label>
                            <input 
                                type="date" 
                                id="selectedWeldingDate"
                                v-model="selectedWeldingDate"
                                :min="minDate"
                                :max="today"
                                class="py-1 w-full"
                                required
                            />
                        </div>

                        <!-- daily language report options-->
                        <div class="mt-2" v-if="reportType === 'dailyLanguage'">
                            <label for="selectedLanguageDate">Select Date:</label>
                            <input 
                                type="date" 
                                id="selectedLanguageDate"
                                v-model="selectedLanguageDate"
                                :min="minDate"
                                :max="today"
                                class="py-1 w-full"
                                required
                            />
                        </div>

                        <!-- daily attitude report options-->
                        <div class="mt-2" v-if="reportType === 'dailyAttitude'">
                            <label for="selectedAttitudeDate">Select Date:</label>
                            <input 
                                type="date" 
                                id="selectedAttitudeDate"
                                v-model="selectedAttitudeDate"
                                :min="minDate"
                                :max="today"
                                class="py-1 w-full"
                                required
                            />
                        </div>

                        <button 
                            @click="exportSelectedStudents"
                            class="mt-4 px-4 py-2 mr-4 bg-green-500 text-white rounded"
                        >
                            Export
                        </button>
                        <button
                            @click="closeModal" 
                            class="mt-4 px-4 py-2 mr-4 bg-gray-500 text-white rounded"
                        >
                            Cancel
                        </button>
                    </div>
                </div>

            <div class="float-end">
                <Pagination class="mt-4" :links="students.links"></Pagination>
            </div>
            
        </div>

    </FrontendLayout>

</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { computed, defineProps, ref } from 'vue';

const props = defineProps ({
    students: [Object, Array],
});

const form = useForm({});

const deleteStudent = (studentId) => {
    if (confirm('Are you sure want to delete this data?')) {
        
        form.delete(route('students.destroy', studentId));
    }
};

// Toggle Student Selection so it wont reset when changing page

const toggleStudentSelection = (item) => {
    const index = selectedStudents.value.indexOf(item.id);
    if (index > -1) {
        // if the student is already selected, remove it from the array
        selectedStudents.value.splice(index, 1);
    } else {
        // if the student is not already selected, add it to the array
        selectedStudents.value.push(item.id);
    }
};

const toggleSelectAll = (event) => {
    const currentPageIds = studentData.value.map((student) => student.id);

    if (event.target.checked) {
        currentPageIds.forEach((id) => {
            if (!selectedStudents.value.includes(id)) {
                selectedStudents.value.push(id);
            }
        });
    } else {
        selectedStudents.value = selectedStudents.value.filter(id => !currentPageIds.includes(id));
    }
};

const areAllSelected = computed(() => {
    const currentPageIds = studentData.value.map((student) => student.id);
    return currentPageIds.length > 0 && currentPageIds.every((id) => selectedStudents.value.includes(id));
});


// Range modal stuff

const selectedStudents = ref([]);
const showModal = ref(false);
const startDate = ref('');
const endDate = ref('');
const selectedDate = ref('');
const reportType = ref('weekly'); // Default to weekly report

// sorting stuff

const sortField = ref('');
const sortOrder = ref('asc');

const today = computed(() => new Date().toISOString().split('T')[0]);

const minDate = computed(() => {
    const date = new Date();
    date.setFullYear(date.getFullYear() - 1);
    return date.toISOString().split('T')[0];
});

const studentData = computed(() => {
    const data = Array.isArray(props.students) ? props.students : props.students.data || [];

    // return [...data].sort((a, b) => {
    return Array.isArray(data) ? [...data].sort((a, b) => {
        if (!sortField.value) return 0;
        const fieldA = a[sortField.value];
        const fieldB = b[sortField.value];
        
        if (fieldA < fieldB) return sortOrder.value === 'asc' ? -1 : 1;
        if (fieldA > fieldB) return sortOrder.value === 'asc' ? 1 : -1;
        return 0;
    }) : [];
});

const changeSort = (field) => {
    if(sortField.value === field){
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortOrder.value = 'asc';
    }
    
};

const openDateRangeModal = () => {
    if(selectedStudents.value.length === 0) {
        alert('Please select at least one score to export.');
        return;
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const exportSelectedStudents = async () => {
    
    const payload = {
        selectedStudents: selectedStudents.value,
        reportType: reportType.value,
    };

    let routeName;
    let selectedDate;

    switch (reportType.value) {
        case 'weekly':
            payload.startDate = startDate.value;
            payload.endDate = endDate.value;
            selectedDate = endDate.value;
            routeName = 'students-scores.export-weekly';
            break;
        case 'dailyWelding':
            payload.selectedDate = selectedWeldingDate.value;
            selectedDate = selectedWeldingDate.value;
            routeName = 'students-scores.export-daily';
            break;
        case 'dailyLanguage':
            payload.selectedDate = selectedLanguageDate.value;
            selectedDate = selectedLanguageDate.value;
            routeName = 'students-scores.export-language';
            break;
        case 'dailyAttitude':
            payload.selectedDate = selectedAttitudeDate.value;
            selectedDate = selectedAttitudeDate.value;
            routeName = 'students-scores.export-attitude';
            break;
        default:
            alert('Invalid report type selected.');
            return;
    }

    try {
        const response = await fetch(route(routeName), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || `Error: ${response.statusText}`);
        }

        const blob = await response.blob();
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;

        // Custom formatted download filename 
        const reportTypeName = {
            dailyWelding: 'Daily Welding Assesment Report',
            dailyLanguage: 'Daily Language Assesment Report',
            dailyAttitude: 'Daily Attitude Assesment Report',
            weekly: 'Weekly Assesment Report',
        };
        
        const dateString = selectedDate && typeof selectedDate === 'object' ? selectedDate.value : selectedDate;
        const fileName = `${reportTypeName[reportType.value]} ${dateString}.xlsx`;
        a.download = fileName;

        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        a.remove();
    } catch (error) {
        console.error('Export failed:', error);
        alert('Failed to export data. Please try again.');
    }
};

</script>


<style scoped>

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 30px;
  border-radius: 10px;
  width: 20%;
}

</style>