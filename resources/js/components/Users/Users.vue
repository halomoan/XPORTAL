<template>
    <div class="container-fluid" v-if="$can('view users')">
        <div class="row">
            <div class="col-12">
                <div class="overlay-wrapper">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users</h3>

                            <div class="card-tools">
                                <div class="d-flex align-content-between">
                                    <a href="#" @click.prevent="addNewUser">
                                        <i
                                            class="fa fa-plus pr-3"
                                            title="Add New User"
                                            v-show="$can('add users')"
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
                                            placeholder="Search Name Or Email"
                                            v-model="searchText"
                                            v-on:keyup.enter="searchTable"
                                        />

                                        <div class="input-group-append">
                                            <button
                                                type="button"
                                                class="btn btn-default"
                                                @click="searchTable"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./d-flex -->
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Registered At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.role }}</td>
                                        <td>
                                            {{ user.created_at | humanDate }}
                                        </td>
                                        <td class="text-center">
                                            <a
                                                href
                                                class="fa fa-edit"
                                                @click.prevent="
                                                    editUser(user.id)
                                                "
                                                v-show="$can('edit users')"
                                            ></a>

                                            <span
                                                v-show="
                                                    $can('edit users') &&
                                                    $can('delete users')
                                                "
                                            >
                                                /
                                            </span>
                                            <a
                                                href
                                                class="fa fa-trash text-danger"
                                                @click.prevent="
                                                    deleteUser(user.id)
                                                "
                                                v-show="$can('delete users')"
                                            ></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer pb-0">
                            <div class="d-flex justify-content-end text-right">
                                <pagination
                                    :records="pgUsers.records"
                                    @paginate="getTableData"
                                    v-model="pgUsers.page"
                                    :per-page="pgUsers.perpage"
                                ></pagination>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                    <div class="overlay" v-if="inprogress">
                        <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        <div class="text-bold pl-2">Loading...</div>
                    </div>
                </div>
                <!-- /.overlay-wrapper -->
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
const USER_API_URI = '/api/manage/user'

export default {
    data() {
        return {
            users: {},
            pgUsers: {
                uri: USER_API_URI + '?',
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
            searchText: '',
            inprogress: false
        }
    },
    methods: {
        getTableData(page) {
            let filter = ''
            this.$Progress.start()
            this.inprogress = true
            axios
                .get(USER_API_URI + '?' + filter + '&page=' + page)
                .then(({ data }) => {
                    this.users = data.data
                    this.pgUsers.records = data.total
                    this.pgUsers.page = data.current_page
                    this.pgUsers.perpage = data.per_page
                    this.inprogress = false
                    this.$Progress.finish()
                })
        },
        searchTable() {
            if (this.searchText) {
                this.pgUsers.uri =
                    USER_API_URI +
                    '?qname=' +
                    this.searchText +
                    '&qemail=' +
                    this.searchText +
                    '&FilterOR=true&page='
            } else {
                this.pgUsers.uri = USER_API_URI + '?page=1'
            }
            this.$Progress.start()
            this.inprogress = true
            axios
                .get(this.pgUsers.uri)
                .then(({ data }) => {
                    this.users = data.data
                    this.pgUsers.records = data.total
                    this.pgUsers.page = data.current_page
                    this.pgUsers.perpage = data.per_page
                    this.inprogress = false
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.inprogress = false
                    Toast.fire({
                        icon: 'error',
                        title: 'Something is wrong. Failed to search.'
                    })
                    this.$Progress.fail()
                })
        },
        addNewUser() {
            this.$router.push({ path: '/manage/userd', query: {} })
        },
        editUser(id) {
            this.$router.push({ path: '/manage/userd', query: { userId: id } })
        },
        deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                //Send request to the server
                if (result.value) {
                    this.inprogress = true
                    axios
                        .delete(USER_API_URI + '/' + id)
                        .then((result) => {
                            if (result.status === 200) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your user has been deleted.',
                                    'success'
                                )
                                this.getTableData(this.pgUsers.page)
                                this.inprogress = false
                            }
                        })
                        .catch((error) => {
                            this.inprogress = false
                            let message = error.response.data.message
                            if (message) {
                                Swal.fire('Failed!', message, 'warning')
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'There is something wrong.',
                                    'warning'
                                )
                            }
                        })
                }
            })
        }
    },

    mounted() {
        this.getTableData(1)
        Fire.$on('AfterCreated', () => {
            this.getTableData(1)
        })
    }
}
</script>
