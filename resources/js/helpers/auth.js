//import { setAuthorization } from "./general";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then((respose)=> {
               // setAuthorization(response.data.access_token);
                res(respose.data)
            })
            .catch((err)=> {
                rej("Wrong email or password")
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user")

    if(!userStr) {
        return null
    }
    return JSON.parse(userStr)
}