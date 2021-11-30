<template>
    <div>
        <div v-if="$Role.isAdmin()">
            <div class="card card-secondary" v-show="role.name != null">
                <div class="card-header">
                    <h3 class="card-title">{{ role.name }} Permission</h3>
                    <div class="card-tools">
                        <button
                            class="btn btn-secondary btn-sm"
                            @click="savePermissions"
                        >
                            Save
                        </button>
                    </div>
                    <!-- ./card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td v-for="value in ALL_VALUES" :key="value.id">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            class="custom-control-input"
                                            type="checkbox"
                                            :id="value.id"
                                            v-model="value.checked"
                                            v-on:change="setChildrenCheckBox"
                                        />
                                        <label
                                            :for="value.id"
                                            class="custom-control-label"
                                            >{{ value.label }}</label
                                        >
                                    </div>
                                </td>
                            </tr>
                            <tr
                                v-for="(item, name) in all_permissions"
                                :key="name"
                            >
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            class="custom-control-input"
                                            type="checkbox"
                                            :id="'view' + item[0].id"
                                            :value="item[0].id"
                                            v-model="item[0].checked"
                                            v-on:change="setALLCheckBox(0)"
                                        />
                                        <label
                                            :for="'view' + item[0].id"
                                            class="custom-control-label"
                                            >{{ item[0].name }}</label
                                        >
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            class="custom-control-input"
                                            type="checkbox"
                                            :id="'add' + item[1].id"
                                            :value="item[1].id"
                                            v-model="item[1].checked"
                                            v-on:change="setALLCheckBox(1)"
                                        />
                                        <label
                                            :for="'add' + item[1].id"
                                            class="custom-control-label"
                                            >{{ item[1].name }}</label
                                        >
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            class="custom-control-input"
                                            type="checkbox"
                                            :id="'delete' + item[2].id"
                                            :value="item[2].id"
                                            v-model="item[2].checked"
                                            v-on:change="setALLCheckBox(2)"
                                        />
                                        <label
                                            :for="'delete' + item[2].id"
                                            class="custom-control-label"
                                            >{{ item[2].name }}</label
                                        >
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>

<script>
const PERM_API_URI = '/api/manage/perm'
import { mapGetters } from 'vuex'
export default {
    data() {
        return {
            //role: {},
            all_permissions: {},
            ALL_VALUES: [
                { id: 'VIEW_ALL', label: 'View: ALL', checked: false },
                { id: 'ADD_ALL', label: 'Add: ALL', checked: false },
                { id: 'DELETE_ALL', label: 'Delete: ALL', checked: false }
            ]
        }
    },
    methods: {
        getTableData() {
            this.$Progress.start()
            axios.get(PERM_API_URI).then(({ data }) => {
                for (var i = 0; i < data.length; i++) {
                    const keyvals = data[i].name.split(' ')
                    data[i].group = keyvals[1]
                    data[i].checked = false
                }

                this.all_permissions = _.groupBy(data, 'group')

                this.$Progress.finish()
            })
        },
        setChildrenCheckBox() {
            if (this.ALL_VALUES[0].checked) {
                $("input:checkbox[id^='view']").prop('checked', 'checked')
            } else {
                $("input:checkbox[id^='view']").prop('checked', '')
            }

            if (this.ALL_VALUES[1].checked) {
                $("input:checkbox[id^='add']").prop('checked', 'checked')
            } else {
                $("input:checkbox[id^='add']").prop('checked', '')
            }

            if (this.ALL_VALUES[2].checked) {
                $("input:checkbox[id^='delete']").prop('checked', 'checked')
            } else {
                $("input:checkbox[id^='delete']").prop('checked', '')
            }
        },
        setALLCheckBox(idx) {
            let count = -1
            let total = 0

            switch (idx) {
                case 0:
                    count = $("input:checkbox:checked[id^='view']").length
                    total = $("input:checkbox[id^='view']").length

                    break
                case 1:
                    count = $("input:checkbox:checked[id^='add']").length
                    total = $("input:checkbox[id^='add']").length
                    break
                case 2:
                    count = $("input:checkbox:checked[id^='delete']").length
                    total = $("input:checkbox[id^='delete']").length
                    break
            }

            if (count === total) {
                this.ALL_VALUES[idx].checked = true
            } else {
                this.ALL_VALUES[idx].checked = false
            }
        },
        getPermissions() {},
        savePermissions() {
            //console.log(this.permissions)
            //for (var i = 0; i < this.permissions.length; i++) {}

            const data = _.flatMap(this.all_permissions)
            console.log(data)
        },
        resetPermissions() {
            _.forEach(this.ALL_VALUES, function (item, key) {
                item.checked = false
            })

            _.forEach(this.all_permissions, function (item, key) {
                for (var i = 0; i < item.length; i++) {
                    console.log(item[i])
                    item[i].checked = false
                }
            })
            console.log(this.all_permissions)
        }
    },
    computed: {
        ...mapGetters(['role', 'permissions'])
    },

    watch: {
        permissions: function (items) {
            this.resetPermissions()
            // for (var i = 0; i < items.length; i++) {
            //     const keyvals = items[i].name.split(' ')
            //     const group = keyvals[1]
            //     for (var j = 0; j < this.all_permissions[group].length; j++) {
            //         if (this.all_permissions[group][j].id === items[i].id) {
            //             console.log(this.all_permissions[group][j].name)
            //             this.all_permissions[group][j].checked = true
            //         }
            //     }
            // }
        }
    },

    created() {
        this.getTableData()
    }
}
</script>
