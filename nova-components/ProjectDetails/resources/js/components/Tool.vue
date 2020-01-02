<template>
    <div>
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <div id="projectInfo">
            <div v-if="project.loading">
                <i class="fa fa-spinner fa-spin" style="font-size:30px"></i>
            </div>
            <div v-if="!project.loading">
                <h2>Project Name: {{project.data.name}}</h2>
                <strong>ID #{{project.data.gid}}</strong>
                <br>
                <button v-if="!deleteProj" @click="deleteProject()" class="btn btn-default btn-danger">Delete Project</button>
                <i  v-if="deleteProj" class="fa fa-spinner fa-spin" style="font-size:30px"></i>
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
                    data:{}
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
                this.project.data = response.data.data;
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
