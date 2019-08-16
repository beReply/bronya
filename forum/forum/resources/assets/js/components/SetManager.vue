<template>
    <button
            class="btn btn-default"
            v-bind:class="{'btn-success': isManager}"
            v-text="text"
            v-on:click="manager"
    >
    </button>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            this.$http.get('/api/authority/managers/' + this.user).then(response => {
                this.isManager = response.data.isManager
            })
        },
        data() {
            return {
                isManager: false
            }
        },
        computed: {
            text() {
                return this.isManager ? '取消管理' : '设为管理'
            }
        },
        methods: {
            manager() {
                this.$http.post('/api/authority/manager/set', {'user':this.user}).then(response => {
                    this.isManager = response.data.isManager
                })
            }
        }
    }
</script>
