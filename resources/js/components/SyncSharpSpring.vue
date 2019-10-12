<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Sync Contacts</div>
                    <div class="card-body">
                        {{ name ? name : '&nbsp           ' }}
                        <input v-model="leadId" type="number">
                       <button class="btn border-primary" @click="getLead">Begin Contact sync</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SyncSharpSpring",
        data: () => ({
            name: '',
            leadId: 614760105987
        }),
        methods: {
            getLead() {
                axios.post('/api/leadById', {
                    leadId: this.leadId
                })
                    .then(function (response) {
                        this.name = response.data;
                        console.log(response);
                    }.bind(this))
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
        }
    }
</script>

<style scoped>

</style>