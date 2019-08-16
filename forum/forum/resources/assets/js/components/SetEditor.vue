<template>
    <button
            class="btn btn-default"
            v-bind:class="{'btn-success': isEditor}"
            v-text="text"
            v-on:click="manager"
    >
    </button>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            this.$http.get('/api/authority/editors/' + this.user).then(response => {
                this.isEditor = response.data.isEditor
            })
        },
        data() {
            return {
                isEditor: false
            }
        },
        computed: {
            text() {
                return this.isEditor ? '取消编辑' : '设为编辑'
            }
        },
        methods: {
            manager() {
                this.$http.post('/api/authority/editor/set', {'user':this.user}).then(response => {
                    this.isEditor = response.data.isEditor
                })
            }
        }
    }
</script>
