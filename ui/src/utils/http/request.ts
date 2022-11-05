import axios from 'axios'

class Request {
    httpClient: any
    constructor(options: any) {
        const opt = {
            ...{
                baseUrl: '',
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                params: {},
                timeout: 9000000,
                withCredentials: false,
                responseType: 'json',
                maxContentLength: 2000,
                validateStatus: function (status: any) {
                    return status >= 200 && status < 500
                },
                maxRedirects: 3,
                data: {},
                getClientId() {
                    return null
                },
                getAccessToken() {
                    return null
                },
                successHandler: (response: any) => {
                    Promise.resolve(response)
                },
                errorHandler: (error: any) => {
                    Promise.reject(error)
                }
            },
            ...options
        }

        const httpClient = axios.create({
            baseURL: opt.baseUrl,
            timeout: opt.timeout,
            withCredentials: opt.withCredentials
        })

        httpClient.interceptors.request.use((config: any) => {
            const clientId = opt.getClientId()

            if (clientId) {
                config.headers['X-Client-Id'] = clientId
            }

            const accessToken = opt.getAccessToken()

            if (accessToken) {
                config.headers['X-Access-Token'] = accessToken
            }

            config.headers['admin-campus-id'] = window.localStorage.getItem('admin_campus_id')

            return config
        })

        httpClient.interceptors.response.use((response) => {
            return opt.successHandler(response)
        }, (error) => opt.errorHandler(error));

        this.httpClient = httpClient;
    }

    public request(method: string, url: any, params = null, data = null) {
        const config: any = {}
        config.url = url;
        config.method = method;

        if (params) {
            config.params = params
        }

        if (data) {
            config.data = data
        }

        return this.httpClient.request(config)
            .then((r: any) => {
                return {
                    ...r,
                    error: null
                };
            }).catch((err: any) => {
                return {
                    err,
                    data: null
                };
            })
    }

    public get(url: any, params = null) {
        return this.request('GET', url, params)
    }

    public head(url: any, params = null) {
        return this.request('HEAD', url, params)
    }

    public post(url: any, data: any = null, params: any = null) {
        return this.request('POST', url, params, data)
    }

    public put(url: any, data = null, params = null) {
        return this.request('PUT', url, params, data)
    }

    public path(url: any, data = null, params = null) {
        return this.request('PATH', url, params, data)
    }

    public delete(url: any, data = null, params = null) {
        return this.request('DELETE', url, params, data)
    }

    public download(method: any, url: any, params: any = null, data: any = null, fileName: any = null) {

        const config: any = {};
        config.url = url;
        config.method = method;
        config.timeout = 90000000000;
        config.responseType = 'blob'

        if (params) {
            config.params = params
        }

        if (data) {
            config.data = data
        }

        return this.httpClient.request(config).then((response: { headers: { [x: string]: any; }; data: BlobPart; }) => {
            let _filename = response.headers['x-suggested-filename'];

            console.log(_filename);
            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('target', "_blank");
            const _name = (fileName || '') + _filename;
            link.setAttribute('download', decodeURIComponent(_name))
            link.click()
            window.URL.revokeObjectURL(url)
            return true
        }).catch(() => {
            return false;
        })
    }
}

export default Request
