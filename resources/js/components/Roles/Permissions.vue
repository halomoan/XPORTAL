<template>
    <div>
        <div v-if="$can('view roles')">
            <div class="card card-secondary" v-show="role.name != null">
                <div class="card-header">
                    <h3 class="card-title">{{ role.name }} Permission</h3>
                    <div class="card-tools">
                        <button
                            class="btn btn-secondary btn-sm"
                            @click="savePermissions"
                            :disabled="noUpdate"
                            v-show="$can('edit roles')"
                        >
                            Save
                        </button>
                    </div>
                    <!-- ./card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="overlay-wrapper">
                            <table class="table table-borderless">
                                <tr>
                                    <td
                                        v-for="value in ALL_VALUES"
                                        :key="value.id"
                                    >
                                        <div
                                            class="
                                                custom-control custom-checkbox
                                            "
                                        >
                                            <input
                                                class="custom-control-input"
                                                type="checkbox"
                                                :id="value.id"
                                                v-model="value.checked"
                                                v-on:change="
                                                    setChildrenCheckBox(
                                                        value.id
                                                    )
                                                "
                                                :disabled="noUpdate"
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
                                    v-for="(
                                        item, name, index
                                    ) in all_permissions"
                                    :key="index"
                                >
                                    <td>
                                        <div
                                            class="
                                                custom-control custom-checkbox
                                            "
                                        >
                                            <input
                                                class="custom-control-input"
                                                type="checkbox"
                                                :id="'view' + item[0].id"
                                                :value="item[0].id"
                                                v-model="item[0].checked"
                                                v-on:change="setALLCheckBox(0)"
                                                :disabled="noUpdate"
                                            />
                                            <label
                                                :for="'view' + item[0].id"
                                                class="custom-control-label"
                                                >{{ item[0].name }}</label
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="
                                                custom-control custom-checkbox
                                            "
                                        >
                                            <input
                                                class="custom-control-input"
                                                type="checkbox"
                                                :id="'add' + item[1].id"
                                                :value="item[1].id"
                                                v-model="item[1].checked"
                                                v-on:change="setALLCheckBox(1)"
                                                :disabled="noUpdate"
                                            />
                                            <label
                                                :for="'add' + item[1].id"
                                                class="custom-control-label"
                                                >{{ item[1].name }}</label
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="
                                                custom-control custom-checkbox
                                            "
                                        >
                                            <input
                                                class="custom-control-input"
                                                type="checkbox"
                                                :id="'edit' + item[2].id"
                                                :value="item[2].id"
                                                v-model="item[2].checked"
                                                v-on:change="setALLCheckBox(2)"
                                                :disabled="noUpdate"
                                            />
                                            <label
                                                :for="'edit' + item[2].id"
                                                class="custom-control-label"
                                                >{{ item[2].name }}</label
                                            >
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="
                                                custom-control custom-checkbox
                                            "
                                        >
                                            <input
                                                class="custom-control-input"
                                                type="checkbox"
                                                :id="'delete' + item[3].id"
                                                :value="item[3].id"
                                                v-model="item[3].checked"
                                                v-on:change="setALLCheckBox(3)"
                                                :disabled="noUpdate"
                                            />
                                            <label
                                                :for="'delete' + item[3].id"
                                                class="custom-control-label"
                                                >{{ item[3].name }}</label
                                            >
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="overlay" v-if="inprogress">
                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                <div class="text-bold pl-2">Loading...</div>
                            </div>
                        </div>
                        <!-- /.overlay-wrapper -->
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
                { id: 'EDIT_ALL', label: 'Edit: ALL', checked: false },
                { id: 'DELETE_ALL', label: 'Delete: ALL', checked: false }
            ],
            noUpdate: false,
            inprogress: false
        }
    },
    methods: {
        getTableData() {
            this.$Progress.start()
            this.inprogress = true
            axios.get(PERM_API_URI).then(({ data }) => {
                for (var i = 0; i < data.length; i++) {
                    const keyvals = data[i].name.split(' ')
                    data[i].action = keyvals[0]
                    data[i].group = keyvals[1]
                    data[i].checked = false
                }

                this.all_permissions = _.groupBy(data, 'group')
                if (this.role.name) {
                    this.noUpdate = this.role.name.toUpperCase() === 'ADMIN'
                } else {
                    this.noUpdate = false
                }
                this.inprogress = false
                this.$Progress.finish()
            })
        },
        setChildrenCheckBox(id) {
            switch (id) {
                case 'VIEW_ALL':
                    if (this.ALL_VALUES[0].checked) {
                        this._setPermissions(true, 'view')
                    } else {
                        this._setPermissions(false, 'view')
                    }
                    break
                case 'ADD_ALL':
                    if (this.ALL_VALUES[1].checked) {
                        this._setPermissions(true, 'add')
                    } else {
                        this._setPermissions(false, 'add')
                    }
                    break
                case 'EDIT_ALL':
                    if (this.ALL_VALUES[2].checked) {
                        this._setPermissions(true, 'edit')
                    } else {
                        this._setPermissions(false, 'edit')
                    }
                    break
                case 'DELETE_ALL':
                    if (this.ALL_VALUES[3].checked) {
                        this._setPermissions(true, 'delete')
                    } else {
                        this._setPermissions(false, 'delete')
                    }
                    break
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
                    count = $("input:checkbox:checked[id^='edit']").length
                    total = $("input:checkbox[id^='edit']").length
                    break
                case 3:
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
        savePermissions() {
            const permissions = _.chain(this.all_permissions)
                .flatMap()
                .filter('checked')
                .map('id')
                .value()

            const data = { role: this.role.id, permissions }
            this.inprogress = true
            axios
                .post(PERM_API_URI, data)
                .then(() => {
                    this.inprogress = false
                    Swal.fire(
                        'Updated!',
                        `Role  ${this.role.name} has been updated.`,
                        'success'
                    )
                })
                .catch((error) => {
                    this.inprogress = false
                    Swal.fire(
                        'Error!',
                        `Error occurred on Role  ${this.role.name}.`,
                        'error'
                    )
                })
        },
        _setPermissions(checked, action) {
            _.forEach(this.all_permissions, function (item, key) {
                for (var i = 0; i < item.length; i++) {
                    if (item[i].action === action) {
                        item[i].checked = checked
                    }
                }
            })
        },
        _resetPermissions() {
            _.forEach(this.ALL_VALUES, function (item, key) {
                item.checked = false
            })

            _.forEach(this.all_permissions, function (item, key) {
                for (var i = 0; i < item.length; i++) {
                    item[i].checked = false
                }
            })
        }
    },
    computed: {
        ...mapGetters(['role', 'permissions'])
    },

    watch: {
        permissions: function (items) {
            this._resetPermissions()
            for (var i = 0; i < items.length; i++) {
                const keyvals = items[i].name.split(' ')
                const group = keyvals[1]
                for (var j = 0; j < this.all_permissions[group].length; j++) {
                    if (this.all_permissions[group][j].id === items[i].id) {
                        this.all_permissions[group][j].checked = true
                    }
                }
            }
            if (this.role.name) {
                this.noUpdate = this.role.name.toUpperCase() === 'ADMIN'
            } else {
                this.noUpdate = false
            }
        }
    },

    created() {
        this.getTableData()
    }
}
</script>
