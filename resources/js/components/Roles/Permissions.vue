<template>
    <div>
        <div v-if="$Role.isAdmin()">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">User Permission</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <div class="row">
                        <table class="table table-borderless">
                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="view_invoices"
                                        style="width: 20px; height: 20px"
                                    />
                                    <label for="view_invoice"
                                        >View: Invoice</label
                                    >
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        class="form-check-input"
                                        style="width: 20px; height: 20px"
                                        id="add_invoices"
                                    />
                                    <label for="add_invoice"
                                        >Add: Invoice</label
                                    >
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="delete_invoices"
                                    />
                                    <label for="delete_invoice"
                                        >Delete: Invoice</label
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="view_user"
                                    />
                                    <label for="view_user">View: Users</label>
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="add_user"
                                    />
                                    <label for="add_user">Add: Users</label>
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="delete_user"
                                    />
                                    <label for="delete_user"
                                        >Delete: User</label
                                    >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="view_role"
                                    />
                                    <label for="view_role">View: Roles</label>
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="add_role"
                                    />
                                    <label for="add_role">Add: Role</label>
                                </td>
                                <td>
                                    <input
                                        type="checkbox"
                                        checked=""
                                        id="delete_role"
                                    />
                                    <label for="delete_role"
                                        >Delete: Role</label
                                    >
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
export default {
    created() {
        console.log('Component mounted.')
    }
}
</script>
