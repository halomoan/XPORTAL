<template>
    <div>
        <div v-if="$can('view roles')">
            <div class="card card-pink">
                <div class="card-header">
                    <h3 class="card-title">Role</h3>

                    <div class="card-tools">
                        <div class="d-flex align-content-between">
                            <a href="#" @click.prevent="newModal">
                                <i
                                    class="fa fa-plus pr-3"
                                    title="Add New Role"
                                    v-show="$can('add roles')"
                                ></i>
                            </a>

                            <div
                                class="input-group input-group-sm"
                                style="width: 250px"
                            >
                                <input
                                    type="text"
                                    name="table_search"
                                    class="form-control float-right"
                                    placeholder="Search"
                                    v-model="searchText"
                                    v-on:keyup.enter="searchTable"
                                />

                                <div class="input-group-append">
                                    <button
                                        type="submit"
                                        class="btn btn-default"
                                        @click="searchTable"
                                    >
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.d-flex -->
                    </div>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Registered At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td>{{ role.id }}</td>
                                <td>{{ role.name }}</td>
                                <td>
                                    {{ role.created_at | humanDate }}
                                </td>
                                <td class="text-center">
                                    <span>
                                        <a
                                            href
                                            class="fa fa-edit"
                                            @click.prevent="
                                                getRolePermissions(role)
                                            "
                                            v-show="$can('edit roles')"
                                        ></a>
                                    </span>
                                    <span
                                        v-show="
                                            $can('delete roles') &&
                                            $can('edit roles')
                                        "
                                    >
                                        /
                                    </span>

                                    <a
                                        v-show="$can('delete roles')"
                                        href
                                        class="fa fa-trash text-danger"
                                        @click.prevent="deleteRole(role.id)"
                                    ></a>
                                    <span
                                        v-show="
                                            $can('delete roles') &&
                                            $can('edit roles')
                                        "
                                    >
                                        /
                                    </span>

                                    <a
                                        href
                                        class="text-green"
                                        @click.prevent="renameModal(role)"
                                        v-show="$can('edit roles')"
                                        >Rename</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer pb-0">
                    <div class="d-flex justify-content-end text-right">
                        <pagination
                            :records="pgRoles.records"
                            @paginate="getTableData"
                            v-model="pgRoles.page"
                            :per-page="pgRoles.perpage"
                        ></pagination>
                    </div>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="RoleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="Role"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">
                            Add New Role
                        </h5>
                        <h5 class="modal-title" v-show="editmode">
                            Rename Role
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="editmode ? updateRole() : createRole()"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="role-name" class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                    id="role-name"
                                    v-model="form.name"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>
                        </div>
                        <!-- /.modal-body -->

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="closeModal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                        <!-- /.modal-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const ROLE_API_URI = '/api/manage/role'
import { mapActions } from 'vuex'
export default {
    data() {
        return {
            editmode: false,
            roles: {},
            pgRoles: {
                uri: ROLE_API_URI + '?',
                page: 1,
                perpage: 10,
                records: 0,
                options: {
                    chunksNavigation: scroll,
                    texts: {
                        count: '|||'
                    }
                }
            },
            form: new Form({
                id: '',
                name: ''
            }),
            searchText: ''
        }
    },
    methods: {
        ...mapActions(['getRolePermissions']),
        getTableData(page) {
            let filter = ''
            this.$Progress.start()
            axios
                .get(this.pgRoles.uri + filter + '&page=' + page)
                .then(({ data }) => {
                    this.roles = data.data
                    this.pgRoles.records = data.total
                    this.pgRoles.page = data.current_page
                    this.pgRoles.perpage = data.per_page
                    this.$Progress.finish()
                })
        },
        createRole() {
            this.$Progress.start()
            this.form
                .post(ROLE_API_URI)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    $('#RoleModal').modal('hide')
                    Toast.fire({
                        type: 'success',
                        title: 'User Created in successfully'
                    })
                    this.$Progress.finish()
                })
                .catch((e) => {
                    $('#RoleModal').modal('hide')
                    let message = e.response.data.message
                    Swal.fire('Error!', message, 'error')
                    this.$Progress.fail()
                })
        },
        updateRole() {
            this.$Progress.start()
            this.form
                .put(ROLE_API_URI + '/' + this.form.id)
                .then(() => {
                    // success
                    $('#RoleModal').modal('hide')
                    Swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                    )
                    this.$Progress.finish()
                    Fire.$emit('AfterCreated')
                })
                .catch(() => {
                    this.$Progress.fail()
                })
        },
        newModal() {
            this.editmode = false
            this.form.reset()
            $('#RoleModal').modal('show')
        },
        renameModal(role) {
            this.editmode = true
            this.form.reset()
            $('#RoleModal').modal('show')
            this.form.fill(role)
        },

        deleteRole(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete(ROLE_API_URI + '/' + id)
                        .then(() => {
                            Swal.fire(
                                'Deleted!',
                                'The Role has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreated')
                        })
                        .catch(() => {
                            Swal.fire(
                                'Failed!',
                                'There was something wrong.',
                                'warning'
                            )
                        })
                }
            })
        },
        searchTable() {
            if (this.$Role.isAdmin()) {
                if (this.searchText) {
                    this.pgRoles.uri =
                        ROLE_API_URI + '?qname=' + this.searchText + '&page='
                } else {
                    this.pgRoles.uri = ROLE_API_URI + '?page=1'
                }
                this.$Progress.start()
                axios
                    .get(this.pgRoles.uri)
                    .then(({ data }) => {
                        this.roles = data.data
                        this.pgRoles.records = data.total
                        this.pgRoles.page = data.current_page
                        this.pgRoles.perpage = data.per_page
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something is wrong. Failed to search.'
                        })
                        this.$Progress.fail()
                    })
            }
        },
        closeModal() {
            this.form.errors.clear()
            this.form.reset()
            $('#RoleModal').modal('hide')
        }
    },
    created() {
        this.getTableData(1)
        Fire.$on('AfterCreated', () => {
            this.getTableData(1)
        })
    }
}
</script>
