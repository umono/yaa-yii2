import Request from './request'
import Auth from './../auth';
import router from '@/router';

const HttpCodes = {
    OK: 200,
    UNAUTHORIZED: 401,
    FORBIDDEN: 403,
    NOT_FOUND: 404,
    SERVICE: 500,
}

export default new Request({
    baseUrl: import.meta.env.APP_URL,
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
    },
    getClientId: () => {
        return Auth.getClientId()
    },
    getAccessToken: () => {
        return Auth.resetToken()
    },
    successHandler: (response: any) => {
        const Message = window.$message;
        let code = response.data.code;
        if (code == HttpCodes.UNAUTHORIZED) {
            Auth.setAccessToken(null);
            router.replace({
                path: '/admin/login',
                query: {
                    direct: router.currentRoute.value.fullPath
                }
            })
        }
        if (response.config.responseType === 'blob') {
            return Promise.resolve(response)
        }

        if (code != HttpCodes.OK) {
            if (response.data) {
                const data = response.data
                if (data.msg) {
                    Message.error(data.msg)
                } else if (Array.isArray(data)) {
                    data.forEach(function (item) {
                        Message.error(item.msg)
                    })
                } else if (data instanceof Blob) {
                    const blb = new Blob([data])
                    const reader = new FileReader()

                    reader.onloadend = (e: any) => {
                        const result = JSON.parse(e.currentTarget.result)
                        Message.error(result.msg)
                    }
                    reader.readAsText(blb)
                }
            }
            return Promise.reject(response.data);
        }
        return Promise.resolve(response.data);
    },
    errorHandler: (error: any) => {
        const Message = window.$message;
        if (error.response) {
            if (error.response.status != HttpCodes.OK) {
                if (error.response.data) {
                    const data = error.response.data
                    if (data.msg) {
                        Message.error(data.msg)
                    } else if (data instanceof Blob) {
                        const blb = new Blob([data])
                        const reader = new FileReader()

                        reader.onloadend = (e: any) => {
                            const result = JSON.parse(e.currentTarget.result)
                            Message.error(result.msg)
                        }
                        reader.readAsText(blb)
                    }
                } else {
                    Message.error(error.message)
                }
            }
        } else {
            Message.error(error.message)
        }
        return Promise.reject(error);
    }
});

