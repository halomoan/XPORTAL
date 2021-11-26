<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>

                        <div class="card-tools">
                            <div class="d-flex align-content-between">
                                <a href="#" @click.prevent="addNewUser">
                                    <i
                                        class="fa fa-plus pr-3"
                                        title="Add New User"
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
                                    <th>Action</th>
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
                                    <td>
                                        <a
                                            href
                                            class="fa fa-edit"
                                            @click.prevent="editUser(user.id)"
                                        ></a>
                                        /
                                        <a
                                            href
                                            class="fa fa-trash text-danger"
                                            @click.prevent="deleteUser(user.id)"
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
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</template>

<script>
const USER_API_URI = '/api/manage/user?'

export default {
    data() {
        return {
            users: {},
            pgUsers: {
                uri: USER_API_URI,
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
            searchText: ''
        }
    },
    methods: {
        getTableData(page) {
            let filter = ''
            this.$Progress.start()
            axios
                .get(this.pgUsers.uri + filter + '&page=' + page)
                .then(({ data }) => {
                    this.users = data.data
                    this.pgUsers.records = data.total
                    this.pgUsers.page = data.current_page
                    this.pgUsers.perpage = data.per_page
                    this.$Progress.finish()
                })
        },
        searchTable() {
            if (this.$Role.isAdmin()) {
                if (this.searchText) {
                    this.pgUsers.uri =
                        USER_API_URI +
                        'qname=' +
                        this.searchText +
                        '&qemail=' +
                        this.searchText +
                        '&FilterOR=true&page='
                } else {
                    this.pgUsers.uri = USER_API_URI + 'page=1'
                }
                this.$Progress.start()
                axios
                    .get(this.pgUsers.uri)
                    .then(({ data }) => {
                        this.users = data.data
                        this.pgUsers.records = data.total
                        this.pgUsers.page = data.current_page
                        this.pgUsers.perpage = data.per_page
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
        addNewUser() {
            this.$router.push({ path: '/manage/userd', query: {} })
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
