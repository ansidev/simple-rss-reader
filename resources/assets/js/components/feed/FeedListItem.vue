<template>
    <div class="col-md-6">
        <div class="card flex-md-row mb-4 box-shadow h-md-250 feed-card">
            <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-primary">{{ data.category.name }}</strong>
                <h3 class="mb-0">
                    <a class="text-dark" :href="data.link">{{ data.title }}</a>
                </h3>
                <div class="mb-1 text-muted">{{ data.published_at }}</div>
                <p class="card-text mb-auto">{{ data.description }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a class="btn btn-success" :href="data.link" role="button">Read</a>
                        <a class="btn btn-warning" :href="'/feeds/' + data.id + '/edit'" role="button">Edit</a>
                        <a class="btn btn-danger" :href="'/feeds/' + data.id + '/delete'" role="button">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {
                required: true
            }
        },
        mounted() {
            console.log('Component mounted.');
        }
    }
</script>

<style scoped>
    .feed-card {
        height: 300px;
    }
</style>
