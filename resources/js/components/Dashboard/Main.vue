<template>
    <div>
        <div class="row">
            <div class="col-6">
                <Alert />
            </div>
        </div>
    </div>
</template>

<script>
import Alert from './Alert.vue'
export default {
    components: { Alert },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
