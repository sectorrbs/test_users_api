<template>
    <div class="test" :class="{loading}">
        <Loader v-show="loading"/>
        <div class="test__wrapper">
            <Action
                @loading="changeStatusLoading"
                @setUpdatedData="setUpdatedData"/>
            <Info :users_data="usersData"/>
        </div>
    </div>
</template>

<script>

import Info from '@/Components/Test/Info.vue'
import Action from "@/Components/Test/Action.vue";
import Loader from "@/Components/Common/Loader.vue";
import {onMounted, reactive, ref} from "vue";
import axios from "axios";

export default {
    components: {Action, Info, Loader},
    setup() {
        const usersData = reactive({
            inserted: 0,
            updated: 0,
            total: 0,
        })
        const loading = ref(false)

        onMounted(async () => {
            try {
                loading.value = true
                const res = await axios.get('/api/get_count_users')
                usersData.total = res.data.users_count
            } catch (e) {
                alert(e.response.data.error)
            } finally {
                loading.value = false
            }
        })

        const setUpdatedData = data => setData(data)

        const setData = data => {
            usersData.inserted = data.inserted
            usersData.updated = data.updated
            usersData.total = data.total
        }

        const changeStatusLoading = bool => loading.value = bool

        return {
            setUpdatedData,
            changeStatusLoading,
            loading,
            usersData,
        }
    }
}

</script>
