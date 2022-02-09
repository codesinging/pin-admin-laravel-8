<template>
    <div class="h-screen flex items-center justify-center">
        <el-card header="管理员登录" class="w-96">
            <el-form :model="data" :rules="rules" ref="form">
                <el-form-item prop="mobile">
                    <el-input v-model="data.mobile">
                        <template #prepend>
                            <div class="w-14 text-center">手机号码</div>
                        </template>
                    </el-input>
                </el-form-item>

                <el-form-item prop="password">
                    <el-input v-model="data.password" show-password>
                        <template #prepend>
                            <div class="w-14 text-center">密码</div>
                        </template>
                    </el-input>
                </el-form-item>

                <div class="flex items-center justify-center">
                    <el-button @click="onSubmit" :loading="state.states.loading" type="primary" class="w-full">登录</el-button>
                </div>
            </el-form>
        </el-card>
    </div>
</template>

<script setup>
import {reactive, ref} from "vue";
import useState from "../../js/store/state";
import message from "../../js/utils/message";
import apis from "../../apis";

const state = useState()

const data = reactive({
    mobile: '',
    password: '',
})

const rules = {
    mobile: [
        {required: true, message: '手机号码不能为空'}
    ],
    password: [
        {required: true, message: '登录密码不能为空'}
    ],
}

const form = ref()

const onSubmit = () => {
    form.value.validate(valid => {
        if (valid){
            apis.auth.login(data).then(res=>{
                console.log(res)
            })
        } else {
            message.warning('表单验证失败')
        }
    })
}

</script>

<style scoped>
</style>
