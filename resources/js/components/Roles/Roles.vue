<template>
    <div>
        <div v-if="$Role.isAdmin()">
            <div class="row">
                <div class="col-6">
                    <div class="card card-pink">
                        <div class="card-header">
                            <h3 class="card-title">Role</h3>

                            <div class="card-tools">
                                <div class="d-flex align-content-between">
                                    <a
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#RoleModal"
                                    >
                                        <i
                                            class="fa fa-plus pr-3"
                                            title="Add New Role"
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
                                        />

                                        <div class="input-group-append">
                                            <button
                                                type="submit"
                                                class="btn btn-default"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.d-flex -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Registered At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="role in roles" :key="role.id">
                                        <td>{{ role.id }}</td>
                                        <td>{{ role.name }}</td>
                                        <td>
                                            {{ role.created_at | humanDate }}
                                        </td>
                                        <td>
                                            <a
                                                href
                                                class="fa fa-edit"
                                                @click.prevent="
                                                    editRole(role.id)
                                                "
                                            ></a>
                                            /
                                            <a
                                                href
                                                class="fa fa-trash text-danger"
                                                @click.prevent="
                                                    deleteRole(role.id)
                                                "
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
                        <h5 class="modal-title">Add New Role</h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createRole">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="role-name" class="col-form-label"
                                    >Name:</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name'),
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
const ROLE_API_URI = "/api/manage/role";
export default {
    data() {
        return {
            roles: {},
            pgRoles: {
                uri: ROLE_API_URI + "?",
                page: 1,
                perpage: 10,
                records: 0,
                options: {
                    chunksNavigation: scroll,
                    texts: {
                        count: "|||",
                    },
                },
            },
            form: new Form({
                id: "",
                name: "",
            }),
            searchText: "",
        };
    },
    methods: {
        getTableData(page) {
            let filter = "";
            this.$Progress.start();
            axios
                .get(this.pgRoles.uri + filter + "&page=" + page)
                .then(({ data }) => {
                    this.roles = data.data;
                    this.pgRoles.records = data.total;
                    this.pgRoles.page = data.current_page;
                    this.pgRoles.perpage = data.per_page;
                    this.$Progress.finish();
                });
        },
        createRole() {
            this.$Progress.start();
            this.form
                .post(ROLE_API_URI)
                .then(() => {
                    Fire.$emit("AfterCreated");
                    $("#RoleModal").modal("hide");
                    Toast.fire({
                        type: "success",
                        title: "User Created in successfully",
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    console.log("Fail");
                    this.$Progress.fail();
                });
        },
        closeModal() {
            this.form.errors.clear();
            this.form.reset();
            $("#RoleModal").modal("hide");
        },
    },
    created() {
        this.getTableData(1);
        Fire.$on("AfterCreated", () => {
            this.getTableData(1);
        });
    },
};
</script>
