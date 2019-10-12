<template>
    <panel-item :field="field">
        <template slot="value">
            <share-link :field="field" :resource="resource"></share-link>
        </template>
    </panel-item>
</template>

<script>
    import ShareLink from "./ShareLink"
    export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    components: {
        'share-link': ShareLink
    },
}
</script>
