import cryptojs from "./cryptojs"
const clientIdItemKey = 'client-id'
const accessTokenItemKey = 'ACCESS_TOKEN'


const auth  = {
    getClientId() {
        return window.localStorage.getItem(clientIdItemKey)
    },

    setClientId(clientId: string) {
        window.localStorage.setItem(clientIdItemKey, clientId)
    },

    getAccessToken() {
        return window.localStorage.getItem(accessTokenItemKey)
    },
    
    resetToken() {
        const token = window.localStorage.getItem(accessTokenItemKey);
        if (token) {
            const str = cryptojs.Decrypt(token);
            const tokens = str.split(',');
            const timestr = (new Date()).valueOf() - 3000;
            const tokenStr = tokens[0] + ',' + tokens[1] + ',' + timestr;
            const res = cryptojs.Encrypt(tokenStr)
            return res;
        }
        return '';
    },

    setAccessToken(accessToken: string | null) {
        if (accessToken == null) {
            window.localStorage.removeItem(accessTokenItemKey)
        } else {
            window.localStorage.setItem(accessTokenItemKey, accessToken)
        }
    },
} 

export default auth;


