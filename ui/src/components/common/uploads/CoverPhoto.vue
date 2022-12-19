<template>
    <n-image width="200" height="200" class="mb-2 mt-8" :src="src" v-if="src" object-fit="cover" />
    <div class="border-dashed border border-gray-300 mb-2 mt-8" style="width:180px;height:180px;" v-else></div>
    <n-upload :action="url" :headers="headers" @finish="handleFinish" :name="fileName" :show-file-list="false">
        <n-button>上传文件</n-button>
    </n-upload>
</template>

<script lang="ts">
import Auth from "@/utils/auth";
import type { UploadFileInfo } from 'naive-ui'

export default defineComponent({
    props: ['src', 'fileName'],
    emits: ['upSuccess'],
    setup(props, ctx) {
        const headers = ref({
            'X-Access-Token': Auth.getAccessToken(),
            'X-Client-Id': Auth.getClientId(),
        } as any);
        let fileName = props.fileName;
        if (!fileName) {
            fileName = 'img';
        }

        const handleFinish = ({
            file,
            event
        }: {
            file: UploadFileInfo
            event?: ProgressEvent
        }) => {
            const e: any = event?.target
            const res = JSON.parse(e.response);
            console.log(res)
            if (res.code != 200) {
                return window.$message.error(res.msg || "上传失败:(")
            }
            ctx.emit('upSuccess', res.data.url);
            return file
        }
        return {
            fileName,
            url: Auth.getApiUrl() + 'admin/api/upload/photo',
            headers,
            handleFinish,
        }
    },
    methods: {
        uploadFile() {

        },
    }
})
</script>