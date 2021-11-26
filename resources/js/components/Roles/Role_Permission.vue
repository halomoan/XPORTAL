<template>
    <div>
        <div class="row">
            <div class="col-6">
                <Roles />
            </div>
            <div class="col-6">
                <Permissions />
            </div>
        </div>
    </div>
</template>

<script>
import Roles from './Roles.vue'
import Permissions from './Permissions.vue'

export default {
    components: {
        Roles,
        Permissions
    }
}
</script>
