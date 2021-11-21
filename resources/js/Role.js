export default class Role {
    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.role === "admin";
    }

    isUser() {
        return this.user.role === "user";
    }

    isAdminOrUser() {
        //return this.user.type === "user" || this.user.type === "admin";
        return true;
    }
}
