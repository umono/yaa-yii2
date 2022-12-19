<template>
    <div class="site">
        <div class="login-container">
            <css-doodle class="bg">
                :doodle {
                @grid: 8 / 90%;
                }

                transition: .2s @r(.6s);
                border-radius: @pick(100% 0, 0 100%);
                transform: scale(@r(.25, 1.25));

                background: hsla(
                calc(240 - 6 * @x * @y),
                70%, 68%, @r.8
                );
            </css-doodle>
            <div class="login-box">
                <div class="hero">
                    <h1> <span style="font-weight:300;"> 专注于学习的平台</span><br> <span>Yaa</span></h1>
                    <div class="contact-me">
                        <span>
                            如果您没有账号,或许您需要帮助
                        </span>
                        <br />
                        <span>
                            您需要尝试 <a>联系我们</a>
                        </span>
                    </div>
                </div>

                <div class="login-form">
                    <h1>嗨，欢迎回来</h1>
                    <n-form ref="loginForm" size="large">
                        <n-form-item>
                            <n-input class="item" v-model:value="phone" placeholder="请输入注册手机号码"
                            :input-props="{ autocomplete: 'off' }" />
                        </n-form-item>
                        <n-form-item>
                            <n-input class="item" v-model:value="password" type="password" placeholder="请输入密码"
                            :input-props="{ autocomplete: 'off' }" />
                        </n-form-item>
                        <n-form-item v-if="captchaImg" class="captcha-card">
                            <n-card>
                                <img :src="captchaImg" alt="" srcset="">
                                <n-input class="item" v-model:value="captchaCode" placeholder="请输入验证码" :input-props="{ autocomplete: 'off' }" />
                            </n-card>
                        </n-form-item>
                        <n-form-item>
                            <n-button class="item submit" style="width:100%" type="primary" size="large" :loading="loading"
                                @click="loginGo">登录</n-button>
                        </n-form-item>

                    </n-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import 'css-doodle';
import { defineComponent, ref, } from 'vue';
interface LoginFormType {
    phone: string | null
    password: string | null,
}

export default defineComponent({
    setup() {
        const loginForm = ref<LoginFormType>({
            phone: null,
            password: null,
        })
        return {
            loginForm,
            loading: ref(false),
            phone: ref(''),
            password: ref(''),
            captchaImg: ref(''),
            captchaCode: ref(''),

        }
    },
    methods: {
        async loginGo() {
            const param = {
                account: this.phone,
                password: this.password,
                captchaCode: this.captchaCode
            }
            if (!param.account || !param.password) {
                return window.$message.warning("请输入账户与密码！");
            }
            this.loading = true;
            const { data } = await this.$http.post('admin/api/auth/login', param);
            if (data) {
                if (data.haveErr == false) {
                    this.$store.dispatch("auth/login", data.userInfo);
                    window.$message.success("登录成功");
                    this.$router.replace('/admin/home');
                } else {
                    window.$message.error(data.errMsg);
                    this.captchaImg = data.captchaImg;
                    this.captchaCode = '';
                }
            }
            this.loading = false;
        }
    }
})
</script>

<style lang="scss" scoped>
$boxShadow: #2080f0 0 20px 30px -10px;
$boxShadowHover: #2080f0 0 10px 30px -10px;

.site {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.login-container {
    max-width: 1000px;
    width: 100%;
    padding: 0 30px;
    margin: 0 auto;
    position: relative;

    .bg {
        position: absolute;
        width: 350px;
        height: 350px;
        z-index: -2;
        display: none;
    }
}

.login-box {
    display: flex;
    flex-wrap: wrap;

    .hero {
        flex: 1 0 66.6666%;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 50px;
        padding: 70px 0;
        font-family: "SF Pro SC", "SF Pro Display", "SF Pro Icons", "PingFang SC", "Helvetica Neue", "Helvetica", "Arial", sans-serif;

        h1 {
            font-size: 48px;
            font-weight: 400;
        }
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 15%;
        left: 0;
        width: 280px;
        height: 100px;
        background: -webkit-linear-gradient(to right, #ec2F4B, #009FFF);
        background: linear-gradient(to right, #ec2F4B, #009FFF);

        z-index: -1;
        filter: blur(70px);
    }

    .contact-me {
        position: relative;
        top: -50px;
        font-size: 21px;
        font-weight: 300;

        a {
            color: #0057ff;
            // color: #1177FF;
            cursor: pointer;
        }
    }

    .item {
        height: 50px;
        border-radius: 10px;
        line-height: 50px;
    }

    :deep(.n-form-item-feedback-wrapper) {
        display: none !important;
    }

    .captcha-card {
        :deep(.n-card__content) {
            // padding:10px;
            border-radius: 10px;
            // display: flex !important;
        }

        :deep(.n-card.n-card--bordered) {
            border: 1px solid rgb(224, 224, 230);
            border-radius: 10px;
        }
    }

    .login-form {
        flex: 1 0 33.3333%;

        h1 {
            font-weight: 300;
        }
    }

    .submit {
        box-shadow: $boxShadow;
        font-weight: 700 !important;
        font-size: 17px;
        transition: all 0.5s;
        background: #0057ff;

    }

    .submit:hover {
        box-shadow: $boxShadowHover;
    }
}
</style>