<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import Toast from "@/Components/Toast.vue";
import {CloudArrowUpIcon, TableCellsIcon, XCircleIcon , InboxIcon} from '@heroicons/vue/24/outline'
import {onMounted, ref} from "vue";
import UploadItem from "@/Components/UploadItem.vue";
import FullLayout from "@/Layouts/full/FullLayout.vue";
import axios from "axios";
import ImportProcessing from "@/Components/ImportProcessing.vue";



const allowedMimeTypes = [
    //.xls
    'application/vnd.ms-excel',
    'application/excel',
    'application/x-excel',
    'application/x-msexcel',
    //xlsx
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-excel',
    'application/vnd.ms-office',
    'application/x-excel',
    'application/x-msexcel'
];

const props = defineProps({
    year_import:{
        type:Number
    },
    jobs:Object
})

const jobsProcessing = ref([])
const dragging = ref(false)
const uploadsPaginated = ref(null)

const form = useForm(
    {
        year:props.year_import,
        sheetsAll: null,
        sheetsTeste: null,
    }
)

function submit() {

    try {
        form.post(route('coleta.store'),{
            onSuccess: ()=>{
                getPaginationUploads()
                getJobs()
            }
        });
    } catch (erro) {
        console.error(erro);
    }

}

async function getPaginationUploads() {
    await axios.get(route('api.uploads'))
        .then(response=>{
            uploadsPaginated.value = response.data
        })
        .catch(error=>{
            console.error(error);
        })
}

async function getJobs() {
    await axios.get(route('api.collect.import.progress'))
        .then(response=>{
            jobsProcessing.value = response.data
            if(jobsProcessing.value){
                setTimeout(getJobs,5000)
            }
        })
        .catch(error=>{
            console.error(error);
        })
}


const clearToast = () => {
    usePage().props.toast.success = null;
    usePage().props.toast.fail = null;
};

function onChangeInputFile(e){
    let files = e.target.files || e.dataTransfer.files
    if (!files.length) {
        dragging.value = false;
        return;
    }
    dragging.value = false;
    console.log(files)
    if(files.length > 1){
        createFile(files[0].name.startsWith('SND') ? files[1] : files[0] )
        createFile2(files[0].name.startsWith('SND') ? files[0] : files[1] )
    }else{
        createFile( files[0] )
    }
    submit();
}

function createFile(file){
    form.sheetsAll = file;
}
function createFile2(file){
    form.sheetsTeste = file;
}
const toggleDrag = () => dragging.value = !dragging.value

onMounted(()=>{
    getPaginationUploads()
    getJobs()
})

</script>

<template>
    <FullLayout>
        <div class="tw-flex tw-flex-col tw-items-center tw-w-full">
            <div class="tw-w-full">
                <Toast  :showToast="$page.props.toast.success != null || $page.props.toast.fail != null"
                       :clearToast="clearToast"/>
            </div>
        </div>
        <v-card elevation="10">
            <v-card-text>
                <section class="tw-bg-white  tw-w-full tw-flex tw-flex-col tw-px-8 py-4">
                    <div class="tw-flex tw-justify-between">
                        <p class="tw-text-default tw-text-lg">Enviar Planilha de dados</p>
                        <p class="tw-border-borde tw-border-2 tw-px-4 tw-py-1 tw-rounded-lg tw-text-default">{{form.year}}</p>
                    </div>
                    <label
                        v-show="!form.progress"
                        for="sheet"
                        @dragenter.prevent="toggleDrag"
                        @dragleave.prevent="toggleDrag"
                        @dragover.prevent
                        @drop.prevent="onChangeInputFile"
                        :class="dragging ? 'tw-border-secondary' : 'tw-border-borde'"
                        class="tw-h-60 tw-rounded-lg tw-m-10 tw-border-dashed  tw-border-2 tw-flex tw-flex-col tw-justify-center tw-items-center">
                        <CloudArrowUpIcon
                            :class="dragging ? 'tw-text-primary':'tw-text-borde'"
                            class="tw-w-32 tw-stroke-[0.5] "
                        />
                        <span class="tw-text-default ">Clique para selecionar uma planilha or arraste e solte</span>
                    </label>

                    <div
                        v-show="form.progress"
                        class="tw-h-60 tw-rounded-lg tw-m-10 tw-border-dashed  tw-border-2 tw-flex tw-flex-col tw-justify-center tw-items-center tw-px-20">
                    </div>
                    <input class=" tw-h-full tw-hidden" id="sheet" multiple type="file" @change="onChangeInputFile" :accept="allowedMimeTypes.join(',')">

                </section>
                <section v-if="!!jobsProcessing.length"  class="tw-mt-5   tw-bg-white  tw-w-full tw-flex tw-flex-col tw-px-8 ">
                    <div class="tw-flex tw-justify-between">
                        <p class="tw-text-default tw-text-lg">Planilhas em Processamento</p>
                    </div>
                    <div class="tw-flex tw-flex-col gap-3 mt-2">
                        <ImportProcessing v-for="job in jobsProcessing" :importing="job"/>
                    </div>
                </section>
                <section  class="tw-mt-5   tw-bg-white  tw-w-full tw-flex tw-flex-col tw-px-8 py-4">
                    <div class="tw-flex tw-justify-between">
                        <p class="tw-text-default tw-text-lg">Planilhas enviadas</p>
                    </div>
                    <div v-if="uploadsPaginated?.data.length" class="tw-flex tw-flex-col tw-gap-2">
                        <div
                            v-for="upload in uploadsPaginated?.data"
                        >
                            <UploadItem :upload="upload"/>
                        </div>
                    </div>
                    <div
                        v-else
                        class="tw-h-60 tw-rounded-lg tw-m-10  tw-border-borde tw-border-2 tw-flex tw-flex-col tw-justify-center tw-items-center">
                        <InboxIcon
                            class="tw-w-32 tw-stroke-[0.5] tw-text-borde"
                        />
                        <span class="tw-text-default">Nenhuma planilha foi importada</span>
                    </div>
                </section>
            </v-card-text>
        </v-card>
    </FullLayout>
</template>

<style scoped>
.progress-bar {
    transition: width 0.5s;
}
</style>
