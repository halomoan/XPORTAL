<template>
    <div>
        <div v-if="$Role.isAdmin()">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a
                                        class="nav-link active"
                                        href="#general"
                                        data-toggle="tab"
                                        >General</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        href="#billing"
                                        data-toggle="tab"
                                        >Billing</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link"
                                        href="#role"
                                        data-toggle="tab"
                                        >Role</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="overlay-wrapper">
                                <div class="tab-content">
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane active" id="general">
                                        <!-- <form class="form-horizontal" @submit.prevent="createUser"> -->
                                        <div class="form-group row">
                                            <label
                                                for="name"
                                                class="col-sm-2 col-form-label"
                                                >Name</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    autocomplete="off"
                                                    :class="{
                                                        'is-invalid':
                                                            form.errors.has(
                                                                'name'
                                                            ),
                                                    }"
                                                    id="name"
                                                    v-model="form.name"
                                                    name="name"
                                                    placeholder="Name"
                                                    required
                                                />
                                                <has-error
                                                    :form="form"
                                                    field="name"
                                                ></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                for="email"
                                                class="col-sm-2 col-form-label"
                                                >Email</label
                                            >
                                            <div class="col-sm-10">
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    autocomplete="off"
                                                    :class="{
                                                        'is-invalid':
                                                            form.errors.has(
                                                                'email'
                                                            ),
                                                    }"
                                                    id="email"
                                                    v-model="form.email"
                                                    name="email"
                                                    placeholder="Email address"
                                                    required
                                                />
                                                <has-error
                                                    :form="form"
                                                    field="email"
                                                ></has-error>
                                            </div>
                                        </div>
                                        <form>
                                            <div class="form-group row">
                                                <label
                                                    for="password"
                                                    class="
                                                        col-sm-2 col-form-label
                                                    "
                                                    >Password</label
                                                >
                                                <div class="col-sm-10">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="password"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has(
                                                                    'password'
                                                                ),
                                                        }"
                                                        name="password"
                                                        v-model="form.password"
                                                        placeholder="Password"
                                                        required
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="password"
                                                    ></has-error>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label
                                                    for="repassword"
                                                    class="
                                                        col-sm-2 col-form-label
                                                    "
                                                >
                                                    Re-Type Password
                                                </label>
                                                <div class="col-sm-10">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="repassword"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has(
                                                                    'repassword'
                                                                ),
                                                        }"
                                                        name="repassword"
                                                        v-model="
                                                            form.repassword
                                                        "
                                                        placeholder="Re-type Password"
                                                        required
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="repassword"
                                                    ></has-error>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- </form> -->
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="billing">
                                        <form
                                            class="form-horizontal"
                                            @submit.prevent="createUser"
                                        >
                                            <div class="form-group row">
                                                <label
                                                    for="billaddr"
                                                    class="
                                                        col-sm-2 col-form-label
                                                    "
                                                >
                                                    Billing Address
                                                </label>
                                                <div class="col-sm-10">
                                                    <textarea
                                                        rows="5"
                                                        class="form-control"
                                                        :class="{
                                                            'is-invalid':
                                                                form.errors.has(
                                                                    'billaddr'
                                                                ),
                                                        }"
                                                        id="billaddr"
                                                        v-model="form.billaddr"
                                                        name="billaddr"
                                                        placeholder="billaddr"
                                                    />
                                                    <has-error
                                                        :form="form"
                                                        field="billaddr"
                                                    ></has-error>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="role">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="unassigned">
                                                        Available Role:
                                                    </label>
                                                    <select
                                                        v-model="
                                                            roles.checkAvailRole
                                                        "
                                                        multiple
                                                        class="form-control"
                                                        id="unassigned"
                                                        size="10"
                                                    >
                                                        <option
                                                            v-for="(
                                                                role, index
                                                            ) in roles.availRole"
                                                            :key="role.id"
                                                            :value="index"
                                                        >
                                                            {{ role.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div
                                                class="
                                                    col-2
                                                    d-flex
                                                    flex-column
                                                    justify-content-center
                                                    align-items-center
                                                "
                                            >
                                                <button
                                                    type="button"
                                                    class="btn btn-primary mb-2"
                                                    @click.prevent="adduserRole"
                                                >
                                                    <i
                                                        class="
                                                            fas
                                                            fa-chevron-right
                                                        "
                                                    ></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-secondary"
                                                    @click.prevent="
                                                        removeuserRole
                                                    "
                                                >
                                                    <i
                                                        class="
                                                            fas
                                                            fa-chevron-left
                                                        "
                                                    ></i>
                                                </button>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="userRole">
                                                        User Role:
                                                    </label>
                                                    <select
                                                        v-model="
                                                            roles.checkuserRole
                                                        "
                                                        multiple
                                                        class="form-control"
                                                        id="userRole"
                                                        size="10"
                                                    >
                                                        <option
                                                            v-for="(
                                                                role, index
                                                            ) in roles.userRole"
                                                            :key="index"
                                                            :value="index"
                                                        >
                                                            {{ role.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <!-- /.form -->
                                </div>
                                <!-- /.tab-content -->
                                <div class="overlay" v-if="inprogress">
                                    <i
                                        class="fas fa-3x fa-sync-alt fa-spin"
                                    ></i>
                                    <div class="text-bold pl-2">Loading...</div>
                                </div>
                            </div>
                            <!-- /.overlay-wrapper -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                @click.prevent="goBack"
                            >
                                Cancel
                            </button>
                            <button
                                type="button"
                                class="btn btn-info float-right"
                                @click.prevent="
                                    editMode ? editUser() : createUser()
                                "
                            >
                                <span v-show="!editMode">Create</span>
                                <span v-show="editMode">Modify</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- ./v-if=isAdmin -->
        <!-- <div v-if="!$Role.isAdmin()">
            <not-found></not-found>
        </div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                repassword: "",
                roles: [],
                billaddr: "",
            }),
            roles: {
                allRoles: [],
                availRole: [],
                userRole: [],
                checkAvailRole: [],
                checkuserRole: [],
            },
            inprogress: false,
            editMode: false,
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
