<template>
    <div>
        <div v-if="$Role.isAdmin()">
            <div class="row">
                <div class="col-12"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
