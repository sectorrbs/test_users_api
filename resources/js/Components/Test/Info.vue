<template>
    <div class="test__info">
        <div class="test__info-section">
            <div class="test__info-key">Всего:</div>
            <div class="test__info-value">{{ users_data.total }}</div>
        </div>
        <div class="test__info-section">
            <div class="test__info-key">Добавлено:</div>
            <div class="test__info-value">{{ users_data.inserted }}</div>
        </div>
        <div class="test__info-section">
            <div class="test__info-key">Обновлено:</div>
            <div class="test__info-value">{{ users_data.updated }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['users_data'],
    setup(props) {

    }
}
</script>
