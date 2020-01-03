<template>
    <div>
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <h5 style="font-size: 15px;color: rgb(156, 155, 155);width: 100%;text-align: right;">
            <button v-if="!deleteProj" @click="deleteProject()" class="btn btn-default btn-danger">Delete Project</button>
            <i  v-if="deleteProj" class="fa fa-spinner fa-spin" style="font-size:30px"></i>
        </h5>
        <div id="projectInfo">
            <div v-if="project.loading">
                <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>
            </div>
            <div v-if="!project.loading">
                <h2 style="color: #0a4c9e">Project Name: {{project.data.name}}</h2>
                <strong style="color:#9c9b9b; padding:5px 0px">ID #{{project.data.gid}}</strong>
                <br>
                <strong style="color:#9c9b9b">Created At #{{((project.local.created_at).split(' '))[0]}}</strong>
                <br>
                <br>
                <br>
                <h2 style="color: #22292f">Project Owner: {{project.data.owner.name}}</h2>
                <strong style="color:#9c9b9b; padding:5px 0px">Owner ID #{{project.data.owner.gid}}</strong>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'resourceId', 'field'],
    data: function () {
            return {
                project: {
                    loading: true,
                    data:{},
                    local: {}
                },
                deleteProj: false
            }
        },
    methods: {
        loadCommunity() {
            console.log('resourceId', this.resourceId)
            console.log('field', this.field)
            console.log('resourceName', this.resourceName);
            Nova.request().get(`/nova-vendor/project-details/loadCommunity/${this.resourceId}`).then(response => {
                console.log(response);
                this.project.loading = false;
                this.project.data = response.data.project.data;
                this.project.local = response.data.projLocal;
                console.log(response.data.projLocal)
            });
        },
        deleteProject(){
            this.deleteProj = true;
            Nova.request().post('/nova-vendor/project-details/deleteCommunity', {projectId:this.resourceId}).then(response => {
                console.log(response);
                window.location.href = `${window.location.origin}/admin/resources/projects`;
            });
        }
    },

    mounted() {
        this.loadCommunity();
    },
}
</script>
<style scoped>
    .projectInfo {
        color: red;
    }
</style>