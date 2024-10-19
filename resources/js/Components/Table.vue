<script setup>

defineProps({
    header: Array,
    data: Array
})

</script>

<template>
    <div class="bg-white rounded-lg px-5 py-2 w-full overflow-hidden">
        <table class="min-w-full align-middle border-spacing-x-0 border-separate border-spacing-y-2">
            <thead>
                <tr>
                    <th v-for="item in header"
                        scope="col"
                        class="px-6 py-3  text-xs  text-center text-default uppercase">
                        {{item}}
                    </th>
                </tr>
            </thead>
            <tbody >
                <tr v-for="row in data" class="text-sm  text-default bg-[#F7F9FB] align-middle  border-spacing-y-2">
                    <td v-for="(item,key,index) in row"
                        class="px-6 text-center py-3 max-w-sm  overflow-hidden text-ellipsis"
                        :class="{' rounded-bl-lg rounded-tl-lg':index===0, 'rounded-br-lg rounded-tr-lg':index===header.length-1}">
                        {{item ?? "---"}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
