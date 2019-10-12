<template>
    <div>
        <a @click.prevent="displayLink" href="#">
            <span>
                Share Link
            </span>
        </a>
    </div>
</template>

<script>
    import Swal from 'sweetalert2';
    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],
        mounted: () => {

        },
        computed: {
            shareLink: function () {
                if (this.resource) {
                    let kebabFullName = _.kebabCase(this.getFieldByAttribute('FULLNAME').value);
                    let kebabCounty = _.kebabCase(this.getFieldByAttribute('COUNTY').value);
                    let state = this.getFieldByAttribute('STATE').value;
                    return "https://community.prochamps.com/" + state + "/" + kebabCounty + "/" + kebabFullName;
                } else {
                    return ""
                }
            },
            rentalShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/rental";
                } else {
                    return ""
                }
            },
            vacantShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/vacant";
                } else {
                    return ""
                }
            },
            foreclosureShareLink: function () {
                if (this.shareLink !== "" || this.shareLink !== null) {
                    return this.shareLink + "/foreclosure";
                } else {
                    return ""
                }
            }
        },
        methods: {
            getFieldByAttribute(attribute) {
                if (this.resource !== null) {
                    return _.find(this.resource.fields, function (field) {
                        return field.attribute === attribute;
                    });
                } else {
                    return null
                }
            },
            displayLink () {
                Swal.fire({
                    title: "Community Share Links",
                    html: `
                        <div>
                            <span>${this.shareLink}</span>
                            <br>
                            <span>${this.rentalShareLink}</span>
                            <br>
                            <span>${this.vacantShareLink}</span>
                            <br>
                            <span>${this.foreclosureShareLink}</span>
                        </div>
                    `,
                    width: 850,
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Close'
                })
            }
        }
    }
</script>

<style scoped>

</style>