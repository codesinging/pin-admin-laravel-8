<template>
    <div class="h-screen flex items-center justify-center">
        <el-card header="管理员登录" class="w-96">
            <el-form>
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

const state = useState()

const data = reactive({
    mobile: '',
    password: '',
})

const onSubmit = () => {
    state.set('loading')

    setTimeout(() => {
        state.unset('loading')
    }, 3000)
}

const onSetOtherState = () => {
    state.set('refreshing', 2)

    setTimeout(() => {
        state.unset('refreshing', 2)
    }, 4000)
}

</script>

<style scoped>
</style>
