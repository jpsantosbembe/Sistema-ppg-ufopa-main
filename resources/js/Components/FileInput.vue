<script setup>

defineProps({
    modelValue: {
        type: File,
        required: true,

    },
    accept: String
});

const emit = defineEmits(['update:modelValue']);

const onChangeFile = (event)=>{
    console.log(event.target.files[0])
    if (event.target.files && event.target.files.length > 0) {
        const file = (event.target.files[0]);
        emit('update:modelValue',file )
    }
}

</script>

<template>
    <input
        type="file"
        :accept="accept ?? '*/*'"
        class="flex-auto rounded-lg border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.4rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.4rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-black file:px-3 file:py-[0.4rem] file:text-white file:font-bold file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
        @change="onChangeFile"
    />
</template>
