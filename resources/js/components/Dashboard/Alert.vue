<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Alerts
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div
                    class="alert alert-danger alert-dismissible"
                    v-for="(item, index) in alerts"
                    :key="index"
                >
                    <button
                        type="button"
                        class="close"
                        @click="markAsRead(item.id)"
                        aria-hidden="true"
                    >
                        ×
                    </button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    {{ item.data.message }}
                </div>
                <div class="alert alert-info alert-dismissible">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                    >
                        ×
                    </button>
                    <h5><i class="icon fas fa-info"></i> Alert!</h5>
                    Info alert preview. This alert is dismissable.
                </div>
                <div class="alert alert-warning alert-dismissible">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                    >
                        ×
                    </button>
                    <h5>
                        <i class="icon fas fa-exclamation-triangle"></i> Alert!
                    </h5>
                    Warning alert preview. This alert is dismissable.
                </div>
                <div class="alert alert-success alert-dismissible">
                    <button
                        type="button"
                        class="close"
                        @click="markAsRead(unreadNotification.id)"
                        aria-hidden="true"
                    >
                        ×
                    </button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    Success alert preview. This alert is dismissable.
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</template>

<script>
const NOTIFY_API_URI = '/api/notification'
export default {
    data() {
        return {
            alerts: null
        }
    },
    methods: {
        async getNotification() {
            const response = await axios.get(NOTIFY_API_URI)
            this.alerts = response.data
        },
        async markAsRead(id) {
            console.log(id)
        }
    },
    mounted() {
        this.getNotification()
    }
}
</script>
