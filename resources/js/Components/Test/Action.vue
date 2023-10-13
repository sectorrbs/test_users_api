<template>
    <div class="test__btn" @click="importUsers">
        Импортировать пользователей
    </div>
</template>

<script>

import axios from "axios";

export default {
    setup(_, {emit}) {
        const users_count = 5000
        const importUsers = async () => {
            try {
                emit('loading', true)
                const res = await axios.get('/api/import', {params: {count_users_to_import: users_count}})
                emit('setUpdatedData', res.data)
            } catch (e) {
                alert(e.response.data.error)
            } finally {
                emit('loading', false)
            }
        }
        return {
            importUsers
        }
    }
}
</script>

