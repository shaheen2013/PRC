<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Sync Contacts</div>

                    <div class="card-body">
                        Hello {{ name ? name : '           ' }}
                       <button class="btn border-primary" @click="startContactSync">Begin Contact sync</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5 justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Sync Orgainizations</div>

                    <div class="card-body">
                        Hello {{ name ? name : '           ' }}
                        <button class="btn border-primary" @click="startOrganizationSync">Begin Organization sync</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5 justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Sync Communities</div>

                    <div class="card-body">
                        Hello {{ name ? name : '           ' }}
                        <button class="btn border-primary" @click="startCommunitySync">Begin Community sync</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SyncContacts",
        data: () => ({
            name: ''
        }),
        methods: {
            startContactSync() {
                axios.get('/api/startContactSync')
                    .then(function (response) {
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
            startOrganizationSync() {
                axios.get('/api/startOrganizationSync')
                    .then(function (response) {
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
            startCommunitySync() {
                axios.get('/api/startCommunitySync')
                    .then(function (response) {
                        console.log(response);
                    }.bind(this))
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            }
        }
    }
</script>

<style scoped>

</style>