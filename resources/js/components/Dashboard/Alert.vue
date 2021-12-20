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
                <overlay-scrollbars
                    :options="{ scrollbars: { autoHide: 'l' } }"
                >
                    <div style="height: 24rem">
                        <div
                            class="alert alert-dismissible"
                            v-for="(item, index) in alerts"
                            :key="index"
                            :class="['alert-' + item.data.type]"
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
                    </div>
                </overlay-scrollbars>
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
            const idx = _.findIndex(this.alerts, function (o) {
                return o.id === id
            })

            if (idx > -1) {
                this.alerts.splice(idx, 1)

                const response = await axios.delete(NOTIFY_API_URI + '/' + id)
            }
        }
    },
    mounted() {
        this.getNotification()
    }
}
</script>
