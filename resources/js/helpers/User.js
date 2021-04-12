class User{

    storeUser(user){
        localStorage.setItem('user', user);
    }

    getUser(){
        return JSON.parse(localStorage.getItem('user'));
    }

    isLogged(){
        return this.getUser() !== null ? this.getUser() : false;
    }

    isAdmin(){
        return this.isLogged().admin ? true : false;
    }

    logout(){
        localStorage.removeItem('user');
    }

}
export default User = new User();