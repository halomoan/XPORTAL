<template>
    <div>
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
                                                        form.errors.has('name')
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
                                                        form.errors.has('email')
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
                                                class="col-sm-2 col-form-label"
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
                                                    v-on:keyup="onRepassword()"
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
                                                class="col-sm-2 col-form-label"
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
                                                    v-model="form.repassword"
                                                    placeholder="Re-type Password"
                                                    required
                                                    v-on:keyup="onRepassword()"
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
                                                class="col-sm-2 col-form-label"
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
                                                        form.profile.billaddr
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
                                <!-- /.form -->
                            </div>
                            <!-- /.tab-content -->
                            <div class="overlay" v-if="inprogress">
                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                <div class="text-bold pl-2">Loading...</div>
                            </div>
                        </div>
                        <!-- /.overlay-wrapper -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button
                            v-if="$can('edit users') && editMode"
                            type="button"
                            class="btn btn-secondary float-right"
                            @click.prevent="onEditUser()"
                        >
                            Modify
                        </button>
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
const PROFILE_API_URI = '/api/manage/profile'

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
            inprogress: false,
            editMode: true
        }
    },
    methods: {
        getUserData() {
            this.inprogress = true
            this.$Progress.start()
            axios
                .get(PROFILE_API_URI)
                .then(({ data }) => {
                    this.form = new Form(data)

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

        onEditUser() {
            this.$Progress.start()
            this.inprogress = true
            this.form
                .post(PROFILE_API_URI)
                .then(() => {
                    this.$Progress.finish()
                    this.inprogress = false
                    Toast.fire({
                        icon: 'success',
                        title: 'User modified successfully'
                    })
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
        }
    },

    mounted() {
        this.getUserData()
    }
}
</script>
