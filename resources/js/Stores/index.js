import {defineStore} from 'pinia'

export const userSystemState = defineStore('system_state',{
    state:()=>{
        return{
            sidebar: true
        }
    },
})
