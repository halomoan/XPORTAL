<template>
    <div>
        <div v-if="$can('view users')">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul id="mainTab" class="nav nav-pills">
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
                                        <!-- <form class="form-horizontal" @submit.prevent="onCreateUser"> -->
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
                                                            )
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
                                                            )
                                                    }"
                                                    id="email"
                                                    v-model="form.email"
                                                    name="email"
                                                    placeholder="Email address"
                                                    required
                                                    @blur="onEmail"
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
                                                                )
                                                        }"
                                                        name="password"
                                                        v-model="form.password"
                                                        placeholder="Password"
                                                        required
                                                        v-on:keyup="
                                                            onRepassword()
                                                        "
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
                                                                )
                                                        }"
                                                        name="repassword"
                                                        v-model="
                                                            form.repassword
                                                        "
                                                        placeholder="Re-type Password"
                                                        required
                                                        v-on:keyup="
                                                            onRepassword()
                                                        "
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
                                            @submit.prevent="onCreateUser"
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
                                                                )
                                                        }"
                                                        id="billaddr"
                                                        v-model="
                                                            form.profile
                                                                .billaddr
                                                        "
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
                                                    @click.prevent="addUserRole"
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
                                                        removeUserRole
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
                                                            roles.checkUserRole
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
                                v-if="$can('add users') && !editMode"
                                type="button"
                                class="btn btn-info float-right"
                                @click.prevent="onCreateUser()"
                            >
                                Create
                            </button>
                            <button
                                v-if="$can('edit users') && editMode"
                                type="button"
                                class="btn btn-info float-right"
                                @click.prevent="onEditUser()"
                            >
                                Modify
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
const USER_API_URI = '/api/manage/user'
const ROLE_API_URI = '/api/manage/role'

export default {
    data() {
        return {
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                repassword: '',
                roles: null,
                profile: {
                    billaddr: ''
                }
            }),
            roles: {
                allRoles: [],
                availRole: [],
                userRole: [],
                checkAvailRole: [],
                checkUserRole: []
            },
            inprogress: false,
            editMode: false
        }
    },
    methods: {
        getRoles() {
            axios
                .get(ROLE_API_URI)
                .then(({ data }) => {
                    this.roles.allRoles = data
                    this.roles.availRole = this.roles.allRoles.filter(function (
                        item
                    ) {
                        //return item.is_enabled && !item.is_default
                        return true
                    })
                    this.roles.userRole = this.roles.allRoles.filter(function (
                        item
                    ) {
                        //return item.is_default
                        return false
                    })

                    //New or Edit User
                    const userId = this.$route.query.userId
                    if (typeof userId === 'undefined') {
                        this.editMode = false
                        this.form.reset()
                    } else if (userId) {
                        this.getUserData(userId)
                    } else {
                        this.editMode = false
                        this.form.reset()
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to retrieve Roles!',
                        footer: "<a href='/users'>Let me redo again</a>"
                    })
                })
        },
        getUserData(userId) {
            this.inprogress = true
            this.$Progress.start()
            axios
                .get(USER_API_URI + '/' + userId)
                .then(({ data }) => {
                    this.form = new Form(data)

                    if (data.roles && data.roles.length > 0) {
                        this.roles.userRole = data.roles
                        this.roles.availRole = _.differenceBy(
                            this.roles.availRole,
                            this.roles.userRole,
                            'id'
                        )
                    } else {
                        this.roles.userRole = []
                    }

                    //this.$forceUpdate();

                    this.editMode = true
                    this.inprogress = false
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.editMode = false
                    this.inprogress = false
                    this.form.reset()
                    this.$Progress.fail()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: "<a href='/users'>Let me redo again</a>"
                    })
                })
        },

        addUserRole() {
            if (!this.roles.availRole.length) {
                return
            }
            let selected = []
            for (var i in this.roles.checkAvailRole) {
                const idx = this.roles.checkAvailRole[i]

                selected.push(this.roles.availRole[idx])
            }

            this.roles.userRole = [
                //...new Set([...this.roles.userGroup, ...selected])
                ...this.roles.userRole,
                ...selected
            ]

            this.roles.availRole = _.differenceBy(
                this.roles.availRole,
                this.roles.userRole,
                'id'
            )
        },

        removeUserRole() {
            if (!this.roles.userRole.length) {
                return
            }
            let selected = []
            for (var i in this.roles.checkUserRole) {
                const idx = this.roles.checkUserRole[i]

                selected.push(this.roles.userRole[idx])
            }
            this.roles.availRole = [
                //...new Set([...this.groups.availGroup, ...selected])
                ...this.roles.availRole,
                ...selected
            ]

            this.roles.userRole = _.differenceBy(
                this.roles.userRole,
                this.roles.availRole,
                'id'
            )
        },
        onCreateUser() {
            this.form.roles = _.map(this.roles.userRole, 'id')
            this.inprogress = true
            this.form
                .post(USER_API_URI)
                .then(() => {
                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                    this.inprogress = false
                    Toast.fire({
                        icon: 'success',
                        title: 'User Created in successfully'
                    })

                    this.goBack()
                })
                .catch((e) => {
                    this.$Progress.fail()
                    this.inprogress = false
                    let message = e.response.data.message
                    const errors = e.response.data.errors

                    for (const error in errors) {
                        if (error === 'roles') {
                            for (const msg in errors[error]) {
                                message = errors[error][msg]
                            }
                            $('#mainTab a[href="#role"]').tab('show')
                        }
                    }

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
        },
        onEditUser() {
            this.form.roles = _.map(this.roles.userRole, 'id')

            this.$Progress.start()
            this.inprogress = true
            this.form
                .put(USER_API_URI + '/' + this.form.id)
                .then(() => {
                    this.$Progress.finish()
                    this.inprogress = false
                    Toast.fire({
                        icon: 'success',
                        title: 'User modified successfully'
                    })
                    this.goBack()
                })
                .catch((e) => {
                    this.$Progress.fail()
                    this.inprogress = false
                    let message = e.response.data.message
                    const errors = e.response.data.errors

                    for (const error in errors) {
                        if (error === 'roles') {
                            for (const msg in errors[error]) {
                                message = errors[error][msg]
                            }
                            $('#mainTab a[href="#role"]').tab('show')
                        }
                    }

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
        },
        onEmail() {
            const errors = this.form.errors
            if (
                /^\w+[+.\w-]*@([\w-]+.)*\w+[\w-]*.([a-z]{2,4}|\d+)$/.test(
                    this.form.email
                )
            ) {
                errors.clear('email')
            } else {
                errors.set('email', 'Please enter a valid email address')
            }
        },
        onRepassword() {
            const errors = this.form.errors
            if (this.form.password !== this.form.repassword) {
                errors.set('repassword', 'The password not match')
            } else {
                errors.clear('repassword')
            }
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push('/manage/user')
        }
    },

    mounted() {
        this.getRoles()
    }
}
</script>
